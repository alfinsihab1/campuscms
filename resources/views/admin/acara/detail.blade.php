@extends('faturcms::template.admin.main')

@section('title', 'Detail Acara')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Acara',
        'items' => [
            ['text' => 'Acara', 'url' => route('admin.acara.index')],
            ['text' => 'Detail Acara', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="text-center">
                        <img src="{{ image('assets/images/acara/'.$acara->gambar_acara, 'acara') }}" class="img-fluid">
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-9">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Nama Acara:</div>
                            <div>{{ $acara->nama_acara }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Kategori:</div>
                            <div>{{ $acara->kategori }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Tempat:</div>
                            <div>{{ $acara->tempat_acara != '' ? $acara->tempat_acara : '-' }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Waktu:</div>
                            <div>{{ generate_date_range('join', $acara->tanggal_acara_from.' - '.$acara->tanggal_acara_to)['from'] }} s.d. {{ generate_date_range('join', $acara->tanggal_acara_from.' - '.$acara->tanggal_acara_to)['to'] }}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong>Deskripsi:</strong>
                        <div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($acara->deskripsi_acara) !!}</div></div>
                    </div>
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

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

@endsection