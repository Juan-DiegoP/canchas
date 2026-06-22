@extends('layouts.app')

@section('title', 'Canchas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Canchas</h1>
        <a href="{{ route('admin.fields.create') }}" class="btn btn-primary">Nueva cancha</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Complejo</th>
                    <th>Deporte</th>
                    <th>Precio/hora</th>
                    <th>Superficie</th>
                    <th>Activa</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fields as $field)
                    <tr>
                        <td>{{ $field->name }}</td>
                        <td>{{ $field->venue->name }}</td>
                        <td>{{ $field->sportType->name }}</td>
                        <td>${{ number_format($field->price_per_hour, 0, ',', '.') }}</td>
                        <td>{{ $field->surfaceLabel() }}</td>
                        <td>
                            <span class="badge bg-{{ $field->active ? 'success' : 'secondary' }}">
                                {{ $field->active ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.fields.edit', $field) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="{{ route('admin.fields.destroy', $field) }}" class="d-inline" data-confirm="¿Eliminar esta cancha?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay canchas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $fields->links() }}
@endsection