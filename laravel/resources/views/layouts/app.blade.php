<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@yield('titulo')</title>
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
                <main>
                    @yield('content')
                </main>
                <!-- end page title end breadcrumb -->
            </div> <!-- end container -->
        </div>
        <!-- end wrapper -->
        <!-- Footer -->
        @include('layouts.footer')
        <!-- End Footer -->
       @include('layouts.scripts')
       @livewireScripts
       <script type="text/javascript">

        window.livewire.on('closeModal', () => {
            $('#modalCreate').modal('hide');
            window.livewire.emit('resetInputFields');

        });

        window.livewire.on('closeModalEstado', () => {
            $('#modalEstado').modal('hide');

        });


        </script>
        <script type="text/javascript">
         window.livewire.on('modal', () => {
             $('#exampleModal').modal('hide');
             $('#detallesModal').modal('hide');
         });

         window.livewire.on('notificacion', () => {
             $('#notificacionModal').modal('show');
         });
     </script>
     <script>
        function mensaje(valor){
         swal(
             {
                 title: 'SINSA ERP',
                 text: valor,
                 type: 'success',
                 showCancelButton: true,
                 confirmButtonClass: 'btn btn-success',
                 cancelButtonClass: 'btn btn-danger m-l-10'
             }
         )
        }
        function advertencia(valor){
         swal(
             {
                 title: 'SISCA',
                 text: valor,
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonClass: 'btn btn-success',
                 cancelButtonClass: 'btn btn-danger m-l-10'
             }
         )
        }
        function error(valor){
            swal(
                {
                    title: 'SISCA',
                    text: valor,
                    type: 'error',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger m-l-10'
                }
            )
           }

           function success(valor){
            alertify.success(valor).delay(3000);
           }

           function errorMsg(valor){
            alertify.error(valor).delay(3000);
           }
     </script>
     @yield('scripts')
    </body>
</html>
