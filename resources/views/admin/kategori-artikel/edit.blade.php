@extends('faturcms::template.admin.main')

@section('title', 'Edit Kategori Artikel')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Kategori Artikel',
        'items' => [
            ['text' => 'Artikel', 'url' => route('admin.blog.index')],
            ['text' => 'Kategori', 'url' => route('admin.blog.kategori.index')],
            ['text' => 'Edit Kategori Artikel', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.blog.kategori.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $kategori->id_ka }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" value="{{ $kategori->kategori }}">
                                @if($errors->has('kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori')) }}</div>
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