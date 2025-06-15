<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Departamento;

class DepartamentoIndex extends Component
{
    public $departamentos;
    public $nombre, $descripcion, $selectedId;

    public function mount()
    {
        $this->departamentos = Departamento::all();
    }

    public function render()
    {
        return view('livewire.departamento-index')
            ->layout('layouts.app');
    }

    public function save()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable'
        ]);

        Departamento::updateOrCreate(
            ['id' => $this->selectedId],
            ['nombre' => $this->nombre, 'descripcion' => $this->descripcion]
        );

        $this->resetFields();
        $this->departamentos = Departamento::all();
    }

    public function edit($id)
    {
        $dep = Departamento::findOrFail($id);
        $this->nombre = $dep->nombre;
        $this->descripcion = $dep->descripcion;
        $this->selectedId = $dep->id;
    }

    public function delete($id)
    {
        Departamento::findOrFail($id)->delete();
        $this->departamentos = Departamento::all();
    }

    public function resetFields()
    {
        $this->reset(['nombre', 'descripcion', 'selectedId']);
    }
}
