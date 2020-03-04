<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;


class productos extends Controller
{
    public function inicio($productosPagina = 3)
    {

        $productos = DB::table('lv_productos')->where('destacado', 1)->paginate($productosPagina);


        return view('inicio', compact('productos'))->with('productosPagina', $productosPagina);
    }

    public function listaProductos($productosPagina = 3, $plataforma = 0)
    {
        if ($plataforma == 0) {
            $productos = DB::table('lv_productos')->where('ver', 1)->paginate($productosPagina);
        } else {
            $productos = DB::table('lv_productos')->where('plataforma', $plataforma)->paginate($productosPagina);
        }


        return view('lista_productos', compact('productos'))->with('productosPagina', $productosPagina)->with('plataforma', $plataforma);
    }


    public function datosProducto($id)
    {
        $producto = App\productos::findOrFail($id);

        return view('productos.datos', compact('producto'));
    }
}
