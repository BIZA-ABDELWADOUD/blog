<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>403 Page</title>
    <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    <style>
        a,a:hover {
            color: #fff;
            text-decoration: none;
        }

        h2{
            text-align: center;
            margin : 30px;
            text-transform: capitalize

        }
        button {
            margin : 10px
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="app">
        <h2>
            soory ! you are not authorized to visit this link
         </h2>
         <h1>
             403 Page
         </h1>
         <div class="container">
             <div class="row">
                 <div class="col-md-2"></div>
                 <div class="col-md-8">
                     <img src="{{asset('/images/mogador.png')}}" alt="">
                 </div>
                 <div class="col-md-2"></div>
             </div>
         </div>
         <div class="container">
             <div class="row">
                 <div class="col-md-4"></div>
                 <div class="col-md-4 text-center">
                     <button class="btn btn-primary"><a href="/"><i class="fas fa-home"></i> Back To Home</a></button>
                 </div>
                 <div class="col-md-4"></div>
             </div>
         </div>
    </div>
  
</body>
</html>