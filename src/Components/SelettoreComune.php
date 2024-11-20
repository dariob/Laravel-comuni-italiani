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
            $comune = Comune::with(['provincia.regione'])->find($value);
            $this->modelValue = $comune ? $comune->nome : '';

            // Dispatch dell'evento con tutte le informazioni
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
