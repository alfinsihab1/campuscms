@extends('faturcms::template.admin.main')

@section('title', 'Tambah Kontributor')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Kontributor',
        'items' => [
            ['text' => 'Artikel', 'url' => route('admin.blog.index')],
            ['text' => 'Kontributor', 'url' => route('admin.blog.kontributor.index')],
            ['text' => 'Tambah Kontributor', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.blog.kontributor.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kontributor <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="kontributor" class="form-control {{ $errors->has('kontributor') ? 'is-invalid' : '' }}" value="{{ old('kontributor') }}">
                                @if($errors->has('kontributor'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kontributor')) }}</div>
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