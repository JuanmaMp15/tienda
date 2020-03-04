<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        #mycontainer {
            max-width: 1280px !important;
        }
    </style>
</head>

<body>
    <h1 class="d-flex justify-content-center">Game Shop</h1><br>
    <h3 class="d-flex justify-content-center">Factura:</h3>
    <div class="row">

        <div class="col" style=" border: 1px solid black;width: 280px;max-width: 500px;">
            <p>GameShop.com</p>
            <p>CIF:B73347494</p>
            <p>Av. Alcalde Federico Molina Orta, 48</p>
            <p>21007 Huelva</p>
        </div>
        <div class="col" style=" border: 1px solid black;width: 280px;max-width: 500px;float:right;">
            @foreach (session('usuario') as $dato)
            <p>Nombre:{{$dato->nombre}}</p>
            <p>Apellidos:{{$dato->apellidos}}</p>
            <p>CIF/DNI:{{$dato->dni}}</p>
            <p>Provincia:{{$provincia}}</p>
            <p>Dirección:{{$direccion}}</p>
            <p>Telefono:{{$dato->telefono}}</p>
            @endforeach
        </div>
    </div>
    <p>Factura:Cod-{{$cod}}</p>
    <p>Fecha: {{$fecha}}</p>
    <br>
    <table class="table">
        <thead class="thead">
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
    <h3>Tiene que pagar un total de {{Cart::getTotal()}}</h3>
    <h2>Gracias por su compra</h3>

</body>

</html>