<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Comune;

class SelettoreComune extends BaseComponent
{
    public ?int $selectedComune = null;
    public ?int $provinciaId = null;
    public $modelValue = '';

    protected $listeners = [
        'provincia-selected' => 'setProvincia',
        'regione-selected' => 'resetComune'
    ];

    public function mount()
    {
        if ($this->modelValue) {
            $comune = Comune::where('nome', $this->modelValue)->first();
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
        $this->modelValue = '';
    }

    public function resetComune()
    {
        $this->selectedComune = null;
        $this->provinciaId = null;
        $this->modelValue = '';
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
            $this->modelValue = $comune ? $comune->nome : '';
        } else {
            $this->modelValue = '';
        }
    }

    public function render()
    {
        return view('comuni-italiani::selettore-comune', [
            'comuni' => $this->getComuni(),
        ]);
    }
}
