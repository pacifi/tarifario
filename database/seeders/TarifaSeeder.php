<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarifa;
use App\Models\Tramite;
use App\Models\Departamento;
use App\Models\NivelAcademico;

class TarifaSeeder extends Seeder
{
    public function run(): void
    {
        $tramites = Tramite::all();
        $departamentos = Departamento::all();
        $niveles = NivelAcademico::all();

        // Validación básica
        if ($tramites->isEmpty() || $departamentos->isEmpty() || $niveles->isEmpty()) {
            $this->command->warn('Asegúrate de tener tramites, departamentos y niveles académicos antes de ejecutar este seeder.');
            return;
        }

        $conceptos = [
            'Emisión de certificado',
            'Convalidación de estudios',
            'Duplicado de diploma',
            'Legalización de documentos',
            'Trámite de título profesional'
        ];

        foreach ($conceptos as $concepto) {
            Tarifa::create([
                'concepto' => $concepto,
                'costo' => rand(50, 200), // Genera un monto aleatorio entre 50 y 200
                'tramite_id' => $tramites->random()->id,
                'departamento_id' => $departamentos->random()->id,
                'nivel_academico_id' => $niveles->random()->id,
            ]);
        }
    }
}

