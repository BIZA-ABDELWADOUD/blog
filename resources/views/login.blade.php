<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{ asset('images/mogador.png') }}">
        <title>Login</title>
        <link rel="stylesheet" href="{{mix('/css/app.css')}}">
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">

        <script>
            (function () {
                window.Laravel = {
                    csrfToken : '{{ csrf_token() }}'
                };
            })();
        </script>

    </head>
    <body>
        
       <div id="app">
           <loginapp></loginapp>
       </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
