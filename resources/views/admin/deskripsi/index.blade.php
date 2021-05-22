@extends('faturcms::template.admin.main')

@section('title', 'Deskripsi')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Deskripsi',
        'items' => [
            ['text' => 'Deskripsi', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.deskripsi.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul Deskripsi <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="judul_deskripsi" class="form-control {{ $errors->has('judul_deskripsi') ? 'is-invalid' : '' }}" value="{{ $deskripsi ? $deskripsi->judul_deskripsi : '' }}">
                                @if($errors->has('judul_deskripsi'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('judul_deskripsi')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="form-control" rows="10">{{ $deskripsi ? $deskripsi->deskripsi : '' }}</textarea>
                                @if($errors->has('deskripsi'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('deskripsi')) }}</div>
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