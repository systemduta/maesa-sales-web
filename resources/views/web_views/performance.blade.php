<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Performance</title>
    <script src="{{ asset('AdminLTE') }}/plugins/chart.js/Chart.bundle.js"></script>
    <script src="{{ asset('AdminLTE') }}/plugins/chart.js/chartjs-gauge.js"></script>
    <script src="{{ asset('AdminLTE') }}/plugins/chart.js/chartjs-plugin-datalabels.js"></script>
{{--    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>--}}
{{--    <script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>--}}
{{--    <script src="https://unpkg.com/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.js"></script>--}}
</head>

<body style="overflow: hidden">
<div id="canvas-holder" style="width:100%">
    <canvas id="chart"></canvas>
</div>
<script>

    var achieved = {{ app('request')->input('achieved') ?? 0 }};
    var low = {{ app('request')->input('low') ?? 3 }};
    var middle = {{ app('request')->input('middle') ?? 5 }};
    var high = {{ app('request')->input('high') ?? 10 }};

    var config = {
        type: 'gauge',
        data: {
            labels: [low, middle, high],
            datasets: [{
                data: [low, middle, high],
                value: achieved > high ? high : achieved,
                backgroundColor: ['red', 'green', 'orange'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            title: {
                display: false,
                // text: 'Gauge chart with datalabels plugin'
            },
            layout: {
                padding: {
                    bottom: 30
                }
            },
            needle: {
                radiusPercentage: 2,
                widthPercentage: 3.2,
                lengthPercentage: 80,
                color: 'rgba(0, 0, 0, 1)'
            },
            valueLabel: {
                formatter: Math.round,
                backgroundColor: 'rgba(0, 0, 0, 1)',
                fontSize: 24,
                color: 'rgb(255,255,255)',
                borderRadius: 50,
                padding: {
                    top: 10,
                    right: 15,
                    bottom: 10,
                    left: 15
                }
            },
            plugins: {
                datalabels: {
                    display: true,
                    formatter: function (value, context) {
                        return context.chart.data.labels[context.dataIndex];
                    },
                    color: function (context) {
                        return context.dataset.backgroundColor;
                    },
                    backgroundColor: null,
                    font: {
                        size: 20,
                        weight: 'bold'
                    },
                    color: 'rgba(0, 0, 0, 1.0)'
                    //color: 'rgba(255, 255, 255, 1.0)',
                }
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById('chart').getContext('2d');
        window.myGauge = new Chart(ctx, config);
    };
</script>
</body>
</html>





{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="utf-8">--}}
{{--    <meta content="width=device-width, initial-scale=1.0" name="viewport">--}}
{{--    <title>Performance</title>--}}
{{--    <link rel="stylesheet" href="{{ asset('AdminLTE') }}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">--}}
{{--    <script src="{{ asset('AdminLTE') }}/plugins/zingchart/zingchart.min.js"></script>--}}
{{--    <style>--}}
{{--        html,--}}
{{--        body {--}}
{{--            height: 100%;--}}
{{--            width: 100%;--}}
{{--            overflow: hidden;--}}
{{--        }--}}

{{--        #myChart {--}}
{{--            height: 100%;--}}
{{--            width: 100%;--}}
{{--            /*min-height: 150px;*/--}}
{{--        }--}}
{{--    </style>--}}
{{--</head>--}}

{{--<body>--}}
{{--<div class="container">--}}
{{--    <div class="row" style="margin-top: 25px;">--}}
{{--        <div class="col-sm">--}}
{{--            <div id='myChart'></div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script>--}}
{{--    var achieved = {{ app('request')->input('achieved') ?? 0 }};--}}
{{--    var step = {{ app('request')->input('step') ?? 3 }};--}}
{{--    var low = {{ app('request')->input('low') ?? 3 }};--}}
{{--    var middle = {{ app('request')->input('middle') ?? 6 }};--}}
{{--    var high = {{ app('request')->input('high') ?? 9 }};--}}
{{--    var max = {{ app('request')->input('max') ?? 12 }};--}}

{{--    var myConfig = {--}}
{{--        type: "gauge",--}}
{{--        globals: {--}}
{{--            fontSize: 25--}}
{{--        },--}}
{{--        plotarea: {--}}
{{--            marginTop: 80--}}
{{--        },--}}
{{--        plot: {--}}
{{--            size: '100%',--}}
{{--            valueBox: {--}}
{{--                placement: 'center',--}}
{{--                text: '%v', //default--}}
{{--                fontSize: 35,--}}
{{--                // rules: [--}}
{{--                //     {--}}
{{--                //         rule: '%v >= '+(step*3),--}}
{{--                //         text: '%v<br>EXCELLENT'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v < '+(step*3)+' && %v >= '+(step*2),--}}
{{--                //         text: '%v<br>Good'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v < '+ +(step*2) +' && %v >= '+(step*1),--}}
{{--                //         text: '%v<br>Fair'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v < '+(step*1),--}}
{{--                //         text: '%v<br>Bad'--}}
{{--                //     }--}}
{{--                // ]--}}
{{--                rules: [--}}
{{--                    {--}}
{{--                        rule: '%v >= '+high,--}}
{{--                        text: '%v<br>EXCELLENT'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v < '+high+' && %v >= '+middle,--}}
{{--                        text: '%v<br>Good'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v < '+ middle +' && %v >= '+low,--}}
{{--                        text: '%v<br>Fair'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v < '+low,--}}
{{--                        text: '%v<br>Bad'--}}
{{--                    }--}}
{{--                ]--}}
{{--            }--}}
{{--        },--}}
{{--        tooltip: {--}}
{{--            borderRadius: 5--}}
{{--        },--}}
{{--        scaleR: {--}}
{{--            aperture: 180,--}}
{{--            minValue: 0,--}}
{{--            maxValue: max,--}}
{{--            // step: step,--}}
{{--            center: {--}}
{{--                visible: false--}}
{{--            },--}}
{{--            tick: {--}}
{{--                visible: false--}}
{{--            },--}}
{{--            item: {--}}
{{--                offsetR: 0,--}}
{{--                rules: [{--}}
{{--                    rule: '%i == 9',--}}
{{--                    offsetX: 15--}}
{{--                }]--}}
{{--            },--}}
{{--            ring: {--}}
{{--                size: 50,--}}
{{--                // rules: [--}}
{{--                //     {--}}
{{--                //         rule: '%v < '+(step*1),--}}
{{--                //         backgroundColor: '#E53935'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v >=' + (step*1) + '&& %v < '+(step*2),--}}
{{--                //         backgroundColor: '#FFA726'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v >= ' + (step*2) + ' && %v < 10' + (step*3),--}}
{{--                //         backgroundColor: '#29B6F6'--}}
{{--                //     },--}}
{{--                //     {--}}
{{--                //         rule: '%v >= ' + (step*3),--}}
{{--                //         backgroundColor: '#1ab394'--}}
{{--                //     }--}}
{{--                // ]--}}
{{--                rules: [--}}
{{--                    {--}}
{{--                        rule: '%v < '+low,--}}
{{--                        backgroundColor: '#E53935'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v >=' + low + '&& %v < '+middle,--}}
{{--                        backgroundColor: '#FFA726'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v >= ' + middle + ' && %v < 10' + high,--}}
{{--                        backgroundColor: '#29B6F6'--}}
{{--                    },--}}
{{--                    {--}}
{{--                        rule: '%v >= ' + high,--}}
{{--                        backgroundColor: '#1ab394'--}}
{{--                    }--}}
{{--                ]--}}
{{--            }--}}
{{--        },--}}
{{--        series: [{--}}
{{--            values: [achieved > max ? max : achieved], // starting value--}}
{{--            backgroundColor: 'black',--}}
{{--            indicator: [10, 10, 10, 10, 0.7],--}}
{{--            animation: {--}}
{{--                effect: 2,--}}
{{--                method: 1,--}}
{{--                sequence: 4,--}}
{{--                speed: 900--}}
{{--            },--}}
{{--        }]--}}
{{--    };--}}
{{--    zingchart.render({--}}
{{--        id: 'myChart',--}}
{{--        data: myConfig,--}}
{{--        height: 500,--}}
{{--        width: '100%'--}}
{{--    });--}}
{{--</script>--}}
{{--</body>--}}

{{--</html>--}}
