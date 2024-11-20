<div class="{{ $this->getWrapperClass() }}">
    <label for="provincia" class="{{ $this->getLabelClass() }}">Provincia</label>
    <select 
        wire:model.live="selectedProvincia" 
        wire:model="value"
        id="provincia" 
        class="{{ $this->getSelectClass() }}" 
        @if(!$regioneId) disabled @endif
    >
        <option value="">Seleziona una provincia</option>
        @foreach($province as $provincia)
            <option value="{{ $provincia->id }}">{{ $provincia->nome }} ({{ $provincia->sigla }})</option>
        @endforeach
    </select>
</div>
