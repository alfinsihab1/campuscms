@extends('faturcms::template.admin.main')

@section('title', 'Edit Pop-Up')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Pop-Up',
        'items' => [
            ['text' => 'Pop-Up', 'url' => route('admin.pop-up.index')],
            ['text' => 'Edit Pop-Up', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.pop-up.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $popup->id_popup }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Judul <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="popup_judul" class="form-control {{ $errors->has('popup_judul') ? 'is-invalid' : '' }}" value="{{ $popup->popup_judul }}">
                                @if($errors->has('popup_judul'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_judul')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tipe <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="popup_tipe" id="tipe-1" value="1" {{ $popup->popup_tipe == 1 ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-1">Gambar</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="popup_tipe" id="tipe-2" value="2" {{ $popup->popup_tipe == 2 ? 'checked' : '' }}>
                                  <label class="form-check-label" for="tipe-2">Video</label>
                                </div>
                                @if($errors->has('popup_tipe'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_tipe')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $popup->popup_tipe == 1 ? '' : 'd-none' }}" id="input-tipe-1">
                            <label class="col-md-2 col-form-label">Gambar <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-browse-file" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img id="img-file" class="mt-2 img-thumbnail {{ $popup->popup_tipe == 1 ? '' : 'd-none' }}" src="{{ $popup->popup_tipe == 1 ? asset('assets/images/pop-up/'.$popup->popup) : '' }}" style="max-height: 150px">
                                @if($errors->has('foto'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('foto')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $popup->popup_tipe == 2 ? '' : 'd-none' }}" id="input-tipe-2">
                            <label class="col-md-2 col-form-label">Video <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="popup" class="form-control {{ $errors->has('popup') ? 'is-invalid' : '' }}" value="{{ old('popup') }}">
                                <div class="small text-muted mt-1">Hanya bisa memasukkan URL video YouTube.</div>
                                @if($errors->has('popup'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Waktu Aktif Pop-Up <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="popup_waktu" class="form-control {{ $errors->has('popup_waktu') ? 'is-invalid' : '' }}">
                                @if($errors->has('popup_waktu'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('popup_waktu')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="d-none"></textarea>
                                <div id="editor">{!! html_entity_decode($popup->popup_konten) !!}</div> 
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

@section('js-extra')

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
            startDate: "{{ date('d/m/Y', strtotime($popup->popup_from)) }}",
            endDate: "{{ date('d/m/Y', strtotime($popup->popup_to)) }}",
            locale: {
              format: 'DD/MM/YYYY'
            }
        });
    });

    // Change tipe
    $(document).on("change", "input[name=popup_tipe]", function(){
        var tipe = $(this).val();
        if(tipe == 1){
            $("#input-tipe-1").removeClass("d-none");
            $("#input-tipe-2").addClass("d-none");
        }
        else if(tipe == 2){
            $("#input-tipe-2").removeClass("d-none");
            $("#input-tipe-1").addClass("d-none");
        }
    });

    // Change file
    $(document).on("change", "#file", function(){
        change_file(this, "image", 2);
    });
    
    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        e.preventDefault();

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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.css') }}">

@endsection