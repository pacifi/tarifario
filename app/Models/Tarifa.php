<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $fillable = ['concepto', 'costo', 'tramite_id', 'departamento_id', 'nivel_academico_id'];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function nivelAcademico()
    {
        return $this->belongsTo(NivelAcademico::class);
    }
}

