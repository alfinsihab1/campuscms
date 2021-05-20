@extends('faturcms::template.admin.main')

@section('title', 'Tambah Pop-Up')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tambah Pop-Up',
        'items' => [
            ['text' => 'Pop-Up', 'url' => route('admin.pop-up.index')],
            ['text' => 'Tambah Pop-Up', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.pop-up.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="popup_judul" class="form-control {{ $errors->has('popup_judul') ? 'is-invalid' : '' }}" value="{{ old('popup_judul') }}">
                                @if($errors->has('popup_judul'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_judul')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="popup_tipe" id="tipe-1" value="1" {{ old('popup_tipe') == 1 || old('popup_tipe') == null ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-1">Gambar</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="popup_tipe" id="tipe-2" value="2" {{ old('popup_tipe') == 2 ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-2">Video</label>
                                </div>
                                @if($errors->has('popup_tipe'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_tipe')) }}</div>
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
                            <label class="col-md-2 col-form-label">Waktu Aktif Pop-Up <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="popup_waktu" class="form-control {{ $errors->has('popup_waktu') ? 'is-invalid' : '' }}" value="{{ old('popup_waktu') }}">
                                @if($errors->has('popup_waktu'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_waktu')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="d-none"></textarea>
                                <div id="editor"></div> 
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 640, 'croppieHeight' => 360])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'pelatihan', 'croppieWidth' => 640, 'croppieHeight' => 360])

@include('faturcms::template.admin._js-editor')

<script type="text/javascript" src="{{ asset('assets/plugins/moment.js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Quill
        generate_quill("#editor");

        // Daterangepicker
        $("input[name=popup_waktu]").daterangepicker({
            showDropdowns: true,
            autoApply: true,
            startDate: "{{ date('d/m/Y') }}",
            endDate: "{{ date('d/m/Y') }}",
            locale: {
              format: 'DD/MM/YYYY'
            }
        });
    });
    
    // Button Tambah Materi
    $(document).on("click", ".btn-add-materi", function(e){
        e.preventDefault();
        var count = $(".konten-materi .form-row").length;
        var html = '';
        html += '<div class="form-row" data-id="'+(count+1)+'">';
        html += '<div class="form-group col-4">';
        html += '<input type="text" name="kode_unit[]" class="form-control kode-unit" data-id="'+(count+1)+'" placeholder="Kode Unit">';
        html += '</div>';
        html += '<div class="form-group col-4">';
        html += '<input type="text" name="judul_unit[]" class="form-control judul-unit" data-id="'+(count+1)+'" placeholder="Judul Unit">';
        html += '</div>';
        html += '<div class="form-group col-3">';
        html += '<input type="text" name="durasi[]" class="form-control number-only durasi" data-id="'+(count+1)+'" placeholder="Durasi (Jam)">';
        html += '</div>';
        html += '<div class="form-group col-1">';
        html += '<a href="#" class="btn btn-danger btn-block" data-id="'+(count+1)+'" title="Hapus"><i class="fa fa-trash"></i></a>';
        html += '</div>';
        html += '</div>';
        $(".konten-materi").append(html);
        var rows = $(".konten-materi .form-row");
        rows.each(function(key,elem){
            $(elem).find(".btn-danger").removeClass("btn-disabled").addClass("btn-delete-materi");     
            $(elem).attr("data-id", (key+1));
            $(elem).find(".kode-unit").attr("data-id", (key+1));
            $(elem).find(".judul-unit").attr("data-id", (key+1));
            $(elem).find(".durasi").attr("data-id", (key+1));
            $(elem).find(".btn-delete-materi").attr("data-id", (key+1));
        });
    });
    
    // Button Hapus Materi
    $(document).on("click", ".btn-delete-materi", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $(".konten-materi .form-row[data-id="+id+"]").remove();
        var rows = $(".konten-materi .form-row");
        rows.each(function(key,elem){
            rows.length <= 1 ? $(elem).find(".btn-danger").addClass("btn-disabled").removeClass("btn-delete-materi") : $(elem).find(".btn-danger").removeClass("btn-disabled").addClass("btn-delete-materi");      
            $(elem).attr("data-id", (key+1));
            $(elem).find(".kode-unit").attr("data-id", (key+1));
            $(elem).find(".judul-unit").attr("data-id", (key+1));
            $(elem).find(".durasi").attr("data-id", (key+1));
            $(elem).find(".btn-delete-materi").attr("data-id", (key+1));
        });
    });
    
    
    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        e.preventDefault();
        
        // Cek Materi
        var rows = $(".konten-materi .form-row");
        if(rows.length == 1){
            if($(rows).find(".kode-unit").val() == '' || $(rows).find(".judul-unit").val() == '' || $(rows).find(".durasi").val() == '' ){
                alert("Materi harus diisi minimal 1 (satu) !");
                return;
            }
        }
        
        // Get Konten di Quill Editor
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("textarea[name=deskripsi]").text(html);

        // Submit
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.css') }}">

@endsection