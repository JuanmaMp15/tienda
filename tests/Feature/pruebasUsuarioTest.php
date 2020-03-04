<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class pruebasUsuario extends TestCase
{
    /**@test*/
    public function test_Example()
    {
        $this->get('/usuario')->assertStatus(500);

    }
        /**@test*/

    public function test_cerrarSesion()
    {
        $response = $this->get('/cerrarSesion');

        $response->assertStatus(302);
    }
}
