@extends('layouts.app')

@section('title', $field->name)

@section('content')
    <div class="row">
        <div class="col-md-7">
            @if ($field->venue->image)
                <img src="{{ asset('storage/' . $field->venue->image) }}" class="img-fluid rounded mb-3" alt="{{ $field->venue->name }}">
            @endif
            <h1>{{ $field->name }}</h1>
            <p class="text-muted">{{ $field->venue->name }} — {{ $field->venue->address }}, {{ $field->venue->city }}</p>

            <span class="badge bg-light text-dark border">{{ $field->surfaceLabel() }}</span>
            <span class="badge bg-light text-dark border">{{ ucfirst($field->surface) }}</span>
            @if ($field->capacity)
                <span class="badge bg-light text-dark border">Capacidad: {{ $field->capacity }}</span>
            @endif

            <p class="mt-3">{{ $field->description }}</p>

            <h4 class="text-success">${{ number_format($field->price_per_hour, 0, ',', '.') }} / hora</h4>

            <h5 class="mt-4">Próximas reservas (no disponibles)</h5>
            @if ($reservations->isEmpty())
                <p class="text-muted">No hay reservas próximas para esta cancha.</p>
            @else
                <ul class="list-group mb-4">
                    @foreach ($reservations as $reservation)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $reservation->date->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} a {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</span>
                            <span class="badge bg-{{ $reservation->status === 'confirmed' ? 'success' : 'warning' }}">{{ $reservation->statusLabel() }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="col-md-5">
            @auth
                @if (auth()->user()->isCustomer())
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Reservar esta cancha</h5>

                            <form method="POST" action="{{ route('reservations.store', $field) }}">
                                @csrf
                                <input type="hidden" name="field_id" value="{{ $field->id }}">

                                <div class="mb-3">
                                    <label for="date" class="form-label">Fecha</label>
                                    <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" min="{{ now()->toDateString() }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="start_time" class="form-label">Hora inicio</label>
                                        <input type="time" id="start_time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time') }}" required>
                                        @error('start_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="end_time" class="form-label">Hora fin</label>
                                        <input type="time" id="end_time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time') }}" required>
                                        @error('end_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notas (opcional)</label>
                                    <textarea id="notes" name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Reservar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">Inicia sesión como cliente para reservar esta cancha.</div>
                @endif
            @else
                <div class="alert alert-info">
                    <a href="{{ route('login') }}">Inicia sesión</a> o <a href="{{ route('register') }}">regístrate</a> para reservar esta cancha.
                </div>
            @endauth
        </div>
    </div>
@endsection