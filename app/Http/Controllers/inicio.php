<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\DB;


class inicio extends Controller
{

    public function usuario()
    {
        return view('usuario');
    }

    public function registro()
    {
        return view("registrarse");
    }
}
