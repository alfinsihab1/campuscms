@extends('faturcms::template.admin.main')

@section('title', 'Edit Halaman')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Halaman',
        'items' => [
            ['text' => 'Halaman', 'url' => route('admin.halaman.index')],
            ['text' => 'Edit Halaman', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.halaman.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $halaman->id_halaman }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul Halaman <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="judul_halaman" class="form-control {{ $errors->has('judul_halaman') ? 'is-invalid' : '' }}" value="{{ $halaman->halaman_title }}">
                                @if($errors->has('judul_halaman'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('judul_halaman')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="tipe" id="tipe-1" value="1" {{ $halaman->halaman_tipe == '1' ? 'checked' : '' }} {{ old('tipe') == null ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-1">{{ tipe_halaman(1) }} <em>(Tampilan berdasarkan Quill Editor)</em></label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="tipe" id="tipe-2" value="2" {{ $halaman->halaman_tipe == '2' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-2">{{ tipe_halaman(2) }} <em>(Tampilan dibuat dengan source code sendiri)</em></label>
                                </div>
                                @if($errors->has('tipe'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tipe')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row form-konten d-none" data-tipe="1">
                            <label class="col-md-2 col-form-label">Konten</label>
                            <div class="col-md-10">
                                <textarea name="konten" class="d-none"></textarea>
                                <div id="editor">{!! $halaman->halaman_tipe == 1 ? html_entity_decode($halaman->konten) : '' !!}</div> 
                                @if($errors->has('konten'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('konten')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row form-konten d-none" data-tipe="2">
                            <label class="col-md-2 col-form-label">Letak File View <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text {{ $errors->has('view') ? 'border-danger' : '' }}">{{ resource_path('views\page') }}/</span>
                                    </div>
                                    <input type="text" name="view" class="form-control {{ $errors->has('view') ? 'is-invalid' : '' }}" value="{{ $halaman->halaman_tipe == 2 ? $halaman->konten : '' }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text {{ $errors->has('view') ? 'border-danger' : '' }}">.blade.php</span>
                                    </div>
                                </div>
                                @if($errors->has('view'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('view')) }}</div>
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

@section('js-extra')

@include('faturcms::template.admin._js-editor')

<script type="text/javascript">
    // Load Page
    $(window).on("load", function(){
        var tipe = $("input[name=tipe]:checked").val();
        $(".form-konten[data-tipe="+tipe+"]").removeClass("d-none");
    });

    // Quill
    generate_quill("#editor");

    // Change Tipe
    $(document).on("change", "input[name=tipe]", function(){
        var tipe = $(this).val();
        $(".form-konten").addClass("d-none");
        $(".form-konten[data-tipe="+tipe+"]").removeClass("d-none");
    });

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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">

@endsection