@extends('layouts.app')

@section('title', 'Canchas disponibles')

@section('content')
    <h1 class="mb-4">Canchas disponibles</h1>

    <form method="GET" action="{{ route('fields.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <select name="sport_type_id" class="form-select">
                <option value="">Todos los deportes</option>
                @foreach ($sportTypes as $sportType)
                    <option value="{{ $sportType->id }}" @selected(request('sport_type_id') == $sportType->id)>
                        {{ $sportType->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="city" class="form-select">
                <option value="">Todas las ciudades</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}" @selected(request('city') == $city)>{{ $city }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('fields.index') }}" class="btn btn-outline-secondary w-100">Limpiar</a>
        </div>
    </form>

    <div class="row g-4">
        @forelse ($fields as $field)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if ($field->venue->image)
                        <img src="{{ asset('storage/' . $field->venue->image) }}" class="card-img-top" alt="{{ $field->venue->name }}" style="height: 180px; object-fit: cover;">
                    @else
                        <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="bi bi-image text-secondary fs-1"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">{{ $field->sportType->name }}</span>
                        <h5 class="card-title">{{ $field->name }}</h5>
                        <p class="card-subtitle text-muted mb-2">{{ $field->venue->name }} — {{ $field->venue->city }}</p>
                        <p class="card-text">{{ Str::limit($field->description, 80) }}</p>
                        <p class="fw-bold text-success">${{ number_format($field->price_per_hour, 0, ',', '.') }} / hora</p>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('fields.show', $field) }}" class="btn btn-outline-primary w-100">Ver disponibilidad</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No hay canchas disponibles con esos filtros.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $fields->links() }}
    </div>
@endsection