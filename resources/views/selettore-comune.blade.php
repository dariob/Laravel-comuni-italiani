<div class="{{ $this->getWrapperClass() }}">
    <label for="comune" class="{{ $this->getLabelClass() }}">Comune</label>
    <select 
        wire:model.live="selectedComune" 
        wire:model="modelValue"
        id="comune" 
        name="comune"
        class="{{ $this->getSelectClass() }}"
        @if(!$provinciaId) disabled @endif
    >
        <option value="">Seleziona un comune</option>
        @foreach($comuni as $comune)
            <option value="{{ $comune->id }}">{{ $comune->nome }}</option>
        @endforeach
    </select>
</div>
