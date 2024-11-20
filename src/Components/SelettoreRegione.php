<?php

namespace DarioBarila\ComuniItaliani\Components;

use DarioBarila\ComuniItaliani\Models\Regione;

class SelettoreRegione extends BaseComponent
{
    public ?int $selectedRegione = null;

    public function getRegioni()
    {
        return Regione::orderBy('nome')->get();
    }

    public function updatedSelectedRegione($value)
    {
        $this->dispatch('regione-selected', regioneId: $value);
    }

    public function render()
    {
        return view('comuni-italiani::selettore-regione', [
            'regioni' => $this->getRegioni(),
        ]);
    }
}
