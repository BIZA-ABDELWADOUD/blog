<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{ asset('images/mogador.png') }}">
        <title>Welcome To Essaouira</title>
        <link rel="stylesheet" href="{{mix('/css/app.css')}}">
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    </head>
    <body>
        
       <div id="app">
           <mainapp></mainapp>
       </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
