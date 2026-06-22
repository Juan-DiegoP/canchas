@extends('layouts.app')

@section('title', 'Ocupación semanal')

@section('content')
    <h1 class="mb-4">Ocupación semanal</h1>

    <form method="GET" action="{{ route('admin.occupancy') }}" class="row g-2 mb-4 align-items-end">
        <div class="col-md-4">
            <label for="field_id" class="form-label">Cancha</label>
            <select id="field_id" name="field_id" class="form-select" onchange="this.form.submit()">
                @foreach ($fields as $f)
                    <option value="{{ $f->id }}" @selected(optional($field)->id == $f->id)>
                        {{ $f->name }} — {{ $f->venue->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="week" value="{{ $weekStart->toDateString() }}">
        <div class="col-md-6">
            <div class="btn-group">
                <a href="{{ route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => $weekStart->copy()->subWeek()->toDateString()]) }}" class="btn btn-outline-secondary">&laquo; Semana anterior</a>
                <a href="{{ route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => now()->startOfWeek()->toDateString()]) }}" class="btn btn-outline-secondary">Hoy</a>
                <a href="{{ route('admin.occupancy', ['field_id' => optional($field)->id, 'week' => $weekStart->copy()->addWeek()->toDateString()]) }}" class="btn btn-outline-secondary">Semana siguiente &raquo;</a>
            </div>
        </div>
    </form>

    @if (! $field)
        <div class="alert alert-info">No hay canchas registradas todavía.</div>
    @else
        <p class="text-muted">Semana del {{ $weekStart->format('d/m/Y') }} al {{ $weekStart->copy()->addDays(6)->format('d/m/Y') }} — {{ $field->name }} ({{ $field->venue->name }})</p>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Hora</th>
                        @foreach ($days as $day)
                            <th class="{{ $day->isToday() ? 'table-warning text-dark' : '' }}">
                                {{ ucfirst($day->locale('es')->translatedFormat('D d/m')) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hours as $hour)
                        <tr>
                            <td class="fw-bold">{{ sprintf('%02d:00', $hour) }}</td>
                            @foreach ($days as $day)
                                @php
                                    $dateKey = $day->format('Y-m-d');
                                    $reservation = $occupancyMap[$dateKey][$hour] ?? null;
                                @endphp
                                @if ($reservation)
                                    <td class="bg-{{ $reservation->status === 'confirmed' ? 'success' : 'warning' }} bg-opacity-50" title="{{ $reservation->user->name }}">
                                        <small>{{ $reservation->status === 'confirmed' ? 'Confirmada' : 'Pendiente' }}</small>
                                    </td>
                                @else
                                    <td class="bg-light text-muted"><small>Libre</small></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection