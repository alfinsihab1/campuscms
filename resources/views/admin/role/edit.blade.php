@extends('faturcms::template.admin.main')

@section('title', 'Edit Role')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Role',
        'items' => [
            ['text' => 'Role', 'url' => route('admin.role.index')],
            ['text' => 'Edit Role', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.role.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $role->id_role }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Key Role <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_role" class="form-control" value="{{ $role->key_role }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Role <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_role" class="form-control {{ $errors->has('nama_role') ? 'is-invalid' : '' }}" value="{{ $role->nama_role }}">
                                @if($errors->has('nama_role'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_role')) }}</div>
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