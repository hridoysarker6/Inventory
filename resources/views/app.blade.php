<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="app"></div>

    @vite('resources/js/app.js')

</body>

</html>
