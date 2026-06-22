@extends('layouts.app')

@section('title', 'Mis reservas')

@section('content')
    <h1 class="mb-4">Mis reservas</h1>

    @if ($reservations->isEmpty())
        <div class="alert alert-info">Todavía no tienes reservas. <a href="{{ route('fields.index') }}">Busca una cancha</a> para reservar.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Cancha</th>
                        <th>Complejo</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->field->name }}</td>
                            <td>{{ $reservation->field->venue->name }}</td>
                            <td>{{ $reservation->date->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservation->end_time)->format('H:i') }}</td>
                            <td>${{ number_format($reservation->total_price, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badge = match ($reservation->status) {
                                        'pending' => 'warning',
                                        'confirmed' => 'success',
                                        'cancelled' => 'danger',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $reservation->statusLabel() }}</span> 
                            </td>
                            <td>
                                @if ($reservation->status === 'pending')
                                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}" onsubmit="return confirm('¿Cancelar esta reserva?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $reservations->links() }}
        </div>
    @endif
@endsection