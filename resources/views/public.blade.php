<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>Software USCO</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <noscript>Necesitas habilitar javascript en tu navegador.</noscript>
    <div id="root">
    </div>
    <script src="{{ asset('js/public/index.js') }}"></script>
</body>
</html>