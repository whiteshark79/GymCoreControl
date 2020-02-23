<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="GymCore Control">
    <meta name="author" content="WhiteShark.com">
    <meta name="keyword" content="Sistema de Control de Gimnasios">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</title>
    
    <link rel="stylesheet" href="css/plantilla.css">
    
    </head>
    <body class="hold-transition login-page">
    
        @yield('login')        

        <script src="js/plantilla.js"></script>
        
        <style>
            .vertical-center {
            min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh; /* These two lines are counted as one :-)       */
            
            display: flex;
            align-items: center;
            }
        </style>
        @stack('scripts')
    </body>
</html>
