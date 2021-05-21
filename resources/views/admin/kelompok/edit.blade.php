@extends('faturcms::template.admin.main')

@section('title', 'Edit Kelompok')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Kelompok',
        'items' => [
            ['text' => 'User', 'url' => route('admin.user.index')],
            ['text' => 'Kelompok', 'url' => route('admin.user.kelompok.index')],
            ['text' => 'Edit Kelompok', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.user.kelompok.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $kelompok->id_kelompok }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Kelompok <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_kelompok" class="form-control {{ $errors->has('nama_kelompok') ? 'is-invalid' : '' }}" value="{{ $kelompok->nama_kelompok }}">
                                @if($errors->has('nama_kelompok'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_kelompok')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Anggota <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="anggota_kelompok[]" class="form-control select-anggota {{ $errors->has('anggota_kelompok') ? 'is-invalid' : '' }}" multiple="">
                                    @foreach($user as $data)
                                    <option value="{{ $data->id_user }}" {{ in_array($data->id_user, $ids) ? 'selected' : '' }}>{{ $data->nama_user }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('anggota_kelompok'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('anggota_kelompok')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan</button>
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

@section('js-extra')

<script type="text/javascript" src="{{ asset('templates/vali-admin/js/plugins/select2.min.js') }}"></script>

<script type="text/javascript">
    // Select2
    $(document).ready(function() {
        $(".select-anggota").select2();
    });
</script>

@endsection