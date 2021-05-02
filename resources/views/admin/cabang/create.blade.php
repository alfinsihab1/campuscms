@extends('faturcms::template.admin.main')

@section('title', 'Tambah Cabang')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Cabang',
        'items' => [
            ['text' => 'Cabang', 'url' => route('admin.cabang.index')],
            ['text' => 'Tambah Cabang', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.cabang.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_cabang" class="form-control {{ $errors->has('nama_cabang') ? 'is-invalid' : '' }}" value="{{ old('nama_cabang') }}">
                                @if($errors->has('nama_cabang'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_cabang')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="alamat_cabang" class="form-control {{ $errors->has('alamat_cabang') ? 'is-invalid' : '' }}" rows="3">{{ old('alamat_cabang') }}</textarea>
                                @if($errors->has('alamat_cabang'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('alamat_cabang')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">No. Telp / WhatsApp <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nomor_telepon_cabang" class="form-control {{ $errors->has('nomor_telepon_cabang') ? 'is-invalid' : '' }}" value="{{ old('nomor_telepon_cabang') }}">
                                @if($errors->has('nomor_telepon_cabang'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nomor_telepon_cabang')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Akun Instagram</label>
                            <div class="col-md-10">
                                <input type="text" name="instagram_cabang" class="form-control {{ $errors->has('instagram_cabang') ? 'is-invalid' : '' }}" value="{{ old('instagram_cabang') }}">
                                @if($errors->has('instagram_cabang'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('instagram_cabang')) }}</div>
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