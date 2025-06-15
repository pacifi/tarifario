<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarifa;
use App\Models\Tramite;
use App\Models\Departamento;
use App\Models\NivelAcademico;

class TarifaIndex extends Component
{
    public $tarifas;

    public $concepto = '';
    public $costo = '';
    public $tramite_id = '';
    public $departamento_id = '';
    public $nivel_academico_id = '';
    public $selectedId = null;

    public $mostrarFormulario = false;

    // Filtros
    public $filtroConcepto = '';
    public $filtroTramite = '';
    public $filtroDepartamento = '';
    public $filtroNivel = '';

    public function mount()
    {
        $this->actualizarConsulta();
    }

    public function render()
    {
        return view('livewire.tarifa-index', [
            'tramites' => Tramite::all(),
            'departamentos' => Departamento::all(),
            'niveles' => NivelAcademico::all(),
        ])->layout('layouts.app');
    }

    public function actualizarConsulta()
    {
        $query = Tarifa::with(['tramite', 'departamento', 'nivelAcademico']);

        if ($this->filtroConcepto !== '') {
            $query->where('concepto', 'ilike', '%' . $this->filtroConcepto . '%');
        }

        if ($this->filtroTramite !== '') {
            $query->where('tramite_id', $this->filtroTramite);
        }

        if ($this->filtroDepartamento !== '') {
            $query->where('departamento_id', $this->filtroDepartamento);
        }

        if ($this->filtroNivel !== '') {
            $query->where('nivel_academico_id', $this->filtroNivel);
        }

        $this->tarifas = $query->get();
    }

    public function toggleFormulario()
    {
        $this->mostrarFormulario = !$this->mostrarFormulario;
    }

    public function save()
    {
        $this->validate([
            'concepto' => 'required|string|max:255',
            'costo' => 'required|numeric|min:0',
            'tramite_id' => 'required|exists:tramites,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'nivel_academico_id' => 'required|exists:niveles_academicos,id',
        ]);

        Tarifa::updateOrCreate(
            ['id' => $this->selectedId],
            [
                'concepto' => $this->concepto,
                'costo' => $this->costo,
                'tramite_id' => $this->tramite_id,
                'departamento_id' => $this->departamento_id,
                'nivel_academico_id' => $this->nivel_academico_id,
            ]
        );

        $this->resetFields();
        $this->actualizarConsulta();
    }

    public function edit($id)
    {
        $tarifa = Tarifa::findOrFail($id);
        $this->selectedId = $tarifa->id;
        $this->concepto = $tarifa->concepto;
        $this->costo = $tarifa->costo;
        $this->tramite_id = $tarifa->tramite_id;
        $this->departamento_id = $tarifa->departamento_id;
        $this->nivel_academico_id = $tarifa->nivel_academico_id;
        $this->mostrarFormulario = true;
    }

    public function delete($id)
    {
        Tarifa::findOrFail($id)->delete();
        $this->resetFields();
        $this->actualizarConsulta();
    }

    public function resetFields()
    {
        $this->selectedId = null;
        $this->concepto = '';
        $this->costo = '';
        $this->tramite_id = '';
        $this->departamento_id = '';
        $this->nivel_academico_id = '';
        $this->mostrarFormulario = false;
    }
}
