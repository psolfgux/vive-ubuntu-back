@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Listado de Jugadores')


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
@vite(['resources/js/players-management.js'])
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Listado de jugadores</h4>
            <!--<button type="button" class="btn btn-primary" id="addNewTematicaButton">
                Agregar Nuevo jugador
            </button>-->
        </div>
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table datatables-players" id="players">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($players as $player)
                            <tr>
                                <td>{{ $player->id }}</td>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->email }}</td>
                                <td>{{ $player->created_at }}</td>
                                <td>
                                    <!--<button 
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect" 
                                        data-id="{{$player->id}}"
                                        data-name="{{$player->name}}"
                                        data-email="{{$player->email}}" 
                                        data-bs-toggle="offcanvas" 
                                        data-bs-target="#offcanvasEditUser"
                                    >
                                        <i class="ri-edit-box-line ri-20px"></i>
                                    </button>-->

                                    <button 
                                        type="button" 
                                        class="btn btn-sm btn-icon delete-record btn-text-secondary rounded-pill waves-effect" 
                                        data-url="{{ route('players.destroy', $player) }}"
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
                <h5 id="offcanvasUserLabel" class="offcanvas-title">Agregar o Editar Player</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 h-100">
                <form id="userForm" action="{{ route('players.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="method" value="POST">
                    <input type="hidden" name="tematica_id" id="tematica_id" value="">

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="name" placeholder="Nombre" name="name" aria-label="Nombre" required />
                        <label for="name">Nombre</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="email" placeholder="Email" name="email" aria-label="Email" required />
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-5">
                        <input type="text" class="form-control" id="password" placeholder="Password" name="password" aria-label="Password" required />
                        <label for="password">Password</label>
                    </div>


                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Guardar</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>


@endsection
