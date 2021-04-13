@extends('faturcms::template.admin.main')

@section('title', 'Tambah Psikolog')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Psikolog',
        'items' => [
            ['text' => 'Psikolog', 'url' => route('admin.psikolog.index')],
            ['text' => 'Tambah Psikolog', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.psikolog.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_psikolog" class="form-control {{ $errors->has('nama_psikolog') ? 'is-invalid' : '' }}" value="{{ old('nama_psikolog') }}">
                                @if($errors->has('nama_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_psikolog')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="kategori_psikolog" class="form-control {{ $errors->has('kategori_psikolog') ? 'is-invalid' : '' }}" >
                                    <option value="" disabled selected>--Pilih--</option>
                                    <option value="1" {{ old('kategori_psikolog') == '1' ? 'selected' : '' }}>{{ psikolog(1) }}</option>
                                    <option value="2" {{ old('kategori_psikolog') == '2' ? 'selected' : '' }}>{{ psikolog(2) }}</option>
                                </select>
                                @if($errors->has('kategori_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori_psikolog')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kode <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="kode_psikolog" class="form-control {{ $errors->has('kode_psikolog') ? 'is-invalid' : '' }}" value="{{ old('kode_psikolog') }}">
                                @if($errors->has('kode_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kode_psikolog')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="alamat_psikolog" class="form-control {{ $errors->has('alamat_psikolog') ? 'is-invalid' : '' }}" rows="3">{{ old('alamat_psikolog') }}</textarea>
                                @if($errors->has('alamat_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('alamat_psikolog')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">No. Telp / WhatsApp <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nomor_telepon_psikolog" class="form-control {{ $errors->has('nomor_telepon_psikolog') ? 'is-invalid' : '' }}" value="{{ old('nomor_telepon_psikolog') }}">
                                @if($errors->has('nomor_telepon_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nomor_telepon_psikolog')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Akun Instagram</label>
                            <div class="col-md-10">
                                <input type="text" name="instagram_psikolog" class="form-control {{ $errors->has('instagram_psikolog') ? 'is-invalid' : '' }}" value="{{ old('instagram_psikolog') }}">
                                @if($errors->has('instagram_psikolog'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('instagram_psikolog')) }}</div>
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