<div>

    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="{{route('home')}}" class="logo">-->
                <!--Annex-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="{{route('home')}}" class="logo">
                    <img src="{{ asset('theme/assets/images/logo.png') }}" alt="" width="40px" height="20px" class="logo-large m-t-10">

                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">

                <ul class="list-inline float-right mb-0">



                    <!-- notification-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <i class="mdi mdi-bell-outline noti-icon"></i>
                            <span class="badge badge-success noti-icon-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5>Notification (3)</h5>
                            </div>

                            <!-- item-->
                            @forelse ($aperturas as $item)
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                <p class="notify-details"><b>PERIODO: {{ $item->periodo->descripcion }}</b><small class="text-muted">FECHA DE APERTURA: {{ $item->fecha_apertura }}
                                    FECHA DE CIERRE {{ $item->fecha_cierre }}</small></p>
                            </a>
                            @empty

                            @endforelse



                        </div>
                    </li>
                    <!-- User-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('theme/assets/images/users/avatar-1.jpg') }}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <small style="font-size: 10px">
                                   <b> @if(!empty(auth()->user()->name))
                                        {{ auth()->user()->name }}
                                    @endif
                                   </b>
                                </small>
                            </div>
                            <a class="dropdown-item" href="{{ route('perfil') }}"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Perfil</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit"  class="dropdown-item text-danger"  >  <i class="fa fa-window-close text-danger"></i> </i> Cerrar Sesión</a>
                            </form>

                        </div>
                    </li>
                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>


</div>
