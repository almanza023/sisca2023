<div>
    <div class="navbar-custom" style="background-color: green">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="{{ route('home') }}"><i class="mdi mdi-airplay"></i>Inicio</a>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-plus"></i>Registro</a>
                        <ul class="submenu">
                           @if($tipo==2 || $admin)
                           <li><a href="{{ route('matriculas') }}">Matriculas</a></li>
                           <li><a href="{{ route('personal') }}">Personal</a></li>
                           <li><a href="{{ route('carga-academicas') }}">Carga Acádemica</a></li>
                           <li><a href="{{ route('calificaciones-estudiantes') }}">Calificación Individual</a></li>
                           @endif
                           @if($grado>=3 || $admin || $direcciones==0)
                           <li><a href="{{ route('calificaciones.create') }}">Notas Academicas por Grado</a></li>
                           <li><a href="{{ route('nivelaciones.create') }}">Nivelaciones de Periodo</a></li>
                           <li><a href="{{ route('logros-academicos') }}">Logros Académicos</a></li>
                           <li><a href="{{ route('logros-disciplinarios') }}">Logros Disciplinarios</a></li>
                           <li><a href="{{ route('convivencia.create') }}">Convivencia Escolar</a></li>
                           <li><a href="{{ route('nivelaciones-finales.create') }}">Nivelaciones Finales</a></li>
                           @endif
                            @if(($direcciones>=1 || $grado<=2) || $admin)
                            <li><a href="{{ route('dimensiones.create') }}">Calificación Dimensiones</a></li>
                            <li><a href="{{ route('logros-preescolar') }}">Logros Preescolar</a></li>
                            @endif
                            @if($direcciones>1)
                            <li><a href="{{ route('calificaciones.create') }}">Notas Academicas por Grado</a></li>
                            <li><a href="{{ route('nivelaciones.create') }}">Nivelaciones de Periodo</a></li>
                            <li><a href="{{ route('logros-academicos') }}">Logros Académicos</a></li>
                            <li><a href="{{ route('logros-disciplinarios') }}">Logros Disciplinarios</a></li>
                            <li><a href="{{ route('convivencia.create') }}">Convivencia Escolar</a></li>
                            <li><a href="{{ route('nivelaciones-finales.create') }}">Nivelaciones Finales</a></li>

                            @endif


                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-refresh"></i>Actualizar</a>
                        <ul class="submenu">
                            <li>
                                <ul>
                                    @if($grado>=3 || $admin || $direcciones==0)
                                    <li><a href="{{ route('calificaciones.edit') }}">Notas de Periodo</a></li>
                                    <li><a href="{{ route('nivelaciones.edit') }}">Nivelaciones de Periodo</a></li>
                                    @endif
                                    @if(($direcciones>=1 || $grado<=2)|| $admin)
                                    <li><a href="{{ route('dimensiones.edit') }}">Calificación de Dimensiones</a></li>
                                   @else
                                    <li><a href="{{ route('convivencia.edit') }}">Convivencia Escolar</a></li>
                                    @endif
                                    @if($direcciones>1)
                                    <li><a href="{{ route('calificaciones.edit') }}">Notas de Periodo</a></li>
                                    <li><a href="{{ route('nivelaciones.edit') }}">Nivelaciones de Periodo</a></li>
                                    <li><a href="{{ route('convivencia.edit') }}">Convivencia Escolar</a></li>
                                    @endif
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-account-search"></i>Consultar</a>
                        <ul class="submenu">
                            <li>
                                <ul>
                                    @if($grado>=3 || $admin || $direcciones==0)
                                    <li><a href="{{ route('calificaciones.show') }}">Notas de Periodo</a></li>
                                    <li><a href="{{ route('calificaciones.generales') }}">Notas Acumulativas</a></li>
                                    <li><a href="{{ route('nivelaciones.show') }}">Nivelaciones de Periodo</a></li>
                                    @endif
                                    @if(($direcciones>=1 || $grado<=2) || $admin)
                                    <li><a href="{{ route('dimensiones.show') }}">Calificación de Dimensiones</a></li>
                                    @endif
                                    @if($direcciones>1)
                                    <li><a href="{{ route('calificaciones.show') }}">Notas de Periodo</a></li>
                                    <li><a href="{{ route('calificaciones.generales') }}">Notas Acumulativas</a></li>

                                    <li><a href="{{ route('nivelaciones.show') }}">Nivelaciones de Periodo</a></li>
                                    <li><a href="{{ route('convivencia.show') }}">Convivencia Escolar</a></li>
                                    @endif

                                </ul>
                            </li>


                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-file"></i>Reportes</a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('reporte-boletines-preescolar') }}">Boletines Preescolar</a></li>
                                    <li><a href="{{ route('view-reporte-dimensiones') }}">Calificaciones Dimensiones</a></li>
                                    @if($tipo==2 || $admin)
                                    <li><a href="{{ route('reporte-boletines') }}">Boletines de Periodo</a></li>
                                    <li><a href="{{ route('reporte-boletines-finales') }}">Boletines Finales</a></li>
                                    <li><a href="{{ route('view-consolidados') }}">Consolidado de Periodo</a></li>
                                    <li><a href="{{ route('view-reporte-notas') }}">Notas de Periodo</a></li>
                                    @endif

                                </ul>
                            </li>
                        </ul>
                    </li>
                    @if($tipo==2 || $admin)
                    <li class="has-submenu">
                        <a href="#"><i class="mdi mdi-google-pages"></i>Configuraciones</a>
                        <ul class="submenu megamenu">
                            <li>
                                <ul>
                                    <li><a href="{{ route('personal') }}">Personal</a></li>
                                    <li><a href="{{ route('grados') }}">Grados</a></li>
                                    <li><a href="{{ route('sedes') }}">Sedes</a></li>
                                    <li><a href="{{ route('tipo-asignaturas') }}">Tipos Asignaturas</a></li>
                                    <li><a href="{{ route('asignaturas') }}">Asignaturas</a></li>
                                    <li><a href="{{ route('carga-academicas') }}">Carga Academicas</a></li>
                                    <li><a href="{{ route('carga.create') }}">RegistroCarga Academicas</a></li>
                                    <li><a href="{{ route('periodos') }}">Periodos</a></li>
                                    <li><a href="{{ route('tipo-logros') }}">Tipos Logros</a></li>
                                    <li><a href="{{ route('usuarios') }}">Usuarios</a></li>
                                    <li><a href="{{ route('direcciones-grados') }}">Direcciones de Grado</a></li>
                                    <li><a href="{{ route('apertura-periodos') }}">Apertura de Periodos</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    @endif

                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div>

</div>
