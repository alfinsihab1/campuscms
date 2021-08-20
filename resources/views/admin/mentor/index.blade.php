@extends('faturcms::template.admin.main')

@section('title', 'Data Mentor')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Mentor',
        'items' => [
            ['text' => 'Mentor', 'url' => route('admin.mentor.index')],
            ['text' => 'Data Mentor', 'url' => '#'],
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
                        <a href="{{ route('admin.mentor.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                    @if(count($mentor)>0)
                        <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                        <div class="row sortable">
                            @foreach($mentor as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card sortable-item" data-id="{{ $data->id_mentor }}">
                                        <div class="card-body text-center">
                                            <a class="btn-magnify-popup" href="{{ image('assets/images/mentor/'.$data->foto_mentor, 'mentor') }}" title="{{ $data->nama_mentor }}">
                                                <img src="{{ image('assets/images/mentor/'.$data->foto_mentor, 'mentor') }}" height="150" class="rounded-circle" style="max-width: 100%;">
                                            </a>
                                            <p class="h5 mt-2 mb-1">{{ $data->nama_mentor }}</p>
                                            <p class="mb-0">{{ $data->profesi_mentor }}</p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <a href="{{ route('admin.mentor.edit', ['id' => $data->id_mentor]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_mentor }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.mentor.delete') }}">
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

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.mentor.sort')])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection