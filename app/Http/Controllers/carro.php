<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;
use Cart;
//use App\Http\Controllers\PDF;

class carro extends Controller
{
    public function insertarProducto($id_producto)
    {
        $producto = App\productos::findOrFail($id_producto);
        print_r($producto->nombre);

        Cart::add(array(
            'id' => $id_producto,
            'name' => $producto->nombre,
            'quantity' => 1,
            'price' => $producto->precio,
            'attributes' => array(
                'descripcion' => $producto->descripcion,
                'plataforma' => $producto->plataforma,
                'imagen' => $producto->imagen
            )
        ));
        //return redirect(url("/"));
        return back()->with('mensaje', $producto->nombre . ' agregado al carrito');
    }
    public function verCarrito()
    {
        $carrito = Cart::getContent();
        $provincias = DB::table('lv_provincias')->get();

        return view('carrito', compact('carrito', 'provincias'));
    }

    public function contarProductos()
    {
        $carrito = Cart::getContent();

        return $carrito->count();
    }

    public function limpiarCarro()
    {
        Cart::clear();
        //return redirect(url(route('carrito')));
        return back();
    }

    public function eliminarProducto($id_producto)
    {
        Cart::remove($id_producto);

        return redirect(url(route('carrito')));
    }

    public function cambiarCantidad($id_producto, $cantidad)
    {
        Cart::update($id_producto, array(
            'quantity' => $cantidad,
        ));

        return redirect(url(route('carrito')));
    }

    public function cambiarCantidaVer($id_producto, $cantidad)
    {
        $producto = App\productos::findOrFail($id_producto);
        print_r($cantidad);

        Cart::add(array(
            'id' => $id_producto,
            'name' => $producto->nombre,
            'quantity' => $cantidad,
            'price' => $producto->precio,
            'attributes' => array(
                'descripcion' => $producto->descripcion,
                'plataforma' => $producto->plataforma,
                'imagen' => $producto->imagen
            )
        ));
        return redirect(url("/datos/$id_producto"));
    }
    
}
