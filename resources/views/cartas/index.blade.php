@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Listado de cartas para la temática: ' . $tematica->titulo)

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/select2/select2.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/animate-css/animate.scss',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/cleavejs/cleave.js',
  'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
  'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/cartas-management.js'])
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ $tematica->titulo }}</h4>
            <button type="button" class="btn btn-primary" id="add-carta">
                Agregar Nueva Carta
            </button>
            <a href="{{ route('cartas.export', ['tematica' => $tematica->id]) }}" target="_blank" class="btn btn-success">Exportar CSV</a>
            <form action="{{ route('cartas.import', ['tematica' => $tematica->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".csv">
                <button type="submit" class="btn btn-primary">Importar Cartas</button>
            </form>            
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table datatables-cartas" id="cartas">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="max-width: 120px;">Título</th>
                            <th style="max-width: 180px;">Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartas as $carta)
                            <tr>
                                <td>{{ $carta->id }}</td>
                                <td>{{ $carta->titulo }}</td>
                                <td>{!! $carta->descripcion !!}</td>
                                <td>
                                    <button 
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" 
                                        data-id="{{$carta->id}}"
                                        data-titulo="{{$carta->titulo}}"
                                        data-descripcion="{{$carta->descripcion}}"
                                    >
                                        <i class="ri-edit-box-line ri-20px"></i>
                                    </button>
                            
                                    <button type="button" class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" data-url="{{ route('tematicas.cartas.destroy', ['tematica' => $tematica->id, 'carta' => $carta->id]) }}">
                                        <i class="ri-delete-bin-7-line ri-20px"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offcanvas to add new carta -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCarta" aria-labelledby="offcanvasAddCartaLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasAddCartaLabel" class="offcanvas-title">Agregar Nueva Carta</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form class="add-new-carta pt-0" id="cartaForm" action="" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="id" id="id" value="">
                    <input type="hidden" name="tematica_id" id="tematica_id" value="{{$tematica->id}}">
                    <div class="form-floating form-floating-outline mb-5">
                        <input 
                            type="text" 
                            class="form-control" 
                            id="titulo" 
                            placeholder="Titulo" 
                            name="titulo" 
                            aria-label="Titulo" 
                            required
                        />
                        <label for="titulo">Titulo</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <textarea id="descripcion" name="descripcion" class="form-control h-px-100" placeholder="Descripción..." rows="3" required></textarea>
                        <label for="descripcion">Descripción</label>
                    </div>

                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Guardar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
