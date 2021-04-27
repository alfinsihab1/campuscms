@extends('faturcms::template.admin.main')

@section('title', 'Data Slider')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Slider',
        'items' => [
            ['text' => 'Slider', 'url' => route('admin.slider.index')],
            ['text' => 'Data Slider', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <div class="btn-group">
                        <a href="{{ route('admin.slider.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(count($slider)>0)
                        <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                        <div class="row sortable">
                            @foreach($slider as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card sortable-item" data-id="{{ $data->id_slider }}">
                                        <a class="btn-magnify-popup" href="{{ image('assets/images/slider/'.$data->slider, 'slider') }}">
                                            <img class="card-img-top" src="{{ image('assets/images/slider/'.$data->slider, 'slider') }}" height="100" style="max-width: 100%;">
                                        </a>
                                        <div class="card-body text-center">
                                            <p class="mb-1"><a href="{{ $data->slider_url }}" target="_blank"><i class="fa fa-link mr-1"></i>{{ $data->slider_url }}</a></p>
                                            <p class="mb-0"><span class="badge badge-{{ $data->status_slider == 1 ? 'success' : 'danger' }}">{{ $data->status_slider == 1 ? 'Tampilkan' : 'Sembunyikan' }}</span></p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a href="{{ route('admin.slider.edit', ['id' => $data->id_slider]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_slider }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.slider.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
                    @else
                        <div class="alert alert-danger text-center">Tidak ada data tersedia.</div>
                    @endif
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

@section('js-extra')

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.slider.sort')])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection