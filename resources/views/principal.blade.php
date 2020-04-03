<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="GymCore Control">
  <meta name="author" content="WhiteShark">
  <meta name="keyword" content="Sistema de Control de Gimnasios">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : ''}}"> 
  <link rel="shortcut icon" href="img/favicon.png">
  <title>GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</title>  
  <link rel="stylesheet" href="css/plantilla.css">  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">  
  
</head>
<body class="hold-transition sidebar-mini">    
    
    <div id="app">
        <!-- Site wrapper -->
        <div class="wrapper">            

            @if(Auth::check())
                @if (Auth::user()->idrol == 1)
                    @include('plantilla/hdapp')
                    @include('plantilla.sbadmin')
                @elseif (Auth::user()->idrol == 2)
                    @include('plantilla.sbalumno')
                @elseif (Auth::user()->idrol == 3)
                    @include('plantilla.sbprofe')
                @elseif (Auth::user()->idrol == 4)
                    @include('plantilla/hdapp')
                    @include('plantilla.sboper')
                @else
     
                @endif
     
            @endif            

            <div class="content-wrapper">
                <section class="content">
                    @yield('contenido')                    
                </section>                       
            </div>

            @if(Auth::check())
                @if (Auth::user()->idrol == 1)
                    @include('plantilla/footer')                              
                @else

                @endif     
            @endif           
            
                        
        </div>
        
    </div>
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>      
    
       
</body>
</html>