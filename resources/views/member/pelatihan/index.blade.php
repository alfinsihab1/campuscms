@extends('faturcms::template.admin.main')

@section('title', 'Pelatihan Tersedia')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pelatihan Tersedia',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('member.pelatihan.index')],
            ['text' => 'Pelatihan Tersedia', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Pelatihan -->
                    <div class="row">
                        @if(count($pelatihan)>0)
                            @foreach($pelatihan as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card">
                                        <a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">
                                            <img class="card-img-top" src="{{ image('assets/images/pelatihan/'.$data->gambar_pelatihan, 'pelatihan') }}">
                                        </a>
                                        <div class="card-body p-2">
                                            <p class="card-title my-0"><a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}" data-toggle="tooltip" title="{{ $data->nama_pelatihan }}">{{ $data->nama_pelatihan }}</a></p>
                                            <p class="mt-2 mb-0 text-truncate">
                                                Oleh: <a href="{{ route('member.user.trainer', ['id' => $data->trainer ]) }}" data-toggle="tooltip" title="{{ $data->nama_user }}">{{ $data->nama_user }}</a>
                                            </p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between small p-2">
                                            <span><i class="fa fa-calendar mr-1"></i>{{ date('d/m/Y', strtotime($data->tanggal_pelatihan_from)) }}</span>
                                            <span><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->tanggal_pelatihan_from)) }} WIB</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="col-12">
                            <div class="alert alert-danger text-center mb-0">Tidak ada pelatihan tersedia.</div>
                        </div>
                        @endif
                    </div>
                    <!-- /Pelatihan -->
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

@section('css-extra')

<style type="text/css">
	.card-title {font-weight: bold; height: 42px; display: -webkit-box !important; -webkit-line-clamp: 2; -moz-line-clamp: 2; -ms-line-clamp: 2; -o-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
</style>

@endsection