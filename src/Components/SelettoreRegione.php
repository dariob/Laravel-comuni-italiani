<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Regione;

class SelettoreRegione extends BaseComponent
{
    public ?int $selectedRegione = null;
    public ?string $value = '';

    public function mount()
    {
        if ($this->value) {
            $regione = Regione::where('nome', $this->value)->first();
            if ($regione) {
                $this->selectedRegione = $regione->id;
            }
        }
    }

    public function getRegioni()
    {
        return Regione::orderBy('nome')->get();
    }

    public function updatedSelectedRegione($value)
    {
        $this->dispatch('regione-selected', regioneId: $value);
        
        if ($value) {
            $regione = Regione::find($value);
            $this->value = $regione ? $regione->nome : '';
        } else {
            $this->value = '';
        }
    }

    public function render()
    {
        return view('comuni-italiani::selettore-regione', [
            'regioni' => $this->getRegioni(),
        ]);
    }
}
