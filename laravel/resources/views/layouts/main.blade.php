<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>SISCA - SISTEMA DE CALIFICACION</title>
        @include('layouts.estilos')
        @livewireStyles
    </head>
    <body>
        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <!-- Navigation Bar-->
        <header id="topnav">
           @include('layouts.topbar')
            <!-- end topbar-main -->
            <!-- MENU Start -->
            @include('layouts.navbar')
            <!-- end navbar-custom -->
        </header>
        <!-- End Navigation Bar-->
        <div class="wrapper">
            <div class="container-fluid">
                <!-- Page-Title -->
                @yield('content')
                <!-- end page title end breadcrumb -->
            </div> <!-- end container -->
        </div>

        <!-- end wrapper -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End Footer -->
       @include('layouts.scripts')
       @livewireScripts
    </body>
</html>




