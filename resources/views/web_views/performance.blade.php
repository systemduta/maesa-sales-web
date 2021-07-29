<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Performance</title>
{{--    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>--}}
    <script src="{{ asset('AdminLTE') }}/plugins/zingchart/zingchart.min.js"></script>
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
        }

        #myChart {
            height: 100%;
            width: 100%;
            /*min-height: 150px;*/
        }
    </style>
</head>

<body>
<div id='myChart'></div>

<script>
    var step = {{ app('request')->input('low') ?? 3 }};
    var achieved = {{ app('request')->input('achieved') ?? 0 }};

    var myConfig = {
        type: "gauge",
        globals: {
            fontSize: 25
        },
        plotarea: {
            marginTop: 80
        },
        plot: {
            size: '100%',
            valueBox: {
                placement: 'center',
                text: '%v', //default
                fontSize: 35,
                rules: [
                    {
                        rule: '%v >= '+(step*3),
                        text: '%v<br>EXCELLENT'
                    },
                    {
                        rule: '%v < '+(step*3)+' && %v >= '+(step*2),
                        text: '%v<br>Good'
                    },
                    {
                        rule: '%v < '+ +(step*2) +' && %v >= '+(step*1),
                        text: '%v<br>Fair'
                    },
                    {
                        rule: '%v < '+(step*1),
                        text: '%v<br>Bad'
                    }
                ]
            }
        },
        tooltip: {
            borderRadius: 5
        },
        scaleR: {
            aperture: 180,
            minValue: 0,
            maxValue: step*4,
            step: step,
            center: {
                visible: false
            },
            tick: {
                visible: false
            },
            item: {
                offsetR: 0,
                rules: [{
                    rule: '%i == 9',
                    offsetX: 15
                }]
            },
            ring: {
                size: 50,
                rules: [
                    {
                        rule: '%v < '+(step*1),
                        backgroundColor: '#E53935'
                    },
                    {
                        rule: '%v >=' + (step*1) + '&& %v < '+(step*2),
                        backgroundColor: '#FFA726'
                    },
                    {
                        rule: '%v >= ' + (step*2) + ' && %v < 10' + (step*3),
                        backgroundColor: '#29B6F6'
                    },
                    {
                        rule: '%v >= ' + (step*3),
                        backgroundColor: '#1ab394'
                    }
                ]
            }
        },
        series: [{
            values: [achieved > (step*4) ? step*4 : achieved], // starting value
            backgroundColor: 'black',
            indicator: [10, 10, 10, 10, 0.7],
            animation: {
                effect: 2,
                method: 1,
                sequence: 4,
                speed: 900
            },
        }]
    };
    zingchart.render({
        id: 'myChart',
        data: myConfig,
        height: 500,
        width: '100%'
    });
</script>
</body>

</html>
