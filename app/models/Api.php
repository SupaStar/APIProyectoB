<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = "apis";
    protected $fillable = ['nombre', 'ruta'];
}