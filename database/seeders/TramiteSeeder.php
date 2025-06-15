<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tramite;

class TramiteSeeder extends Seeder
{
    public function run(): void
    {
        $tramites = [
            'Autenticación',
            'Acta',
            'Certificación',
            'Certificado',
            'Constancia',
            'Convalidacion',
            'Convalidación',
            'Derecho',
            'Diplomatura',
            'Duplicado',
            'Evaluaciones',
            'Diploma',
            'Legalización',
            'Record',
            'Rectificación',
            'Revalida',
            'Revalidad',
            'Título',
            'Transcripción',
            'Traslados',
            'Coutas',
            'Examen',
            'Grado'
        ];

        foreach ($tramites as $titulo) {
            Tramite::firstOrCreate(
                ['titulo' => $titulo],
                ['descripcion' => $titulo]
            );
        }
    }
}
