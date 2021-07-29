<html>
<head>
    <meta charset="utf-8" />
    <style>
        body {
            margin:50px 0px; padding:0px;
            text-align:center;
        }
    </style>
    <script src="{{ asset('AdminLTE') }}/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/globalize/0.1.1/globalize.min.js"></script>
</head>
<body>
<div id="circularGaugeContainer" style="height:400px;margin:0 auto"></div>
<script>
    $("#circularGaugeContainer").dxCircularGauge({
        rangeContainer: {
            offset: 10,
            ranges: [
                { startValue: 800, endValue: 1000, color: '#41A128' },
                { startValue: 1000, endValue: 1500, color: '#2DD700' }
            ]
        },
        scale: {
            startValue: 0,  endValue: 1500,
            majorTick: { tickInterval: 250 },
            label: {
                format: 'currency'
            }
        },
        title: {
            text: 'Sales MTD',
            subtitle: 'test',
            position: 'top-center'
        },
        tooltip: {
            enabled: true,
            format: 'currency',
            customizeText: function (arg) {
                return 'Current ' + arg.valueText;
            }
        },
        subvalueIndicator: {
            type: 'textCloud',
            format: 'thousands',
            text: {
                format: 'currency',
                customizeText: function (arg) {
                    return 'Goal ' + arg.valueText;
                }
            }
        },
        value: 900,
        subvalues: [825]
    });
</script>
</body>
</html>
