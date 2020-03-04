<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //quita los datos created_at y updated_at
    protected $table = "lv_facturas";


    public $timestamps = false;

 }