<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Provincia;

class SelettoreProvincia extends BaseComponent
{
    public ?int $selectedProvincia = null;
    public ?int $regioneId = null;

    protected $listeners = ['regione-selected' => 'setRegione'];

    public function mount()
    {
        // No changes here
    }

    public function setRegione($regioneId)
    {
        $this->regioneId = $regioneId;
        $this->selectedProvincia = null;
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
    }

    public function render()
    {
        return view('comuni-italiani::selettore-provincia', [
            'province' => $this->getProvince(),
        ]);
    }
}
