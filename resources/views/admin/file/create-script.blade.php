@extends('faturcms::template.admin.main')

@section('title', 'Tambah File')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah File',
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->prefix_kategori.' '.$kategori->icon_kategori, 'url' => route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori])],
            ['text' => 'Tambah File', 'url' => '#'],
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
                    <!-- Breadcrumb Direktori -->
                    <ol class="breadcrumb bg-white p-0 mb-0">
                        @foreach(file_breadcrumb($directory) as $key=>$data)
                            @if($key + 1 == count(file_breadcrumb($directory)))
                            <li class="breadcrumb-item active" aria-current="page">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <form id="form" method="post" action="{{ route('admin.file.store', ['kategori' => $kategori->slug_kategori]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="file_kategori" value="{{ $kategori->id_fk }}">
                        <input type="hidden" name="id_folder" value="{{ $directory->id_folder }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul Script <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_file" class="form-control {{ $errors->has('nama_file') ? 'is-invalid' : '' }}" value="{{ old('nama_file') }}">
                                @if($errors->has('nama_file'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_file')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
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
                            <label class="col-md-2 col-form-label">Konten Script</label>
                            <div class="col-md-10">
                                <textarea name="file_konten" class="form-control {{ $errors->has('file_konten') ? 'is-invalid' : '' }}" rows="10">{{ old('file_konten') }}</textarea>
                                @if($errors->has('file_konten'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('file_konten')) }}</div>
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 848, 'croppieHeight' => 480])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'file', 'croppieWidth' => 848, 'croppieHeight' => 480])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection