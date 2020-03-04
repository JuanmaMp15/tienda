@extends('plantilla')

@section('cuerpo')
<h1>Producto</h1>
    <h1 class="text-primary">{{ $producto->nombre }}</h1>
    <p>{{ $producto->descripcion }}</p>
    <div class="row">

<img class="card-img-top" src="{{ asset('images/juegos/'.$producto->imagen) }}" style="width:30%;   z-index: 1;">   
@if($producto->stock==0)
<img class="card-img-top " src="{{ asset('images/juegos/sold.png') }}" style="width:25%;  position: absolute;  z-index: 2;">
@endif
</div>
    
    <div class="btn-group" role="group">
    @if($producto->stock==0)
    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-shopping-cart"></i>
    </button>      
    @else
    <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-shopping-cart"></i>
    </button>      
    @endif  



    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
      <a class="dropdown-item" href=" {{ route('cambiar_cantidad_ver',[$producto -> id,1]) }} ">1</a>
      <a class="dropdown-item" href=" {{ route('cambiar_cantidad_ver',[$producto -> id,5]) }} ">5</a>
      <a class="dropdown-item" href=" {{ route('cambiar_cantidad_ver',[$producto -> id,10]) }} ">10</a>
    </div>
  </div>
@endsection