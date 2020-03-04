<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;
//use Crypt;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Hash;



class usuarios extends Controller
{
    /**
     * Se le pasa el formulario de registro y inserta el usuario en la bd
     *
     * @param Request $form
     * @return void
     */
    public function insertarUsuario(Request $form)
    {

        if (DB::table('lv_usuarios')->where('usuario', $form->usuario)->exists()) {
            return back()->with('coincide', 'El usuario ya esta registrado');
        }
        if (DB::table('lv_usuarios')->where('email', $form->email)->exists()) {
            return back()->with('coincide', 'El email ya esta registrado');
        }
        //Validacion de laravel
        $form->validate([
            'nombre' => 'required|alpha',
            'apellidos' => 'required|alpha',
            'dni' => 'required',
            'telefono' => 'required|numeric',
            'usuario' => 'required',
            'contrasena' => 'required',
            'email' => 'required|email',

        ]);

        //Creamos un usuario y le isertamos los datos
        $usuario = new App\usuarios;
        $usuario->nombre = $form->nombre;
        $usuario->apellidos = $form->apellidos;
        $usuario->dni = $form->dni;
        $usuario->telefono = $form->telefono;
        $usuario->usuario = $form->usuario;
        $usuario->contrasena = Crypt::encrypt($form->contrasena);
        $usuario->email = $form->email;
        //Guardamos los cambios
        $usuario->save();
        return view('UsuarioCreado');
        //return $form->all();
    }

    /**
     * Busca coincidencia en la bd de usuario y contraseña y inicia una sesion
     *
     * @param Request $form
     * @return void
     */
    public function iniciarSesion(Request $form)
    {
        //Comparamos la contraseña y el usuario 
        if (DB::table('lv_usuarios')->where('usuario', $form->usuario)->exists()) {
            $usuario = DB::table('lv_usuarios')->where('usuario', '=', $form->usuario)->get();

            foreach ($usuario as $dato) {
                //miramos si la contraseña coincide
                if ($form->contrasena == Crypt::decrypt($dato->contrasena)) {
                    //Guardamos el usuario entero en la sesion
                    session(['usuario' => $usuario]);
                }
                return back();
            }
        } else {
            return back();
        }
    }
    /**
     * Cierra la sesion del usuario
     *
     * @return void
     */
    public function cerrarSesion()
    {
        //Cierra la sesion del usuario
        session()->forget('usuario');
        return redirect()->route('inicio', 3);
    }
    /**
     * Enseña la vista del modificar
     *
     * @return void
     */
    public function verModificar()
    {
        return view('modificarUsuario');
    }
    /**
     * Modifica el usuario
     *  Compara el usuario en la bd y el email por si se repite
     * @param Request $form
     * @return void
     */
    public function modificarUsuario(Request $form)
    {
        //Si el usuario ha cambiado de usuario o correo lo buscamos en la bd
        foreach (session('usuario') as $dato) {
            if ($dato->usuario != $form->usuario) {
                if (DB::table('lv_usuarios')->where('usuario', $form->usuario)->exists()) {
                    return back()->with('coincide', 'El usuario ya esta registrado');
                }
            }
            if ($dato->email != $form->email) {
                if (DB::table('lv_usuarios')->where('email', $form->email)->exists()) {
                    return back()->with('coincide', 'El email ya esta registrado');
                }
            }
        }


        //Validacion de laravel
        $form->validate([
            'nombre' => 'required|alpha',
            'apellidos' => 'required|alpha',
            'dni' => 'required',
            'telefono' => 'required|numeric',
            'usuario' => 'required',
            'contrasena' => 'required',
            'email' => 'required|email',
        ]);
        //return view('modificarUsuario');
        $nombre_usuario;
        foreach (session('usuario') as $dato) {
            $nombre_usuario = $dato->usuario;
        }
        //cojo el usuario en el que coincide le nombre
        $usuario = App\usuarios::where('usuario', '=', $nombre_usuario)->first();

        //cambio los datos (si no ha realizado datos en un cambio se quedara igual)
        $usuario->nombre = $form->nombre;
        $usuario->apellidos = $form->apellidos;
        $usuario->dni = $form->dni;
        $usuario->telefono = $form->telefono;
        $usuario->usuario = $form->usuario;
        $usuario->contrasena = Crypt::encrypt($form->contrasena);
        $usuario->email = $form->email;

        $usuario->save();
        //cierro sesion
        session()->forget('usuario');
        //la vuelvo a abrir pero con los datos nuevos (asi la sesion tendra los datos nuevos)
        $usuario_ = DB::table('lv_usuarios')->where('usuario', '=', $form->usuario)->get();

        session(['usuario' => $usuario_]);

        return redirect()->route('inicio', 3);
    }
    /**
     * Elimina el usuario y sus facturas
     *
     * @return void
     */
    public function eliminarUsuario()
    {
        foreach (session('usuario') as $dato) {
            App\usuarios::destroy('usuario', '=', $dato->usuario);
            App\Factura::where('usuario', '=', $dato->usuario)->delete();

            session()->forget('usuario');
        }
        return back()->with('noCorreo', 'La cuenta ha sido borrada');
    }
    /**
     * Enseña la lista de pedidos
     *
     * @return void
     */
    public function verPedidos()
    {
        foreach (session('usuario') as $dato) {
            $facturas = DB::table('lv_facturas')->select('cod', 'fecha','enviado')->orderBy('id', 'desc')->where('usuario', '=', $dato->usuario)->groupBy('cod')->get();
        }
        //return $facturas;
        return view('pedidosHechos', compact('facturas'));
    }
    /**
     * Crea un pdf co
     *
     * @param [type] $cod
     * @return void
     */
    public function pdfVerFacturas($cod)
    {
        $datos = DB::table('lv_facturas')->where('cod', '=', $cod)->groupBy('cod')->get();
        $productos = DB::table('lv_facturas')->where('cod', '=', $cod)->get();
        $total = 0;
        foreach ($productos as $producto) {
            $total += $producto->total;
        }

        //return $productos;
        $data = [
            'datos' => $datos,
            'productos' => $productos,
            'total' => $total
        ];
        //crear el pdf
        $pdf = \PDF::loadView('pdf_Factura_Ver', $data)->stream('archivo.pdf');;
        return $pdf;
    }
    public function cancelarPedido($cod){
        App\Factura::where('cod', '=', $cod)->delete();
        return back();
    }
}
