
<!DOCTYPE html>
<html>
    <head>
        @include('layouts.estilos')
        <title>INICIO DE SESIÓN</title>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div class="wrapper-page">
            <div class="card">
                <div class="card-body">
                        <center>
                            <img src="{{ asset('theme/assets/images/logo.png') }}" alt="">
                            <h2><b>INICIO DE SESION</b></h2>
                            <h2><b>SISTEMA DE CALIFICACION ESTUDIANTIL</b></h2>
                            <h2><b>INEDA 2023</b></h2>
                        </center>
                    <div class="p-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form class="form-horizontal m-t-20" autocomplete="off" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="number"  name="documento" placeholder="Usuario ">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" type="password"  name="password" placeholder="Contraseña">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Recordarme</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-success btn-block waves-effect waves-light" type="submit">INGRESAR</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.scripts')
    </body>
</html>
