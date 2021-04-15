@extends('faturcms::template.member.main')

@section('title', 'Dashboard')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.member._breadcrumb', ['breadcrumb' => [
        'title' => 'Dashboard',
        'items' => [
            ['text' => 'Dashboard', 'url' => '#']
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Welcome Text -->
    <div class="alert alert-success text-center shadow">
        🔔 Selamat datang <span class="font-weight-bold">{{ Auth::user()->nama_user }}</span> di {{ setting('site.name') }}.
    </div>
    <!-- /Welcome Text -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12 mb-3">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body text-center">
                    <p class="h5 mb-4">Profil {{ setting('site.name') }}</p>
                    <p>{{ $deskripsi->deskripsi }}</p>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Fitur -->
                    <div class="row">
                        @if(count($fitur)>0)
                            @foreach($fitur as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <a href="{{ URL::to('member/'.$data->url_fitur) }}">
                                                <img src="{{ image('assets/images/fitur/'.$data->gambar_fitur, 'fitur') }}" height="100" style="max-width: 100%;">
                                            </a>
                                            <p class="h6 mt-3 mb-0"><a href="{{ URL::to('member/'.$data->url_fitur) }}">{{ $data->nama_fitur }}</a></p>
                                            <p class="mt-2 mb-0">{{ $data->deskripsi_fitur }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /Fitur -->
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection