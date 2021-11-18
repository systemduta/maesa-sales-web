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
                backgroundColor: ['red', 'orange', 'green'],
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
                formatter: function (value, context) {
                    return Math.round(value).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
                },
                fontSize: 16,
                fontWeight: 'bold',
                backgroundColor: '#d57f00',
                color: 'rgb(255,255,255)',
                borderRadius: 5,
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
                        return Math.round(value).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
                    },
                    color: function (context) {
                        return context.dataset.backgroundColor;
                    },
                    backgroundColor: null,
                    font: {
                        size: 14,
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
