@extends('faturcms::template.admin.main')

@section('title', 'Tambah Platform')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Platform',
        'items' => [
            ['text' => 'Platform', 'url' => route('admin.platform.index')],
            ['text' => 'Tambah Platform', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.platform.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Platform <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_platform" class="form-control {{ $errors->has('nama_platform') ? 'is-invalid' : '' }}" value="{{ old('nama_platform') }}">
                                @if($errors->has('nama_platform'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_platform')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="tipe_platform" id="tipe-1" value="1" {{ old('tipe_platform') == '1' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-1">Bank</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="tipe_platform" id="tipe-2" value="2" {{ old('tipe_platform') == '2' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-2">Fintech</label>
                                </div>
                                @if($errors->has('tipe_platform'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tipe_platform')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kode Transfer</label>
                            <div class="col-md-10">
                                <input type="text" name="kode_platform" class="form-control {{ $errors->has('kode_platform') ? 'is-invalid' : '' }}" value="{{ old('kode_platform') }}">
                                @if($errors->has('kode_platform'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kode_platform')) }}</div>
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