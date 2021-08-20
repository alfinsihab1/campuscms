@extends('faturcms::template.admin.main')

@section('title', 'Edit Mitra')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Mitra',
        'items' => [
            ['text' => 'Mitra', 'url' => route('admin.mitra.index')],
            ['text' => 'Edit Mitra', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.mitra.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $mitra->id_mitra }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Mitra <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_mitra" class="form-control {{ $errors->has('nama_mitra') ? 'is-invalid' : '' }}" value="{{ $mitra->nama_mitra }}">
                                @if($errors->has('nama_mitra'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_mitra')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ image('assets/images/mitra/'.$mitra->logo_mitra, 'mitra') }}" id="img-file" class="mt-2 img-thumbnail {{ $mitra->logo_mitra != '' ? '' : 'd-none' }}" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Simpan</button>
                            </div>
                        </div>
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 400, 'croppieHeight' => 400])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'mitra', 'croppieWidth' => 400, 'croppieHeight' => 400])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection