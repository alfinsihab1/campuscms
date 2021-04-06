@extends('faturcms::template.admin.main')

@section('title', 'Tambah Rekening')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Rekening',
        'items' => [
            ['text' => 'Rekening', 'url' => route('admin.rekening.index')],
            ['text' => 'Tambah Rekening', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.rekening.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">User <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="user" class="form-control {{ $errors->has('user') ? 'is-invalid' : '' }}">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($user as $data)
                                    <option value="{{ $data->id_user }}" {{ old('user') == $data->id_user ? 'selected' : '' }}>{{ $data->nama_user }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('user')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Platform <span class="text-danger">*</span></label>
                            <div class="col-md-10">
								<select name="platform" class="form-control {{ $errors->has('platform') ? 'is-invalid' : '' }}">
									<option value="" disabled selected>--Pilih--</option>
									<optgroup label="Bank">
										@foreach($bank as $data)
										<option value="{{ $data->id_platform }}" {{ old('platform') == $data->id_platform ? 'selected' : '' }}>{{ $data->nama_platform }}</option>
										@endforeach
									</optgroup>
									<optgroup label="Fintech">
										@foreach($fintech as $data)
										<option value="{{ $data->id_platform }}" {{ old('platform') == $data->id_platform ? 'selected' : '' }}>{{ $data->nama_platform }}</option>
										@endforeach
									</optgroup>
								</select>
                                @if($errors->has('platform'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('platform')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nomor <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : '' }} number-only" value="{{ old('nomor') }}">
                                @if($errors->has('nomor'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nomor')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Atas Nama <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="atas_nama" class="form-control {{ $errors->has('atas_nama') ? 'is-invalid' : '' }}" value="{{ old('atas_nama') }}">
                                @if($errors->has('atas_nama'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('atas_nama')) }}</div>
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