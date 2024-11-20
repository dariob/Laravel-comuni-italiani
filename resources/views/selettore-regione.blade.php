<div class="{{ $this->getWrapperClass() }}">
    <label for="regione" class="{{ $this->getLabelClass() }}">Regione</label>
    <select 
        wire:model.live="selectedRegione" 
        wire:model="value"
        id="regione" 
        class="{{ $this->getSelectClass() }}"
    >
        <option value="">Seleziona una regione</option>
        @foreach($regioni as $regione)
            <option value="{{ $regione->id }}">{{ $regione->nome }}</option>
        @endforeach
    </select>
</div>
