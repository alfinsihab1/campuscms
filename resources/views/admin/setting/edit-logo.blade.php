@extends('faturcms::template.admin.main')

@section('title', 'Pengaturan '.$kategori->kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pengaturan '.$kategori->kategori,
        'items' => [
            ['text' => 'Pengaturan', 'url' => route('admin.setting.index')],
            ['text' => $kategori->kategori, 'url' => '#'],
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
                    @if(Session::get('message') != null)
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
                    </div>
                    @endif
                    <form id="form" method="post" action="{{ route('admin.setting.update', ['category' => $kategori->slug]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @foreach($setting as $data)
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                {{ $data->setting_name }}
                                <span class="text-danger">{{ is_int(strpos($data->setting_rules, 'required')) ? '*' : '' }}</span>
                                <br>
                                <span class="small text-muted">{{ $data->setting_key }}</span>
                            </label>
                            <div class="col-md-10">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" id="img-file" class="mt-2 img-thumbnail" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                                @if($errors->has('gambar'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('gambar')) }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 300, 'croppieHeight' => 300, 'noCroppie' => true])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'logo', 'croppieWidth' => 300, 'croppieHeight' => 300, 'noCroppie' => true])

@endsection