@extends('faturcms::template.admin.main')

@section('title', 'Detail Pesan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Pesan',
        'items' => [
            ['text' => 'Email', 'url' => route('admin.email.index')],
            ['text' => 'Detail Pesan', 'url' => '#'],
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
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Subjek <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <input type="text" name="subjek" class="form-control {{ $errors->has('subjek') ? 'is-invalid' : '' }}" value="{{ $email->subject }}">
                            @if($errors->has('subjek'))
                            <div class="small text-danger mt-1">{{ ucfirst($errors->first('subjek')) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Penerima <span class="text-danger">*</span></label>
                        <div class="col-md-10">
                            <a class="btn btn-sm btn-secondary btn-search" href="#"><i class="fa fa-search mr-2"></i>Lihat Penerima</a>
                            <br>
                            <textarea name="emails" class="form-control mt-3 {{ $errors->has('emails') ? 'is-invalid' : '' }}" rows="3" readonly>{{ $email->receiver_email }}</textarea>
                            <input type="hidden" name="ids" value="{{ $email->receiver_id }}">
                            <input type="hidden" name="names" value="{{ old('names') }}">
                            @if($errors->has('emails'))
                            <div class="small text-danger mt-1">{{ ucfirst($errors->first('emails')) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Pesan</label>
                        <div class="col-md-10">
                            <textarea name="pesan" class="d-none"></textarea>
                            <div id="editor">{!! html_entity_decode($email->content) !!}</div> 
                            @if($errors->has('pesan'))
                            <div class="small text-danger mt-1">{{ ucfirst($errors->first('pesan')) }}</div>
                            @endif
                        </div>
                    </div>
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

<!-- Search Modal -->
<div class="modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Lihat Penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table mb-0" id="table-receivers">
                    @foreach($members as $member)
                    <tr class="tr-checkbox" data-id="{{ $member->id_user }}" data-email="{{ $member->email }}">
                        <td>
                            <input name="receivers[]" class="input-receivers d-none" type="checkbox" data-id="{{ $member->id_user }}" data-email="{{ $member->email }}" value="{{ $member->id_user }}">
                            <span class="text-primary"><i class="fa fa-user mr-2"></i>{{ $member->nama_user }}</span>
                            <br>
                            <span class="small text-dark"><i class="fa fa-envelope mr-2"></i>{{ $member->email }}</span>
                        </td>
                        <td width="30" align="center" class="td-check align-middle">
                            <i class="fa fa-check text-primary d-none"></i>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="temp-id">
                <span><strong id="count-checked">0</strong> email terpilih.</span>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Search Modal -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-editor')

<script type="text/javascript">
    // Quill
    generate_quill("#editor", true);
    
    // Button Search
    $(document).on("click", ".btn-search", function(e){
        e.preventDefault();
        var ids = $("input[name=ids]").val();
        var arrayId = ids.length > 0 ? ids.split(",") : [];
        arrayId.forEach(function(item){
            $(".input-receivers[data-id="+item+"]").attr("checked", "checked");
            actionChecked($(".input-receivers[data-id="+item+"]"), true);
        });
        countChecked(arrayId);
        $("#modal-search").modal("show");
    });
    
    function actionChecked(elem, is_checked){
        if(is_checked == true){
            $(elem).parents(".tr-checkbox").addClass("tr-active");
            $(elem).parents(".tr-checkbox").find(".td-check .fa").removeClass("d-none");
        }
        else{
            $(elem).parents(".tr-checkbox").removeClass("tr-active");
            $(elem).parents(".tr-checkbox").find(".td-check .fa").addClass("d-none");
        }
    }
    
    function countChecked(array){
        var checked = array.length;
        $("#count-checked").text(checked);
        checked <= 0 ? $("#btn-choose").attr("disabled","disabled") : $("#btn-choose").removeAttr("disabled");
        return checked;
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
<style type="text/css">
    #modal-search .modal-content {max-height: calc(100vh - 50px); overflow-y: hidden;}
    .modal-body {overflow-y: auto;}
    #table-receivers tr td {padding: .5rem!important;}
    #table-receivers tr:hover {background-color: #eeeeee!important;}
    .tr-checkbox {cursor: pointer;}
    .tr-active {background-color: #e5e5e5!important;}
</style>

@endsection