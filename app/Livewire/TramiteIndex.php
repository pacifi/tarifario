<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tramite;

class TramiteIndex extends Component
{
    public $tramites;
    public $titulo, $descripcion, $selectedId;

    public function mount()
    {
        $this->tramites = Tramite::all();
    }

    public function render()
    {
        return view('livewire.tramite-index')
            ->layout('layouts.app'); // ← esto es importante
    }

    public function save()
    {
        $this->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable'
        ]);

        Tramite::updateOrCreate(
            ['id' => $this->selectedId],
            ['titulo' => $this->titulo, 'descripcion' => $this->descripcion]
        );

        $this->resetFields();
        $this->tramites = Tramite::all();
    }

    public function edit($id)
    {
        $tramite = Tramite::findOrFail($id);
        $this->titulo = $tramite->titulo;
        $this->descripcion = $tramite->descripcion;
        $this->selectedId = $tramite->id;
    }

    public function delete($id)
    {
        Tramite::findOrFail($id)->delete();
        $this->tramites = Tramite::all();
    }

    public function resetFields()
    {
        $this->titulo = '';
        $this->descripcion = '';
        $this->selectedId = null;
    }
}
