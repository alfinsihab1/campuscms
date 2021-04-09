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
                    <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                    <ul class="list-group sortable">
                        @if(count($slider)>0)
                            @foreach($slider as $data)
                                <div class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $data->id_slider }}">
                                    <div>
                                        <a class="btn-magnify-popup" href="{{ image('assets/images/slider/'.$data->slider, 'slider') }}">
                                            <img src="{{ image('assets/images/slider/'.$data->slider, 'slider') }}" width="250" class="img-thumbnail">
                                        </a>
                                        <p class="mb-1"><a href="{{ $data->slider_url }}" target="_blank"><i class="fa fa-link mr-1"></i>{{ $data->slider_url }}</a></p>
                                        <p class="mb-1"><span class="badge badge-{{ $data->status_slider == 1 ? 'success' : 'danger' }}">{{ $data->status_slider == 1 ? 'Tampilkan' : 'Sembunyikan' }}</span></p>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.slider.edit', ['id' => $data->id_slider]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_slider }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </ul>
                    <form id="form-delete" class="d-none" method="post" action="{{ route('admin.slider.delete') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id">
                    </form>
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