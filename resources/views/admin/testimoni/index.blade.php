@extends('faturcms::template.admin.main')

@section('title', 'Data Testimoni')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Testimoni',
        'items' => [
            ['text' => 'Testimoni', 'url' => route('admin.testimoni.index')],
            ['text' => 'Data Testimoni', 'url' => '#'],
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
                        <a href="{{ route('admin.testimoni.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                    @if(count($testimoni)>0)
                        <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                        <ul class="list-group sortable">
                            @foreach($testimoni as $data)
                                <div class="list-group-item d-flex justify-content-between align-items-center sortable-item" data-id="{{ $data->id_testimoni }}">
                                    <div>
                                        <div class="media">
                                            <a class="btn-magnify-popup" href="{{ image('assets/images/testimoni/'.$data->foto_klien, 'testimoni') }}" title="{{ $data->nama_klien }}">
                                                <img src="{{ image('assets/images/testimoni/'.$data->foto_klien, 'testimoni') }}" width="75" class="align-self-center mr-3">
                                            </a>
                                            <div class="media-body">
                                                <blockquote class="blockquote">
                                                    <p class="mb-0">{{ $data->testimoni }}</p>
                                                    <footer class="blockquote-footer"><cite title="Source Title">{{ $data->nama_klien }} {{ $data->profesi_klien != '' ? '('.$data->profesi_klien.')' : '' }}</cite></footer>
                                                </blockquote>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.testimoni.edit', ['id' => $data->id_testimoni]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_testimoni }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.testimoni.delete') }}">
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

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.testimoni.sort')])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection