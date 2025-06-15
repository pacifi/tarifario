<?php

namespace Database\Seeders;

use App\Models\NivelAcademico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelAcademicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            ['nombre' => 'Pregrado', 'descripcion' => 'Carreras profesionales universitarias.'],
            ['nombre' => 'Posgrado', 'descripcion' => 'Maestrías, doctorados y especializaciones.']
        ];

        foreach ($niveles as $nivel) {
            NivelAcademico::firstOrCreate(['nombre' => $nivel['nombre']], ['descripcion' => $nivel['descripcion']]);
        }
    }
}
