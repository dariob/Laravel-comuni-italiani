<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Comune;

class SelettoreComune extends BaseComponent
{
    public ?int $selectedComune = null;
    public ?int $provinciaId = null;
    public ?string $value = '';

    protected $listeners = [
        'provincia-selected' => 'setProvincia',
        'regione-selected' => 'resetComune'
    ];

    public function mount()
    {
        if ($this->value) {
            $comune = Comune::where('nome', $this->value)->first();
            if ($comune) {
                $this->selectedComune = $comune->id;
                $this->provinciaId = $comune->provincia_id;
            }
        }
    }

    public function setProvincia($provinciaId)
    {
        $this->provinciaId = $provinciaId;
        $this->selectedComune = null;
        $this->value = '';
    }

    public function resetComune()
    {
        $this->selectedComune = null;
        $this->provinciaId = null;
        $this->value = '';
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
        
        if ($value) {
            $comune = Comune::find($value);
            $this->value = $comune ? $comune->nome : '';
        } else {
            $this->value = '';
        }
    }

    public function render()
    {
        return view('comuni-italiani::selettore-comune', [
            'comuni' => $this->getComuni(),
        ]);
    }
}
