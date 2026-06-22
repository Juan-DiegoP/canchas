<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $venue->name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-8 mb-3">
        <label for="address" class="form-label">Dirección</label>
        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $venue->address ?? '') }}" required>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label for="city" class="form-label">Ciudad</label>
        <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city', $venue->city ?? '') }}" required>
        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label">Descripción</label>
    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $venue->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $venue->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="image" class="form-label">Imagen</label>
        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @isset($venue)
            @if ($venue->image)
                <img src="{{ asset('storage/' . $venue->image) }}" alt="{{ $venue->name }}" class="img-thumbnail mt-2" style="max-height: 100px;">
            @endif
        @endisset
    </div>
</div>

<input type="hidden" name="active" value="0">
<div class="mb-3 form-check">
    <input type="checkbox" id="active" name="active" value="1" class="form-check-input" {{ old('active', $venue->active ?? true) ? 'checked' : '' }}>
    <label for="active" class="form-check-label">Activo</label>
</div>