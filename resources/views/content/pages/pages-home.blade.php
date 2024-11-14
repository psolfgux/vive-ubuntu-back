@extends('layouts/layoutMaster')

@section('title', 'Vive Ubuntu - Dashboard - App')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
  'resources/assets/vendor/libs/apex-charts/apex-charts.scss'
  ])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/apex-charts/apexcharts.js',
  ])
@endsection

@section('page-script')
@vite('resources/assets/js/app-academy-dashboard.js')
@endsection

@section('content')
<!-- Hour chart  -->
<div class="card bg-transparent shadow-none border-0 mb-6">
  <div class="card-body row g-6 p-0 pb-5">
    <div class="col-12 col-md-12">
      <h5 class="mb-2">Bienvenido a<span class="h4 fw-semibold"> Vive Ubuntu</span></h5>
      <div class="col-12 col-lg-5">
        <p>Aqui se puede ver el progreso de juego de los usuario de la web App</p>
      </div>
      <div class="d-flex justify-content-between flex-wrap gap-4 me-12">
        <div class="d-flex align-items-center gap-4 me-6 me-sm-0">
          <div class="avatar avatar-lg">
            <div class="avatar-initial bg-label-primary rounded-3">
              <div>
                <img src="{{asset('assets/svg/icons/user-info.svg')}}" alt="paypal" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="content-right">
            <p class="mb-1 fw-medium">Jugadores</p>
            <span class="text-primary mb-0 h5">{{$totalPlayers}}</span>
          </div>
        </div>
        <div class="d-flex align-items-center gap-4">
          <div class="avatar avatar-lg">
            <div class="avatar-initial bg-label-info rounded-3">
              <div>
                <img src="{{asset('assets/svg/icons/lightbulb.svg')}}" alt="Lightbulb" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="content-right">
            <p class="mb-1 fw-medium">Tematicas</p>
            <span class="text-info mb-0 h5">{{$totalTematicas}}</span>
          </div>
        </div>
        <div class="d-flex align-items-center gap-4">
          <div class="avatar avatar-lg">
            <div class="avatar-initial bg-label-warning rounded-3">
              <div>
                <img src="{{asset('assets/svg/icons/check.svg')}}" alt="Check" class="img-fluid">
              </div>
            </div>
          </div>
          <div class="content-right">
            <p class="mb-1 fw-medium">Cartas vistas </p>
            <span class="text-warning mb-0 h5">{{$totalCards}}</span>
          @foreach ($tematicaCounts as $count)
          @endforeach
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!-- Hour chart End  -->

<!-- Topic and Instructors -->
<div class="row mb-6 g-6">

  <!-- Topic you are interested in -->
  <div class="col-12 col-xxl-8">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Tematicas elegidas</h5>
        <input id="labels1" type="hidden" value='@json($tematicaCounts->pluck("titulo"))'>
        <input id="ntematicas" type="hidden" value="{{$totalTematicas}}" />
        <input id="data1" type="hidden" value='@json($tematicaCounts->pluck("player_count"))'>
      </div>
      <div class="card-body row g-3">
        <div class="col-md-6">
          <div id="horizontalBarChart"></div>
        </div>
        <div class="col-md-6 d-flex justify-content-around align-items-center">
          <div>
            @foreach ($tematicaCounts as $count)
              <div class="d-flex align-items-baseline">
                <span class="text-primary me-2"><i class='ri-circle-fill ri-12px'></i></span>
                <div>
                  <p class="mb-0">{{ $count->titulo }}</p>
                  <h5 class="mb-0">{{ $count->player_count }} Players</h5>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/ Topic you are interested in -->

  

</div>
<!--  Topic and Instructors  End-->

<!-- Course datatable -->
<div class="card">
  <div class="table-responsive mb-4">
    <table class="table datatables-players">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Temáticas Iniciadas</th>
                <th>Cartas Leídas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($players as $player)
                <tr>
                    <td>{{ $player->id }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->email }}</td>
                    <td>{{ $player->tematicas_count }}</td>
                    <td>{{ $player->read_cards_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</div>
<!-- Course datatable End -->
@endsection
