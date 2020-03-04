@extends('plantilla')

@section('cuerpo')
@if ( session('mensaje') )
<br/>
    <div class="alert alert-success">{{ session('mensaje') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>

    </div>
@endif
<h1>Tienda</h1>
<spam>Nº productos por pagina:
<div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    {{$productosPagina}}
    </button>
<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href=" {{ route('productos',[3,$plataforma]) }} ">3</a>
      <a class="dropdown-item" href=" {{ route('productos',[5,$plataforma]) }} ">5</a>
      <a class="dropdown-item" href=" {{ route('productos',[10,$plataforma]) }} ">10</a>
    </div>
  </div>
</spam>
<div class="row p-5" >
  @foreach($productos as $producto)
  <div class="card m-5 shadow-sm" style="width: 12rem;">
  
  <div style="position: relative; left: 0; top: 0;">

    <img class="card-img-top" src="{{ asset('images/juegos/'.$producto->imagen) }}" style="width:70%;   z-index: 1;">   
    @if($producto->stock==0)
    <img class="card-img-top " src="{{ asset('images/juegos/sold.png') }}" style="width:70%;  position: absolute; right: 100px; z-index: 2;">
    @endif
    </div>


    <div class="card-body">
      <h6 class="card-title">{{$producto->nombre}}</h6>
      <h3 class="card-text">{{$producto->precio}}</h3>
      <a href="{{ route('productos.datos', $producto -> id )}}" class="btn btn-primary" >Ver</a>
      @if($producto->stock==0)
      <a href="{{ route('insertar_carrito', $producto -> id )}}" class="btn btn-danger disabled"> <i class="fas fa-shopping-cart"></i>+</a>
      @else
      <a href="{{ route('insertar_carrito', $producto -> id )}}" class="btn btn-primary"> <i class="fas fa-shopping-cart"></i>+</a>
      @endif
    </div>
  </div>
  @endforeach()
</div>
{{ $productos->links() }}

@endsection

