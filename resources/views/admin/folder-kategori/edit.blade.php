@extends('faturcms::template.admin.main')

@section('title', 'Edit Kategori Folder')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Kategori Folder',
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => 'Kategori Folder', 'url' => route('admin.folder.kategori.index')],
            ['text' => 'Edit Kategori Folder', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.folder.kategori.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $kategori->id_fk }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" value="{{ $kategori->folder_kategori }}">
                                @if($errors->has('kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="tipe" class="form-control {{ $errors->has('tipe') ? 'is-invalid' : '' }}">
                                    <option value="" disabled selected>--Pilih--</option>
                                    <option value="ebook" {{ $kategori->tipe_kategori == 'ebook' ? 'selected' : '' }}>Ebook</option>
                                    <option value="video" {{ $kategori->tipe_kategori == 'video' ? 'selected' : '' }}>Video</option>
                                    <option value="script" {{ $kategori->tipe_kategori == 'script' ? 'selected' : '' }}>Script</option>
                                    <option value="tools" {{ $kategori->tipe_kategori == 'tools' ? 'selected' : '' }}>Tools</option>
                                </select>
                                @if($errors->has('tipe'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tipe')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Status <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="status" id="status-1" value="1" {{ $kategori->status_kategori == '1' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="status-1">{{ status(1) }}</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="status" id="status-0" value="0" {{ $kategori->status_kategori == '0' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="status-0">{{ status(0) }}</label>
                                </div>
                                @if($errors->has('status'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('status')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Prefix</label>
                            <div class="col-md-10">
                                <input type="text" name="prefix_kategori" class="form-control {{ $errors->has('prefix_kategori') ? 'is-invalid' : '' }}" value="{{ $kategori->prefix_kategori }}">
                                @if($errors->has('prefix_kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('prefix_kategori')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Icon</label>
                            <div class="col-md-10">
                                <input type="text" name="icon_kategori" class="form-control {{ $errors->has('icon_kategori') ? 'is-invalid' : '' }}" value="{{ $kategori->icon_kategori }}">
                                <div class="small text-muted mt-1">Masukkan nama class icon dari Font Awesome 4.7.0. Contoh: fa-users</div>
                                @if($errors->has('icon_kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('icon_kategori')) }}</div>
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