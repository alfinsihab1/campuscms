@extends('faturcms::template.admin.main')

@section('title', 'Edit Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('admin.pelatihan.index')],
            ['text' => 'Edit Pelatihan', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.pelatihan.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $pelatihan->id_pelatihan }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama Pelatihan <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_pelatihan" class="form-control {{ $errors->has('nama_pelatihan') ? 'is-invalid' : '' }}" value="{{ $pelatihan->nama_pelatihan }}">
                                @if($errors->has('nama_pelatihan'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_pelatihan')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Trainer <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select name="trainer" class="form-control {{ $errors->has('trainer') ? 'is-invalid' : '' }}">
                                    <option value="" disabled selected>--Pilih--</option>
                                    @foreach($trainer as $data)
                                    <option value="{{ $data->id_user }}" {{ $pelatihan->trainer == $data->id_user ? 'selected' : '' }}>{{ $data->nama_user }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('trainer'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('trainer')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tempat Pelatihan</label>
                            <div class="col-md-10">
                                <input type="text" name="tempat_pelatihan" class="form-control {{ $errors->has('tempat_pelatihan') ? 'is-invalid' : '' }}" value="{{ $pelatihan->tempat_pelatihan }}">
                                @if($errors->has('tempat_pelatihan'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tempat_pelatihan')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal Mendaftar Pelatihan <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="tanggal_pelatihan" class="form-control {{ $errors->has('tanggal_pelatihan') ? 'is-invalid' : '' }}" value="{{ old('tanggal_pelatihan') }}">
                                @if($errors->has('tanggal_pelatihan'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_pelatihan')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal di Sertifikat <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="tanggal_sertifikat" class="form-control {{ $errors->has('tanggal_sertifikat') ? 'is-invalid' : '' }}" value="{{ old('tanggal_sertifikat') }}">
                                @if($errors->has('tanggal_sertifikat'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_sertifikat')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Fee <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text {{ $errors->has('fee') ? 'border-danger' : '' }}">Rp.</span>
                                    </div>
                                    <input type="text" name="fee" class="form-control {{ $errors->has('fee') ? 'is-invalid' : '' }} number-only thousand-format" value="{{ number_format($pelatihan->fee_member,0,'.','.') }}">
                                </div>
                                @if($errors->has('fee'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('fee')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" id="file" class="d-none" accept="image/*">
                                <a class="btn btn-sm btn-secondary btn-image" href="#"><i class="fa fa-image mr-2"></i>Pilih Gambar...</a>
                                <br>
                                <img src="{{ image('assets/images/pelatihan/'.$pelatihan->gambar_pelatihan, 'pelatihan') }}" id="img-file" class="mt-2 img-thumbnail {{ $pelatihan->gambar_pelatihan != '' ? '' : 'd-none' }}" style="max-height: 150px">
                                <input type="hidden" name="gambar">
                                <input type="hidden" name="gambar_url">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Materi</label>
                            <div class="col-md-10">
                                <a class="btn btn-sm btn-secondary btn-add-materi" href="#"><i class="fa fa-plus mr-2"></i>Tambah Materi</a>
                                <div class="table-responsive-sm konten-materi mt-3 mb-3 mb-md-0">
                                    @if(count($pelatihan->materi_pelatihan)>0)
                                        @foreach($pelatihan->materi_pelatihan as $key=>$materi)
                                        <div class="form-row" data-id="{{ ($key+1) }}">
                                            <div class="form-group col-4">
                                                <input type="text" name="kode_unit[]" class="form-control kode-unit" data-id="{{ ($key+1) }}" placeholder="Kode Unit" value="{{ $materi['kode'] }}">
                                            </div>
                                            <div class="form-group col-4">
                                                <input type="text" name="judul_unit[]" class="form-control judul-unit" data-id="{{ ($key+1) }}" placeholder="Judul Unit" value="{{ $materi['judul'] }}">
                                            </div>
                                            <div class="form-group col-3">
                                                <input type="text" name="durasi[]" class="form-control number-only durasi" data-id="{{ ($key+1) }}" placeholder="Durasi (Jam)" value="{{ $materi['durasi'] }}">
                                            </div>
                                            <div class="form-group col-1">
                                                <a href="#" class="btn btn-danger btn-block {{ count($pelatihan->materi_pelatihan) <= 1 ? 'btn-disabled' : 'btn-delete-materi' }}" data-id="{{ ($key+1) }}" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="form-row" data-id="1">
                                            <div class="form-group col-4">
                                                <input type="text" name="kode_unit[]" class="form-control kode-unit" data-id="1" placeholder="Kode Unit">
                                            </div>
                                            <div class="form-group col-4">
                                                <input type="text" name="judul_unit[]" class="form-control judul-unit" data-id="1" placeholder="Judul Unit">
                                            </div>
                                            <div class="form-group col-3">
                                                <input type="text" name="durasi[]" class="form-control number-only durasi" data-id="1" placeholder="Durasi (Jam)">
                                            </div>
                                            <div class="form-group col-1">
                                                <a href="#" class="btn btn-danger btn-block btn-disabled" data-id="1" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <a class="btn btn-sm btn-secondary btn-add-materi" href="#"><i class="fa fa-plus mr-2"></i>Tambah Materi</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="deskripsi" class="d-none"></textarea>
                                <div id="editor">{!! html_entity_decode($pelatihan->deskripsi_pelatihan) !!}</div> 
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
        $("input[name=tanggal_pelatihan]").daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showDropdowns: true,
            autoApply: true,
            startDate: "{{ date('d/m/Y H:i', strtotime($pelatihan->tanggal_pelatihan_from)) }}",
            endDate: "{{ date('d/m/Y H:i', strtotime($pelatihan->tanggal_pelatihan_to)) }}",
            locale: {
              format: 'DD/MM/YYYY HH:mm'
            }
        });

        // Daterangepicker
        $("input[name=tanggal_sertifikat]").daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showDropdowns: true,
            autoApply: true,
            startDate: "{{ date('d/m/Y H:i', strtotime($pelatihan->tanggal_sertifikat_from)) }}",
            endDate: "{{ date('d/m/Y H:i', strtotime($pelatihan->tanggal_sertifikat_to)) }}",
            locale: {
              format: 'DD/MM/YYYY HH:mm'
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