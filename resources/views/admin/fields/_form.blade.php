<div class="row">
    <div class="col-md-6 mb-3">
        <label for="venue_id" class="form-label">Complejo</label>
        <select id="venue_id" name="venue_id" class="form-select @error('venue_id') is-invalid @enderror" required>
            <option value="">Selecciona un complejo</option>
            @foreach ($venues as $venue)
                <option value="{{ $venue->id }}" @selected(old('venue_id', $field->venue_id ?? '') == $venue->id)>
                    {{ $venue->name }}
                </option>
            @endforeach
        </select>
        @error('venue_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="sport_type_id" class="form-label">Deporte</label>
        <select id="sport_type_id" name="sport_type_id" class="form-select @error('sport_type_id') is-invalid @enderror" required>
            <option value="">Selecciona un deporte</option>
            @foreach ($sportTypes as $sportType)
                <option value="{{ $sportType->id }}" @selected(old('sport_type_id', $field->sport_type_id ?? '') == $sportType->id)>
                    {{ $sportType->name }}
                </option>
            @endforeach
        </select>
        @error('sport_type_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $field->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $field->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="price_per_hour" class="form-label">Precio por hora</label>
        <input type="number" step="0.01" min="0" id="price_per_hour" name="price_per_hour" class="form-control @error('price_per_hour') is-invalid @enderror" value="{{ old('price_per_hour', $field->price_per_hour ?? '') }}" required>
        @error('price_per_hour')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="capacity" class="form-label">Capacidad</label>
        <input type="number" min="1" id="capacity" name="capacity" class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity', $field->capacity ?? '') }}">
        @error('capacity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label for="surface" class="form-label">Superficie</label>
        <select id="surface" name="surface" class="form-select @error('surface') is-invalid @enderror" required>
            @foreach (['grass' => 'Césped', 'synthetic' => 'Sintética', 'cement' => 'Cemento'] as $value => $label)
                <option value="{{ $value }}" @selected(old('surface', $field->surface ?? 'synthetic') == $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('surface')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<input type="hidden" name="active" value="0">
<div class="mb-3 form-check">
    <input type="checkbox" id="active" name="active" value="1" class="form-check-input" {{ old('active', $field->active ?? true) ? 'checked' : '' }}>
    <label for="active" class="form-check-label">Activa</label>
</div>