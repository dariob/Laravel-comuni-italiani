<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Regione;

class SelettoreRegione extends BaseComponent
{
    public ?int $selectedRegione = null;
    public $modelValue = '';

    public function mount()
    {
        if ($this->modelValue) {
            $regione = Regione::where('nome', $this->modelValue)->first();
            if ($regione) {
                $this->selectedRegione = $regione->id;
            }
        }
    }

    public function updatedSelectedRegione($value)
    {
        $this->dispatch('regione-selected', regioneId: $value);
        
        if ($value) {
            $regione = Regione::find($value);
            $this->modelValue = $regione ? $regione->nome : '';
        } else {
            $this->modelValue = '';
        }
    }

    public function getRegioni()
    {
        return Regione::orderBy('nome')->get();
    }

    public function render()
    {
        return view('comuni-italiani::selettore-regione', [
            'regioni' => $this->getRegioni(),
        ]);
    }
}
