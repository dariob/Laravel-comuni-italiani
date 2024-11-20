<?php

namespace App\Livewire;

use App\Models\Comune;
use App\Models\Provincia;
use App\Models\Regione;
use Livewire\Component;


/**
 * Class ComuniSelect
 *
 * This class is a Livewire component responsible for handling the selection of regione, provincia, and comune.
 * It includes properties to store the selected regione, comune, and provincia, as well as the collections of regioni and comuni.
 * It provides several methods to handle updates to the selected values and to dispatch events when these values change.
 */
class ComuniSelect extends Component
{
    // Public properties
    public $selectedRegione = ""; // Selected regione
    public $selectedComune = ""; // Selected comune
    public $selectedProvincia = ""; // Selected provincia

    public $comuneName; // Comune name

    public $regioni = []; // Regioni collection
    public $comuni = []; // Comuni collection
    public $province = []; // Province collection
    public $layout = 'row-cols-md-3'; // Layout

    /**
     * Mount function
     *
     * Initializes the component and sets the initial values for the collections.
     * If $comuneName is provided, it retrieves the corresponding comune, provincia, and regione
     * and sets the selected values accordingly.
     */
    public function mount()
    {
        $this->comuni = collect();
        $this->province = collect();
        if ($this->comuneName) {
            $comune = Comune::where('nome_comune', $this->comuneName)->first();
            $this->selectedComune = $comune->id;
            $this->selectedProvincia = $comune->provincia_id;
            $this->selectedRegione = $comune->provincia->regione_id;
            $this->province = Provincia::where('regione_id', $this->selectedRegione)
                ->orderBy('id')->get();
            $this->comuni = Comune::where('provincia_id', $this->selectedProvincia)
                ->orderBy('nome_comune')->get();
        }
    }

    /**
     * Boot function
     *
     * Retrieves the regioni collection and sets it to $regioni property.
     */
    public function boot()
    {
        $this->regioni = Regione::orderBy('nome_regione')->get();
    }

    /**
     * Updated selected regione function
     *
     * Updates the province collection based on the selected regione.
     * Resets the selected comune, provincia, and comuni properties.
     * Dispatches a 'change-select-regione' event with the selected regione.
     */
    public function updatedSelectedRegione()
    {
        $this->province = Provincia::where('regione_id', $this->selectedRegione)
            ->orderBy('id')
            ->get();

        $this->reset([
            'selectedComune',
            'selectedProvincia',
            'comuni',
        ]);

        $this->dispatch('change-select-regione', ['regione' => $this->selectedRegione]);
    }

    /**
     * Updated selected provincia function
     *
     * Resets the selected comune property and retrieves the comuni collection based on the selected provincia.
     * Dispatches a 'change-select-provincia' event with the selected provincia.
     */
    public function updatedSelectedProvincia()
    {
        $this->selectedComune = "";
        $this->comuni = collect();
        $comuni = Comune::where('provincia_id', $this->selectedProvincia)
            ->orderBy('nome_comune')
            ->get();
        $this->comuni = $comuni;
        $this->dispatch('change-select-provincia', provincia: $this->selectedProvincia);
    }

    /**
     * Updated selected comune function
     *
     * Dispatches a 'change-select-comune' event with the selected comune.
     */
    public function updatedSelectedComune()
    {
        $this->dispatch('change-select-comune', comune: $this->selectedComune);
    }

    /**
     * Render function
     *
     * Renders the Livewire component view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.comuni-select');
    }
}
