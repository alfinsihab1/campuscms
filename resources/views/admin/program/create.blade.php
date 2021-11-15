@extends('faturcms::template.admin.main')

@section('title', 'Tambah Program')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Program',
        'items' => [
            ['text' => 'Program', 'url' => route('admin.program.index')],
            ['text' => 'Tambah Program', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.program.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul Program <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="judul_program" class="form-control {{ $errors->has('judul_program') ? 'is-invalid' : '' }}" value="{{ old('judul_program') }}">
                                @if($errors->has('judul_program'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('judul_program')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}" >
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($kategori as $data)
                                    <option value="{{ $data->id_kp }}" {{ old('kategori') === $data->id_kp ? 'selected' : '' }}>{{ $data->kategori }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img id="img-file" class="mt-2 img-thumbnail d-none" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Konten</label>
                            <div class="col-md-10">
                                <textarea name="konten" class="d-none"></textarea>
                                <div id="editor"></div> 
                                @if($errors->has('konten'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('konten')) }}</div>
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

@include('faturcms::template.admin._modal-image', ['noCroppie' => true, 'croppieWidth' => 640, 'croppieHeight' => 360])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'program', 'noCroppie' => true, 'croppieWidth' => 640, 'croppieHeight' => 360])

@include('faturcms::template.admin._js-editor')

<script type="text/javascript">
    // Quill
    generate_quill("#editor");

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("textarea[name=konten]").text(html);
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">

@endsection