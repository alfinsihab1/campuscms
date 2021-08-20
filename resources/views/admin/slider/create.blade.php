@extends('faturcms::template.admin.main')

@section('title', 'Tambah Slider')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Slider',
        'items' => [
            ['text' => 'Slider', 'url' => route('admin.slider.index')],
            ['text' => 'Tambah Slider', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.slider.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">URL</label>
                            <div class="col-md-10">
                                <input type="text" name="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}" value="{{ old('url') }}">
                                @if($errors->has('url'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('url')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Status Slider <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="status_slider" id="status-1" value="1" {{ old('status_slider') == '1' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="status-1">Tampilkan</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="status_slider" id="status-0" value="0" {{ old('status_slider') == '0' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="status-0">Sembunyikan</label>
                                </div>
                                @if($errors->has('status_slider'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('status_slider')) }}</div>
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 1700, 'croppieHeight' => 500])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'slider', 'croppieWidth' => 1700, 'croppieHeight' => 500])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection