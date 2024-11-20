<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Comune;

class SelettoreComune extends BaseComponent
{
    public ?int $selectedComune = null;
    public ?int $provinciaId = null;

    protected $listeners = [
        'provincia-selected' => 'setProvincia',
        'regione-selected' => 'resetComune'
    ];

    public function setProvincia($provinciaId)
    {
        $this->provinciaId = $provinciaId;
        $this->selectedComune = null;
    }

    public function resetComune()
    {
        $this->selectedComune = null;
        $this->provinciaId = null;
    }

    public function getComuni()
    {
        if (!$this->provinciaId) {
            return collect();
        }

        return Comune::where('provincia_id', $this->provinciaId)
            ->orderBy('nome')
            ->get();
    }

    public function updatedSelectedComune($value)
    {
        $this->dispatch('comune-selected', comune: $value);
    }

    public function render()
    {
        return view('comuni-italiani::selettore-comune', [
            'comuni' => $this->getComuni(),
        ]);
    }
}
