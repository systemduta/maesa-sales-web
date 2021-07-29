<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Performance</title>
    <script src="https://unpkg.com/chart.js@2.8.0/dist/Chart.bundle.js"></script>
    <script src="https://unpkg.com/chartjs-gauge@0.3.0/dist/chartjs-gauge.js"></script>
    <script src="https://unpkg.com/chartjs-plugin-datalabels@0.7.0/dist/chartjs-plugin-datalabels.js"></script>
</head>

<body>
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
                value: achieved,
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

{{--<script>--}}
{{--    var randomScalingFactor = function() {--}}
{{--        return Math.round(Math.random() * 100);--}}
{{--    };--}}

{{--    var randomData = function () {--}}
{{--        return [--}}
{{--            randomScalingFactor(),--}}
{{--            randomScalingFactor(),--}}
{{--            randomScalingFactor(),--}}
{{--            randomScalingFactor()--}}
{{--        ];--}}
{{--    };--}}

{{--    var randomValue = function (data) {--}}
{{--        return Math.max.apply(null, data) * Math.random();--}}
{{--    };--}}

{{--    var data = randomData();--}}
{{--    var value = randomValue(data);--}}

{{--    var config = {--}}
{{--        type: 'gauge',--}}
{{--        data: {--}}
{{--            labels: ['Success', 'Warning', 'Warning', 'Fail'],--}}
{{--            datasets: [{--}}
{{--                data: data,--}}
{{--                value: value,--}}
{{--                backgroundColor: ['green', 'yellow', 'orange', 'red'],--}}
{{--                borderWidth: 2--}}
{{--            }]--}}
{{--        },--}}
{{--        options: {--}}
{{--            responsive: true,--}}
{{--            title: {--}}
{{--                display: true,--}}
{{--                text: 'Gauge chart with datalabels plugin displaying labels'--}}
{{--            },--}}
{{--            layout: {--}}
{{--                padding: {--}}
{{--                    bottom: 30--}}
{{--                }--}}
{{--            },--}}
{{--            needle: {--}}
{{--                // Needle circle radius as the percentage of the chart area width--}}
{{--                radiusPercentage: 2,--}}
{{--                // Needle width as the percentage of the chart area width--}}
{{--                widthPercentage: 3.2,--}}
{{--                // Needle length as the percentage of the interval between inner radius (0%) and outer radius (100%) of the arc--}}
{{--                lengthPercentage: 80,--}}
{{--                // The color of the needle--}}
{{--                color: 'rgba(0, 0, 0, 1)'--}}
{{--            },--}}
{{--            valueLabel: {--}}
{{--                display: false--}}
{{--            },--}}
{{--            plugins: {--}}
{{--                datalabels: {--}}
{{--                    display: true,--}}
{{--                    formatter:  function (value, context) {--}}
{{--                        return context.chart.data.labels[context.dataIndex];--}}
{{--                    },--}}
{{--                    //color: function (context) {--}}
{{--                    //  return context.dataset.backgroundColor;--}}
{{--                    //},--}}
{{--                    color: 'rgba(0, 0, 0, 1.0)',--}}
{{--                    //color: 'rgba(255, 255, 255, 1.0)',--}}
{{--                    backgroundColor: null,--}}
{{--                    font: {--}}
{{--                        size: 20,--}}
{{--                        weight: 'bold'--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    };--}}

{{--    window.onload = function() {--}}
{{--        var ctx = document.getElementById('chart').getContext('2d');--}}
{{--        window.myGauge = new Chart(ctx, config);--}}
{{--    };--}}

{{--    document.getElementById('randomizeData').addEventListener('click', function() {--}}
{{--        config.data.datasets.forEach(function(dataset) {--}}
{{--            dataset.data = randomData();--}}
{{--            dataset.value = randomValue(dataset.data);--}}
{{--        });--}}

{{--        window.myGauge.update();--}}
{{--    });--}}
{{--</script>--}}
</body>
</html>
