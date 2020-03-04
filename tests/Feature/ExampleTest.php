<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_usuario()
    {
        $response = $this->get('/');

        $response->assertStatus(500);
    }
    public function test_Example()
    {
        $this->get('/usuario')->assertStatus(500);
    }

    public function test_cerrarSesion()
    {
        $response = $this->get('/cerrarSesion');

        $response->assertStatus(302);
    }
    public function test_carrito()
    {
        $response = $this->get('/carrito');

        $response->assertStatus(500);
    }
    public function test_registro()
    {
        $response = $this->get('/registro');

        $response->assertStatus(500);
    }
    public function test_datos()
    {
        $response = $this->get('/datos/2');

        $response->assertStatus(500);
    }
    public function test_lista_producto()
    {
        $response = $this->get('/listaProductos/2/2');

        $response->assertStatus(500);
    }
    public function test_lista_producto_2()
    {
        $response = $this->get('/listaProductos');

        $response->assertStatus(500);
    }
    public function test_cantidad()
    {
        $response = $this->get('/cambiarCantidad/1/3');

        $response->assertStatus(500);
    }
}
