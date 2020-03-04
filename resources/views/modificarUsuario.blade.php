@extends('plantilla')

@section('cuerpo')

<h1>Modificar usuario</h1>
@if ( session('coincide') )
<br/>
    <div class="alert alert-danger">{{ session('coincide') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>

    </div>
@endif

@foreach (session('usuario') as $dato) 

<form action="{{ route('usuarioModificado') }}" method="POST">
    @csrf
    {{--Nombre--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Nombre:</label>
            <input name="nombre" value="{{ (old('nombre') == '' ? $dato->nombre:old('nombre'))}}" class="form-control" id="periodo" type="text" placeholder="Nombre"  size="6">
        </div>  
    </div>
    {{--Apellidos--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Apellidos:</label>
            <input name="apellidos" value="{{ (old('apellidos') == '' ? $dato->apellidos:old('apellidos'))}}" class="form-control" id="periodo" type="text" placeholder="Apellidos"  size="6">
        </div>  
    </div>
    {{--DNI--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">DNI:</label>
            <input name="dni" value="{{ (old('dni') == '' ? $dato->dni:old('dni'))}}" class="form-control" id="periodo" type="text" placeholder="DNI" size="6">
        </div>  
    </div>
    {{--Telefono--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Telefono:</label>
            <input name="telefono" value="{{ (old('telefono') == '' ? $dato->telefono:old('telefono'))}}" class="form-control" id="periodo" type="text" placeholder="Telefono"  size="6">
        </div>  
    </div>
    {{--Usuario--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Usuario:</label>
            <input name="usuario" value="{{ (old('usuario') == '' ? $dato->usuario:old('usuario'))}}" class="form-control" id="periodo" type="text" placeholder="Usuario"  size="6">
        </div>  
    </div>
    {{--Contraseña--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Contraseña:</label>
            <input name="contrasena" value="{{ (old('contrasena') == '' ? Crypt::decrypt($dato->contrasena):old('contrasena'))}}" class="form-control" id="periodo" type="text" placeholder="Contraseña"  size="6">
        </div>  
    </div>
    {{--Email--}}
    <div class="col-lg-3 col-md-3 col-xs-12">
        <div class="form-group">
            <label for="periodo">Email:</label>
            <input name="email" value="{{ (old('email') == '' ? $dato->email:old('email'))}}" class="form-control" id="periodo" type="text" placeholder="Email"  size="6">
        </div>  
    </div>
    {{--Boton--}}
    <button class="btn btn-primary" type="submit">Aceptar</button>
</form>
<br/>
@endforeach

@endsection