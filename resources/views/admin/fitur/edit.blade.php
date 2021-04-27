@extends('faturcms::template.admin.main')

@section('title', 'Edit Fitur')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Fitur',
        'items' => [
            ['text' => 'Fitur', 'url' => route('admin.fitur.index')],
            ['text' => 'Edit Fitur', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.fitur.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $fitur->id_fitur }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Fitur <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_fitur" class="form-control {{ $errors->has('nama_fitur') ? 'is-invalid' : '' }}" value="{{ $fitur->nama_fitur }}">
                                @if($errors->has('nama_fitur'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_fitur')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="deskripsi_fitur" class="form-control {{ $errors->has('deskripsi_fitur') ? 'is-invalid' : '' }}">{{ $fitur->deskripsi_fitur }}</textarea>
                                @if($errors->has('deskripsi_fitur'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('deskripsi_fitur')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">URL</label>
                            <div class="col-md-10">
                                <input type="text" name="url_fitur" class="form-control {{ $errors->has('url_fitur') ? 'is-invalid' : '' }}" value="{{ $fitur->url_fitur }}">
                                @if($errors->has('url_fitur'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('url_fitur')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ image('assets/images/fitur/'.$fitur->gambar_fitur, 'fitur') }}" id="img-file" class="mt-2 img-thumbnail {{ $fitur->gambar_fitur != '' ? '' : 'd-none' }}" style="max-height: 150px">
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

@include('faturcms::template.admin._js-image', ['imageType' => 'fitur', 'croppieWidth' => 400, 'croppieHeight' => 400])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection