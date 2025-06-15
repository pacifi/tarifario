<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NivelAcademico;

class NivelAcademicoIndex extends Component
{
    public $niveles, $nombre, $descripcion, $selectedId;

    public function mount()
    {
        $this->niveles = NivelAcademico::all();
    }

    public function render()
    {
        return view('livewire.nivel-academico-index')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required|unique:niveles_academicos,nombre,' . $this->selectedId,
            'descripcion' => 'nullable|string'
        ]);

        NivelAcademico::updateOrCreate(
            ['id' => $this->selectedId],
            ['nombre' => $this->nombre, 'descripcion' => $this->descripcion]
        );

        $this->resetFields();
        $this->niveles = NivelAcademico::all();
    }

    public function edit($id)
    {
        $nivel = NivelAcademico::findOrFail($id);
        $this->nombre = $nivel->nombre;
        $this->descripcion = $nivel->descripcion;
        $this->selectedId = $nivel->id;
    }

    public function delete($id)
    {
        NivelAcademico::findOrFail($id)->delete();
        $this->niveles = NivelAcademico::all();
    }

    public function resetFields()
    {
        $this->reset(['nombre', 'descripcion', 'selectedId']);
    }
}
