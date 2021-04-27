@extends('faturcms::template.admin.main')

@section('title', 'Edit Testimoni')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Testimoni',
        'items' => [
            ['text' => 'Testimoni', 'url' => route('admin.testimoni.index')],
            ['text' => 'Edit Testimoni', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.testimoni.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $testimoni->id_testimoni }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Klien <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_klien" class="form-control {{ $errors->has('nama_klien') ? 'is-invalid' : '' }}" value="{{ $testimoni->nama_klien }}">
                                @if($errors->has('nama_klien'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_klien')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Profesi</label>
                            <div class="col-md-10">
                                <input type="text" name="profesi_klien" class="form-control {{ $errors->has('profesi_klien') ? 'is-invalid' : '' }}" value="{{ $testimoni->profesi_klien }}">
                                @if($errors->has('profesi_klien'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('profesi_klien')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Foto Klien</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ image('assets/images/testimoni/'.$testimoni->foto_klien, 'testimoni') }}" id="img-file" class="mt-2 img-thumbnail {{ $testimoni->foto_klien != '' ? '' : 'd-none' }}" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Testimoni <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="testimoni" class="form-control {{ $errors->has('testimoni') ? 'is-invalid' : '' }}">{{ $testimoni->testimoni }}</textarea>
                                @if($errors->has('testimoni'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('testimoni')) }}</div>
                                @endif
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

@include('faturcms::template.admin._js-image', ['imageType' => 'testimoni', 'croppieWidth' => 400, 'croppieHeight' => 400])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection