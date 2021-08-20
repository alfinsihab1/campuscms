@extends('faturcms::template.admin.main')

@section('title', 'Edit Acara')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Acara',
        'items' => [
            ['text' => 'Acara', 'url' => route('admin.acara.index')],
            ['text' => 'Edit Acara', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.acara.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $acara->id_acara }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Acara <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_acara" class="form-control {{ $errors->has('nama_acara') ? 'is-invalid' : '' }}" value="{{ $acara->nama_acara }}">
                                @if($errors->has('nama_acara'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_acara')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Kategori <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : '' }}">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($kategori as $data)
                                    <option value="{{ $data->id_ka }}" {{ $acara->kategori_acara == $data->id_ka ? 'selected' : '' }}>{{ $data->kategori }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('kategori'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('kategori')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tempat Acara</label>
                            <div class="col-md-10">
                                <input type="text" name="tempat_acara" class="form-control {{ $errors->has('tempat_acara') ? 'is-invalid' : '' }}" value="{{ $acara->tempat_acara }}">
                                @if($errors->has('tempat_acara'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tempat_acara')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Waktu Acara <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="tanggal_acara" class="form-control {{ $errors->has('tanggal_acara') ? 'is-invalid' : '' }}" value="{{ old('tanggal_acara') }}">
                                @if($errors->has('tanggal_acara'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_acara')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ image('assets/images/acara/'.$acara->gambar_acara, 'acara') }}" id="img-file" class="mt-2 img-thumbnail {{ $acara->gambar_acara != '' ? '' : 'd-none' }}" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="d-none"></textarea>
                                <div id="editor">{!! html_entity_decode($acara->deskripsi_acara) !!}</div> 
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

@include('faturcms::template.admin._js-image', ['imageType' => 'acara', 'croppieWidth' => 640, 'croppieHeight' => 360])

@include('faturcms::template.admin._js-editor')

<script type="text/javascript" src="{{ asset('assets/plugins/moment.js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Quill
        generate_quill("#editor");

        // Daterangepicker
        $("input[name=tanggal_acara]").daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showDropdowns: true,
            autoApply: true,
            startDate: "{{ date('d/m/Y H:i', strtotime($acara->tanggal_acara_from)) }}",
            endDate: "{{ date('d/m/Y H:i', strtotime($acara->tanggal_acara_to)) }}",
            locale: {
              format: 'DD/MM/YYYY HH:mm'
            }
        });
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

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.css') }}">

@endsection