@extends('faturcms::template.admin.main')

@section('title', 'Data Fitur')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Fitur',
        'items' => [
            ['text' => 'Fitur', 'url' => route('admin.fitur.index')],
            ['text' => 'Data Fitur', 'url' => '#'],
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
                        <a href="{{ route('admin.fitur.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                    @if(count($fitur)>0)
                        <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                        <ul class="list-group sortable">
                            @foreach($fitur as $data)
                                <div class="list-group-item d-flex justify-content-between align-items-center sortable-item" data-id="{{ $data->id_fitur }}">
                                    <div>
                                        <div class="media">
                                            <a class="btn-magnify-popup" href="{{ image('assets/images/fitur/'.$data->gambar_fitur, 'fitur') }}" title="{{ $data->nama_fitur }}">
                                                <img src="{{ image('assets/images/fitur/'.$data->gambar_fitur, 'fitur') }}" width="75" class="align-self-center mr-3">
                                            </a>
                                            <div class="media-body">
                                                <h5 class="mt-0">{{ $data->nama_fitur }}</h5>
                                                <p class="mb-1">{{ $data->deskripsi_fitur }}</p>
                                                <p class="mb-1"><a href="{{ $data->url_fitur }}" target="_blank"><i class="fa fa-link mr-1"></i>{{ $data->url_fitur }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.fitur.edit', ['id' => $data->id_fitur]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_fitur }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.fitur.delete') }}">
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

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.fitur.sort')])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection