<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" href="{{ asset('qto-app') }}/favicon.ico" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <meta name="info" project="{{ $id }}" token="{{ auth()->user()->remember_token }}"/>
    <link rel="stylesheet" href="{{ asset('qto-app') }}/fontawsome/css/all.css">
    <link rel="stylesheet" href="{{ asset('qto-app') }}/css/styles.css">
    <link rel="apple-touch-icon" href="{{ asset('qto-app') }}/logo192.png" />
    <link rel="manifest" href="{{ asset('qto-app') }}/manifest.json" />
    <title>{{ env('APP_NAME') }}</title>
    <script defer="defer" src="{{ asset('qto-app') }}/static/js/main.4fff5f82.js"></script>
    <link href="{{ asset('qto-app') }}/static/css/main.9df4b2d5.css" rel="stylesheet">
</head>

<body>
    <div id="loader" class="preloader-area">
        <div class="lds-hourglass"></div>
    </div>
    <div id="root"></div>
</body>

</html>