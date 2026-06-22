@extends('layouts.app')

@section('title', 'Complejos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Complejos deportivos</h1>
        <a href="{{ route('admin.venues.create') }}" class="btn btn-primary">Nuevo complejo</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Teléfono</th>
                    <th># Canchas</th>
                    <th>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($venues as $venue)
                    <tr>
                        <td>{{ $venue->name }}</td>
                        <td>{{ $venue->city }}</td>
                        <td>{{ $venue->phone }}</td>
                        <td>{{ $venue->fields_count }}</td>
                        <td>
                            <span class="badge bg-{{ $venue->active ? 'success' : 'secondary' }}">
                                {{ $venue->active ? 'Sí' : 'No' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.venues.edit', $venue) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="{{ route('admin.venues.destroy', $venue) }}" class="d-inline" data-confirm="¿Eliminar este complejo?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay complejos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $venues->links() }}
@endsection