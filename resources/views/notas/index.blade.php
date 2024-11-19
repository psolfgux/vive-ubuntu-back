@extends('layouts/layoutMaster')

@section('title', 'Notas')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Lista de Notas</h4>
        <!-- Botón para exportar las notas a CSV -->
        <a href="{{ route('notas.export') }}" class="btn btn-success">
            <i class="ri-file-download-line"></i> Exportar a CSV
        </a>
    </div>
    <div class="card-body">
        <!-- Tabla de Notas -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Temática</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Valor</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notas as $nota)
                        <tr>
                            <td>{{ $nota->id }}</td>
                            <td>{{ $nota->tematica->titulo }}</td>
                            <td>{{ $nota->player->name }}</td>
                            <td>{{ $nota->player->email }}</td>
                            <td>{{ $nota->valor }}</td>
                            <td>{{ $nota->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
