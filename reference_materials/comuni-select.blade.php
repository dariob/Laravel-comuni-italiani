<div>
    <div class="row g-3 py-3 {{ $layout }}">
        <div class="col">
            <label for="selectedRegione" class="required">Regione</label>
            <select name="regione" id="selectedRegione" required wire:model.change="selectedRegione" class="form-select">
                <option disabled value="">Seleziona regione...</option>
                @foreach ($regioni as $regione)
                    <option value="{{ $regione->id }}">
                        {{ $regione->nome_regione }}
                    </option>
                @endforeach
            </select>
            @error('selectedRegione')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col">
            <label for="selectedProvincia" class="required">Provincia</label>
            <select name="provincia" id="selectedProvincia" required wire:model.change="selectedProvincia"
                class="form-select">
                <option disabled value="">Seleziona provincia...</option>
                @foreach ($province as $provincia)
                    <option value="{{ $provincia->id }}">
                        {{ $provincia->nome_provincia }}
                    </option>
                @endforeach
            </select>
            @error('selectedProvincia')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col">
            <label for="selectedComune" class="required">Comune</label>
            <select name="comune" id="selectedComune" wire:model.change="selectedComune" class="form-select">
                <option disabled value="">Seleziona comune...</option>
                @foreach ($comuni as $comune)
                    <option value="{{ $comune->id }}">
                        {{ $comune->nome_comune }}
                    </option>
                @endforeach
            </select>
            @error('comune')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
