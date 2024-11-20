<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Provincia;

class SelettoreProvincia extends BaseComponent
{
    public ?int $selectedProvincia = null;
    public ?int $regioneId = null;
    public $modelValue = '';

    protected $listeners = ['regione-selected' => 'setRegione'];

    public function mount()
    {
        if ($this->modelValue) {
            $provincia = Provincia::where('nome', $this->modelValue)->first();
            if ($provincia) {
                $this->selectedProvincia = $provincia->id;
                $this->regioneId = $provincia->regione_id;
            }
        }
    }

    public function setRegione($regioneId)
    {
        $this->regioneId = $regioneId;
        $this->selectedProvincia = null;
        $this->modelValue = '';
    }

    public function getProvince()
    {
        if (!$this->regioneId) {
            return collect();
        }

        return Provincia::where('regione_id', $this->regioneId)
            ->orderBy('nome')
            ->get();
    }

    public function updatedSelectedProvincia($value)
    {
        $this->dispatch('provincia-selected', provinciaId: $value);
        
        if ($value) {
            $provincia = Provincia::find($value);
            $this->modelValue = $provincia ? $provincia->nome : '';
        } else {
            $this->modelValue = '';
        }
    }

    public function render()
    {
        return view('comuni-italiani::selettore-provincia', [
            'province' => $this->getProvince(),
        ]);
    }
}
