@extends('plantilla')

@section('cuerpo')
<h1>Carrito</h1>
<button type="button" class="btn btn-default" aria-label="Left Align">
  <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
</button>
@if(Cart::isEmpty()==0)

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col"></th>
      <th scope="col">Nombre</th>
      <th scope="col">Cantidad</th>
      <th scope="col">Precio</th>
      <th scope="col">Total</th>
      <th scope="col"></th>

    </tr>
  </thead>
  <tbody>
    @foreach($carrito as $producto)
    <tr>
      <td class='p-2 text-center align-middle'><a href="{{ route('productos.datos', $producto -> id )}}">
          <img class="w-0 h-50" src="{{ asset('images/juegos/'.$producto->attributes->imagen.'') }}"></a></td>
      <td>{{$producto->name}}</td>
      <td>
        @if($producto->quantity>1)
        <a class="btn btn-danger" href=" {{ route('cambiar_cantidad',[$producto -> id,-1]) }} " role="button">-</a>
        @endif
        {{$producto->quantity}}
        <a class="btn btn-success" href=" {{ route('cambiar_cantidad',[$producto -> id,1]) }} " role="button">+</a>
      </td>
      <td>{{$producto->price}}</td>
      <td>{{$producto->price*$producto->quantity}}</td>
      <td><a class="btn btn-danger" href="{{ route('eliminar_producto', $producto -> id )}}"><i class="fas fa-trash-alt"></i></a></td>
    </tr>
  </tbody>

  @endforeach()
</table>
<h3>Tiene que pagar un total de {{Cart::getTotal()}}</h3>

<a class="btn btn-danger" href=" {{ route('limpiar_carrito') }} " role="button">Limpiar Carrito</a>
@if(session()->has('usuario'))
<a class="btn btn-success" href=" # " role="button" data-toggle="modal" data-target="#modal_eliminar_cuenta">Comprar</a>
@endif
@else
<h3>No has comprado nada aun :(</h3>
@endif
<br /><br />
@if(Cart::isEmpty()==0)

<!-- Ultima pregunta de compra -->

<div class="modal fade bd-example-modal-lg" id="modal_eliminar_cuenta">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-dark">
        <h4 class="modal-title text-white">Realizar compra</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="p-4">
        <h1>Lista de compra</h1>
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Total</th>

            </tr>
          </thead>
          <tbody>
            @foreach($carrito as $producto)
            <tr>
              <td>{{$producto->name}}</td>
              <td>{{$producto->quantity}}</td>
              <td>{{$producto->price}}</td>
              <td>{{$producto->price*$producto->quantity}}</td>
            </tr>
            @endforeach()
          </tbody>
        </table>
        <h4>Tiene que pagar un total de {{Cart::getTotal()}}</h4>
        <form action="{{ route('realizarCompra') }}" method="POST">
          @csrf
          <p>Marca tu provincia:</p>
          <select name="provincia">
            @foreach($provincias as $p)
            <option value="{{$p->provincia}}">{{$p->provincia}}</option>
            @endforeach()
          </select>
          <p>Escribe la dirección de envio:</p>
          <input name="direccion" value="{{ old('direccion') }}" class="form-control" id="periodo" type="text" placeholder="Calle/Nºportal/Piso" size="6">
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" href=" # ">Si</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </form>

      </div>
      </form>

    </div>
  </div>
</div>
@endif
@endsection