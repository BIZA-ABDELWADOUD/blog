<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{ asset('images/mogador.png') }}">
        <title>Welcome To Essaouira</title>
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
           @if(Auth::check() && Auth::user()->role->Permission)
          
           <mainapp :user="{{Auth::user()}}" 
           :Permission="{{Auth::user()->role->Permission}}"></mainapp>
           @elseif(Auth::check())
           <mainapp :user="{{Auth::user()}}" 
           ></mainapp>
           @else
           {{-- <mainapp :user="false"></mainapp> --}}
           <script>window.location = "/login" ;</script>
           @endif
       </div>
    </body>
    <script src="{{mix('/js/app.js')}}"></script>
</html>
