<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav id="sidebar">
				<div class="p-4 pt-5">
		  		<a href="#" class="img logo rounded-circle mb-5" style="background-image: url(images/logo.jpg);"></a>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
	            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
	            <ul class="collapse list-unstyled" id="homeSubmenu">
                <li>
                    <a href="#">Home 1</a>
                </li>
                <li>
                    <a href="#">Home 2</a>
                </li>
                <li>
                    <a href="#">Home 3</a>
                </li>
	            </ul>
	          </li>
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
              @can('roles.index')
              <li>
              <a href="{{ route('roles.index')}}">Roles</a>
              </li>
              @endcan
	          <li>
              <a href="#">Contact</a>
	          </li>
	        </ul>

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved<i class="icon-heart" aria-hidden="true"></i> by <a href="https://clobi.online" target="_blank">clobi.online</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>
</body>
</html>