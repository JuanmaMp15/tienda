@extends('plantilla')

@section('cuerpo')
<h1>Lista de pedidos</h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Codigo</th>
      <th scope="col">Fecha</th>
      <th scope="col">Envio</th>
      <th scope="col">Ver</th>
    </tr>
  </thead>
  <tbody>
    @foreach($facturas as $f)
    <tr>
      <td>{{$f->cod}}</td>
      <td>{{$f->fecha}}</td>
      @if($f->enviado==1)
      <td><a href="#" class="btn btn-success disabled">Enviado</a></td>
      @else
      <td><a href="{{ route('cancelarPedido',$f->cod) }}" class="btn btn-danger"> Cancelar</a></td>
      @endif
      <td><a class="btn btn-danger" href="{{ route('pdfVerFacturas',$f->cod) }}" role="button" target="_blank">PDF</a>
</td>
    </tr>
    @endforeach()

  </tbody>


</table>
@endsection