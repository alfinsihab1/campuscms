@extends('faturcms::template.admin.main')

@section('title', 'Tambah Hak Akses')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Hak Akses',
        'items' => [
            ['text' => 'Hak Akses', 'url' => route('admin.rolepermission.index')],
            ['text' => 'Tambah Hak Akses', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.permission.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Key Permission <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="key_permission" class="form-control {{ $errors->has('key_permission') ? 'is-invalid' : '' }}" value="{{ old('key_permission') }}">
                                @if($errors->has('key_permission'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('key_permission')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Permission <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_permission" class="form-control {{ $errors->has('nama_permission') ? 'is-invalid' : '' }}" value="{{ old('nama_permission') }}">
                                @if($errors->has('nama_permission'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_permission')) }}</div>
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

@endsection