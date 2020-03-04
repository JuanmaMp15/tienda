<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


//Tabla de productos
Route::get('/{numeroProductos?}','productos@inicio')->name('inicio')->where(['numeroProductos' => '[\d]+']);

Route::get('listaProductos/{numeroProductos?}/{plataforma?}','productos@listaProductos')->name('productos')->where(['numeroProductos' => '[\d]+'])->where(['plataforma' => '[\d]+']);

Route::get('/datos/{id}','productos@datosProducto')->name('productos.datos');

Route::get('/usuario','inicio@usuario')->name('usuario');
Route::get('/carrito','carro@verCarrito')->name('carrito');
Route::get('/registro','inicio@registro')->name('registro');

//Rutas del carrito
Route::get('/insertarCarro/{id_producto}','carro@insertarProducto')->name('insertar_carrito');
Route::get('/limpiarCarro','carro@limpiarCarro')->name('limpiar_carrito');
Route::get('/eliminarProducto/{id_producto}','carro@eliminarproducto')->name('eliminar_producto');
Route::get('/cambiarCantidad/{id_producto}/{cantidad}','carro@cambiarCantidad')->name('cambiar_cantidad');
Route::get('/cambiarCantidadVer/{id_producto}/{cantidad}','carro@cambiarCantidaVer')->name('cambiar_cantidad_ver');

Route::post('/realizarCompra','Correo@realizarCompra')->name('realizarCompra');

//RUTAS USUARIO
Route::post('/insertarUsuario','usuarios@insertarUsuario')->name('insertarUsuario');
Route::get('/iniciarSesion','usuarios@iniciarSesion')->name('iniciarSesion');
Route::get('/cerrarSesion','usuarios@cerrarSesion')->name('cerrarSesion');
Route::post('/usuarioModificado','usuarios@modificarUsuario')->name('usuarioModificado');
Route::get('/eliminarUsuario','usuarios@eliminarUsuario')->name('eliminarUsuario');

Route::get('/modificarUsuario','usuarios@verModificar')->name('modificarUsuario');
Route::get('/verPedidos','usuarios@verPedidos')->name('verPedidos');

Route::get('/pdfVerFacturas/{cod}','usuarios@pdfVerFacturas')->name('pdfVerFacturas');
Route::get('/cancelarPedido/{cod}','usuarios@cancelarPedido')->name('cancelarPedido');


//Email
Route::get('/mandarCorreo','Correo@correoPrueba')->name('mandarCorreo');
Route::get('/recuperarContrasena','Correo@recuperarContrasena')->name('recuperarContrasena');



//Route::get('contar','carro@contarProductos')->name('contar_carro');



//Route::view('/hola', 'yoqse', ['name' => 'Taylor'])->name('yoqse');
//Route::view('/foto', 'fotos', ['name' => 'Taylor'])->name('foto');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
