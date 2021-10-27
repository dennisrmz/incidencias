<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class='container'>
        <a class="navbar-brand" href="#">
            <b>DataGuard Incidencias</b>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        @guest

        @else
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
        @endguest

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav">

            </ul>
            <!-- Authentication Links -->
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesion</a></li>
                @else
                @can('users.create')
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar Usuario</a></li>
                @endcan
                <li class="nav-item dropdown">
                    <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Cerrar Sesion
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>