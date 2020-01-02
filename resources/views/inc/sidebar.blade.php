<nav id="sidebar">
    <div class="p-4 pt-5">
      <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(/images/logo.jpg);"></a>
     
      <ul class="list-unstyled components mb-5">
        @can('incidents.index')
        <li class="active">
          <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Incidencias</a>
          <ul class="collapse list-unstyled" id="homeSubmenu">
            <li>
              <a class="nav-link" href="{{ route('incidents.incidencias' , Auth::user()->id) }}">Incidencias Asignadas</a>
            </li>
            @can('incidents.create')
            <li>
              <a class="nav-link" href="{{ route('incidents.create') }}">Asignar Incidencias</a>
            </li>
            @endcan
            <li>
              <a href="{{ route('incidents.rechazadas' , Auth::user()->id) }}">Incidencias Rechazadas</a>
            </li>
            <li>
              <a href="{{ route('incidents.finalizadas' , Auth::user()->id) }}">Incidencias Finalizadas</a>
            </li>
          </ul>
        </li>
        @endcan
        @can('roles.index')
        <li class="nav-item">
          <a class="nav-link" href="{{ route('roles.index')}}">Roles</a>
        </li>
        @endcan
        @can('departaments.index')
        <li>
          <a href="{{ route('departaments.index')}}">Departamentos</a>
        </li>
        @endcan
        @can('users.index')
        <li>
          <a href="{{ route('users.index')}}">Usuarios</a>
        </li>
        @endcan
        
        @can('equipments.index')
        <li>
          <a href="{{ route('equipments.index')}}">Equipos</a>
        </li>
        @endcan
        <li>
          <a href="#">Contact</a>
        </li>
      </ul>

      <div class="footer">
        <p>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          Copyright &copy;<script>
            document.write(new Date().getFullYear());
          </script> All rights reserved<i class="icon-heart" aria-hidden="true"></i> by <a href="https://clobi.online" target="_blank">clobi.online</a>
          <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
        </p>
      </div>

    </div>
  </nav>
