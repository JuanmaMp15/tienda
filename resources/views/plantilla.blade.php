<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <title>Hello, world!</title>
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
</head>

<body>
<p style="display:none">
{{$plataformas = DB::table('lv_plataformas')->where('ver', 1)->get()}}
</p>

  <nav class="nav  bg-dark navbar-dark fixed-top">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="{{ route('inicio',3) }}">Game shop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

    <ul class="navbar-nav ml-auto p-2">
    <div class="row">
    @if(session()->has('usuario'))
      @foreach (session('usuario') as $dato) 
        <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        {{$dato->usuario}}
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('verPedidos') }}">Ver compras</a>
        <a class="dropdown-item" href="{{ route('modificarUsuario') }}">ModificarUsuario</a>
        <a class="dropdown-item" href="{{ route('cerrarSesion') }}">Cerrar sesion</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal_eliminar_cuenta">Eliminar Usuario</a>

      </div>
    </li>&nbsp; &nbsp;
      @endforeach

    @else
      <li class="nav-item">
        <a class="btn btn-light" href="#" role="button" data-toggle="modal" data-target="#modal_incio_sesion">
          <i class="fas fa-user"></i>
        </a>&nbsp; &nbsp;
      </li>
    @endif
     

      <li class="nav-item">
        <a class="btn btn-light" href="{{ route('carrito') }}" role="button">
          <i class="fas fa-shopping-cart"></i>
          <span class="badge">{{Cart::getTotalQuantity()}}</span>
        </a>&nbsp; &nbsp;
      </li>
      
      <div>
    </ul>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('productos',[$productosPagina ?? '',0])}}">Todos</a>
      </li>
      @foreach($plataformas  as $plataforma)
      <li class="nav-item">
        <a class="nav-link" href="{{route('productos',[$productosPagina ?? '',$plataforma->id])}}">{{$plataforma->nombre}}</a>
      </li>
      @endforeach()
    </ul>
  </div>
  </nav>
  <br/><br/>
  

  <div class="pl-4 pr-4">
  @if ( session('noCorreo') )
<br/>
    <div class="alert alert-danger">{{ session('noCorreo') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>

    </div>
@endif


    @yield('cuerpo')

    <footer class="bg-dark">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-md-6">
            <h6 class="text-white lead">CONTACTO:</h6>
            <h6 class="text-white">
              Carrera 8h No. 166-71 Local 2<br>
              Santa Cruz de la Ronda.<br>
              Teléfonos: 3115988953 – 3112641818.<br>
            </h6>
          </div>
          <div class="col-xs-12 col-md-6">
            <div class="pull-right">
              <h6 class="lead text-white">ENCUENTRANOS EN LAS REDES</h6>
              <div class="redes-footer">
                <a href="https://www.facebook.com/"><i class="fab fa-facebook-square"></i></a>
                <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com/"><i class="fab fa-youtube" style="color:red"></i></a>
              </div>
            </div>
            <div class="row">
              <p class="text-white small text-right">José Miguel, arte y belleza @2016.<br> Todos los derechos reservados.</p>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

<!-- The Modal -->
<div class="modal fade" id="modal_incio_sesion">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark">
        <h4 class="modal-title text-white">Inicio sesion</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="p-4">
      <form action="{{ route('iniciarSesion') }}"><br/>
          <div class="form-group">
            <label for="email">Usuario:</label>
            <input type="text" class="form-control" placeholder="Usuario" name="usuario" id="email">
          </div>
          <div class="form-group">
            <label for="pwd">Contraseña:</label>
            <input type="password" class="form-control" placeholder="Enter password" name="contrasena" id="pwd">
          </div>
          <a href="{{route('registro')}}">No tengo cuenta</a><br/>
          <a href="#" data-toggle="modal" data-target="#modal_recuperar_comtrasena">He olvidado la contraseña</a><br/>

      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Aceptar</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>

    </div>
  </div>
</div>
      <!-- Modal recuperar contraseña -->

<div class="modal fade" id="modal_recuperar_comtrasena">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark">
        <h4 class="modal-title text-white">Recuperar contraseña</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="p-4">
      <p>Introduce un correo electronico para que podamos enviarle su nombre de usuario y contraseña</p>
      <form action="{{ route('recuperarContrasena') }}"><br/>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" placeholder="Email" name="email" id="email">
          </div> 

      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Aceptar</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

      </div>
      </form>

    </div>
  </div>
</div>

 <!-- Eliminar usuario -->

 <div class="modal fade" id="modal_eliminar_cuenta">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark">
        <h4 class="modal-title text-white">Borrar usuario</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="p-4">
      <h1>Cuidado!!</h1>
      <p>Si borra su usuario se perdera sus datos y sus facturas</p>
      <p>¿Estas seguro que deseas borrar la cuenta?</p>
           
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
      <a type="button" class="btn btn-primary" href="{{route('eliminarUsuario')}}">Si</a>
      <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>

      </div>
      </form>

    </div>
  </div>
</div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>