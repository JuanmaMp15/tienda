<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    //quita los datos created_at y updated_at
    protected $table = "lv_usuarios";


    public $timestamps = false;

 }