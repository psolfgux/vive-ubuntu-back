@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Listado de tematicas')


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
@vite(['resources/js/tematicas-management.js'])
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Listado de tematicas</h4>
            <button type="button" class="btn btn-primary" id="addNewTematicaButton">
                Agregar Nueva Temática
            </button>
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table datatables-users" id="tematicas">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="max-width: 70px;">Título</th>
                            <th style="max-width: 140px;">Descripción</th>
                            <th>Orden</th>
                            <th>Color</th>
                            <th>Imagen</th>
                            <th>Fondo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tematicas as $tematica)
                            <tr>
                                <td>{{ $tematica->id }}</td>
                                <td>{{ $tematica->titulo }}</td>
                                <td>{{ $tematica->descripcion }}</td>
                                <td>{{ $tematica->orden }}</td>
                                <td><span style="background-color: {{ $tematica->color }}; padding: 0px;">{{ $tematica->color }}</span></td>
                                <td>
                                    @if($tematica->image)
                                        <img src="{{ asset('storage/' . $tematica->image) }}" alt="Imagen de la temática" width="50" height="50">
                                    @else
                                        Sin imagen
                                    @endif
                                </td>
                                <td>
                                    @if($tematica->fondo)
                                        <img src="{{ asset('storage/' . $tematica->fondo) }}" alt="Fondo de la temática" width="50" height="50">
                                    @else
                                        Sin fondo
                                    @endif
                                </td>
                                <td>
                                    <a 
                                        href="{{ url('tematicas/' . $tematica->id . '/cartas') }}" 
                                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect"
                                    >
                                        <i class="ri-file-list-line ri-20px"></i>
                                    </a>
                                    <button 
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" 
                                        data-id="{{$tematica->id}}"
                                        data-titulo="{{$tematica->titulo}}"
                                        data-descripcion="{{$tematica->descripcion}}"
                                        data-orden="{{$tematica->orden}}"
                                        data-color="{{$tematica->color}}" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#offcanvasEditUser"
                                    >
                                        <i class="ri-edit-box-line ri-20px"></i>
                                    </button>

                                    <button 
                                        type="button" 
                                        class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" 
                                        data-url="{{ route('tematicas.destroy', $tematica) }}"
                                    >
                                        <i class="ri-delete-bin-7-line ri-20px"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offcanvas to add or edit user -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasUser" aria-labelledby="offcanvasUserLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasUserLabel" class="offcanvas-title">Agregar o Editar Temática</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form id="userForm" action="{{ route('tematicas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="tematica_id" id="tematica_id" value="">

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="titulo" placeholder="Titulo" name="titulo" aria-label="Titulo" required />
                        <label for="titulo">Titulo</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <textarea id="descripcion" name="descripcion" class="form-control h-px-100" placeholder="Descripción..." rows="3" required></textarea>
                        <label for="descripcion">Descripción</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="number" name="orden" class="form-control" id="orden" required placeholder="0">
                        <label for="orden">Orden</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="color" name="color" class="form-control" id="color" value="#5BC5C3" required>
                        <label for="color">Color</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="file" name="image" class="form-control" id="image">
                        <label for="image">Imagen</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="file" name="fondo" class="form-control" id="fondo">
                        <label for="fondo">Fondo (Imagen)</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Guardar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>


@endsection
