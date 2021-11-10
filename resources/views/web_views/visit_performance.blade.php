<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visit Performance</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
{{--    <style>--}}
{{--        #container {--}}
{{--            margin: 20px;--}}
{{--            width: 100%;--}}
{{--            height: 100vh;--}}
{{--        }--}}
{{--    </style>--}}
</head>

<body>
<div id="container"></div>
<script src="{{ asset('AdminLTE') }}/plugins/chart/progressbar.min.js"></script>
<script>
    var achieved = {{ app('request')->input('achieved') ?? 0 }};
    var target = {{ app('request')->input('target') ?? 0 }};
    if(achieved > target) achieved=target;
    var percent = achieved/target;

    var bar = new ProgressBar.SemiCircle(container, {
        strokeWidth: 10,
        color: '#FFEA82',
        trailColor: '#eee',
        trailWidth: 1,
        easing: 'easeInOut',
        duration: 1400,
        svgStyle: null,
        text: {
            value: '',
            alignToBottom: false
        },
        from: {color: '#FFEA82'},
        to: {color: '#ED6A5A'},
        // Set default step function for all animate calls
        step: (state, bar) => {
            bar.path.setAttribute('stroke', state.color);
            var value = Math.round(bar.value() * 100);
            if (value === 0) {
                bar.setText('');
            } else {
                bar.setText(value);
            }

            bar.text.style.color = state.color;
        }
    });
    bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
    bar.text.style.fontSize = '3rem';
    bar.text.style.fontWeight = 'bold';

    bar.animate(percent);  // Number from 0.0 to 1.0
</script>

</body>
</html>
