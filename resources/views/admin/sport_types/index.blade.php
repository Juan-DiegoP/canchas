@extends('layouts.app')

@section('title', 'Deportes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Deportes</h1>
        <a href="{{ route('admin.sport-types.create') }}" class="btn btn-primary">Nuevo deporte</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Icono</th>
                    <th># Canchas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sportTypes as $sportType)
                    <tr>
                        <td>{{ $sportType->name }}</td>
                        <td>{{ $sportType->icon }}</td>
                        <td>{{ $sportType->fields_count }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.sport-types.edit', $sportType) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <form method="POST" action="{{ route('admin.sport-types.destroy', $sportType) }}" class="d-inline" data-confirm="¿Eliminar este deporte?">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay deportes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $sportTypes->links() }}
@endsection