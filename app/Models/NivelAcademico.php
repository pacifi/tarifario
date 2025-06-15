<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelAcademico extends Model
{
    //
    protected $table = 'niveles_academicos'; // ← agrega esta línea

    protected $fillable = ['nombre', 'descripcion'];
}
