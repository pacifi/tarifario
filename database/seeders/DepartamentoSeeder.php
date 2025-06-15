<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nombre' => 'Secretaría General', 'descripcion' => 'Oficina de Secretaría General'],
            ['nombre' => 'Centro de Idiomas', 'descripcion' => 'Área de enseñanza de idiomas'],
            ['nombre' => 'Admisión', 'descripcion' => 'Oficina encargada del proceso de admisión'],
        ];

        foreach ($data as $item) {
            Departamento::firstOrCreate(['nombre' => $item['nombre']], ['descripcion' => $item['descripcion']]);
        }
    }
}
