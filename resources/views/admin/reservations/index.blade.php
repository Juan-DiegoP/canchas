@extends('layouts.app')

@section('title', 'Reservas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Reservas</h1>
        <a href="{{ route('admin.occupancy') }}" class="btn btn-outline-primary">Ver ocupación semanal</a>
    </div>

    <form method="GET" action="{{ route('admin.reservations.index') }}" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Todos los estados</option>
                <option value="pending" @selected(request('status') == 'pending')>Pendiente</option>
                <option value="confirmed" @selected(request('status') == 'confirmed')>Confirmada</option>
                <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelada</option>
            </select>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
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
                @forelse ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
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
                        <td class="text-end">
                            @if ($reservation->status === 'pending')
                                <form method="POST" action="{{ route('admin.reservations.confirm', $reservation) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Confirmar</button>
                                </form>
                            @endif
                            @if ($reservation->status !== 'cancelled')
                                <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}" class="d-inline" data-confirm="¿Cancelar esta reserva?">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No hay reservas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reservations->links() }}
@endsection