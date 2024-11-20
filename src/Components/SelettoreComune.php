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
        if ($value) {
            $comune = Comune::with(['provincia.regione'])->find($value);
            
            if ($comune) {
                $this->dispatch('comuni-italiani::selezione-completa', [
                    'regione' => [
                        'id' => $comune->provincia->regione->id,
                        'nome' => $comune->provincia->regione->nome,
                        'codice_istat' => $comune->provincia->regione->codice_istat,
                    ],
                    'provincia' => [
                        'id' => $comune->provincia->id,
                        'nome' => $comune->provincia->nome,
                        'sigla' => $comune->provincia->sigla,
                        'codice_istat' => $comune->provincia->codice_istat,
                    ],
                    'comune' => [
                        'id' => $comune->id,
                        'nome' => $comune->nome,
                        'codice_istat' => $comune->codice_istat,
                        'codice_catastale' => $comune->codice_catastale,
                    ],
                ]);
            }
        }
    }

    public function render()
    {
        return view('comuni-italiani::selettore-comune', [
            'comuni' => $this->getComuni(),
        ]);
    }
}
