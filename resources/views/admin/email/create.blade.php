@extends('faturcms::template.admin.main')

@section('title', 'Tulis Pesan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Tulis Pesan',
        'items' => [
            ['text' => 'Email', 'url' => route('admin.email.index')],
            ['text' => 'Tulis Pesan', 'url' => '#'],
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
                    <form id="form" method="post" action="{{ route('admin.email.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Subjek <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="subjek" class="form-control {{ $errors->has('subjek') ? 'is-invalid' : '' }}" value="{{ old('subjek') }}">
                                @if($errors->has('subjek'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('subjek')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Penerima <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <a class="btn btn-sm btn-secondary btn-search" href="#"><i class="fa fa-search mr-2"></i>Cari Penerima</a>
                                <a class="btn btn-sm btn-success btn-excel" href="#"><i class="fa fa-file-excel-o mr-2"></i>Import Email</a>
                                <br>
                                <textarea name="emails" class="form-control mt-3 {{ $errors->has('emails') ? 'is-invalid' : '' }}" rows="3" readonly>{{ old('emails') }}</textarea>
                                <input type="hidden" name="ids" value="{{ old('ids') }}">
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
                                <div id="editor"></div> 
                                @if($errors->has('pesan'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('pesan')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-send mr-2"></i>Kirim</button>
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

<!-- Search Modal -->
<div class="modal fade" id="modal-search" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pilih Penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-12 pt-3" style="background-color: #e5e5e5;">
                <div class="">
                    <div class="form-group col-md-12">
                        @for($i=1; $i<=ceil(count($members)/100); $i++)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkbox-batch" name="batch" type="radio" id="checkbox-{{ $i }}" value="{{ $i }}">
                            <label class="form-check-label" for="checkbox-{{ $i }}">{{ (($i - 1) * 100) + 1 }}-{{ $i * 100 }}</label>
                        </div>
                        @endfor
                    </div>
                </div>
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
                <button type="button" class="btn btn-success btn-choose">Pilih</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Search Modal -->

<!-- Modal Import -->
<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-1">Caranya:</p>
                <ol>
                    <li>Download template File Excel <a class="font-weight-bold" href="{{ asset('assets/docs/Data Email.xls') }}">Disini.</a></li>
                    <li>Masukkan data email di file tersebut.</li>
                    <li>Import file tersebut disini.</li>
                </ol>
                <form id="form-import" method="post" action="#" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="file" id="file" class="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <button class="btn btn-sm btn-primary btn-file d-none"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
                    <br>
                    <input type="hidden" name="import" id="src-file">
                    <div class="small mt-2 text-muted">Hanya mendukung format: .XLS, .XLSX, dan .CSV</div>
                </form>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-success btn-import">Import</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Import -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-editor')

<script type="text/javascript">
    // Quill
    generate_quill("#editor");
    
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
    
    // Checkbox Batch
    $(document).on("change", ".checkbox-batch", function(){
        var value = $(".checkbox-batch:checked").val();
        var checkeds = $(".input-receivers");
        checkeds.each(function(key,elem){
            key >= ((value-1)*100) && key < (value*100) ? $(elem).prop("checked") ? $(elem).prop("checked", true) : $(elem).prop("checked", true) : $(elem).prop("checked", false);
            key >= ((value-1)*100) && key < (value*100) ? $(elem).prop("checked") ? actionChecked($(elem), true) : actionChecked($(elem), true) : actionChecked($(elem), false);
        });
        countChecked($(".input-receivers:checked"));
    });
    
    // Table Receivers Click
    $(document).on("click", ".tr-checkbox", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var email = $(this).data("email");
        var max = 100;
        $(".checkbox-batch").each(function(key,elem){
            $(elem).prop("checked",false);
        });
        if($(".input-receivers[data-id="+id+"]").prop("checked")){
            $(".input-receivers[data-id="+id+"]").prop("checked", false);
            actionChecked($(".input-receivers[data-id="+id+"]"), false);
            countChecked($(".input-receivers:checked"));
        }
        else{
            $(".input-receivers[data-id="+id+"]").prop("checked", true);
            actionChecked($(".input-receivers[data-id="+id+"]"), true);
            var count = countChecked($(".input-receivers:checked"));
            if(count > max){
                alert("Maksimal email yang bisa dipilih adalah "+max);
                $(".input-receivers[data-id="+id+"]").prop("checked", false);
                actionChecked($(".input-receivers[data-id="+id+"]"), false);
                countChecked($(".input-receivers:checked"));
            }
        }
    });
    
    // Button Choose
    $(document).on("click", ".btn-choose", function(e){
        e.preventDefault();
        var arrayId = [];
        var arrayEmail = [];
        $(".input-receivers:checked").each(function(){
            arrayId.push($(this).val());
            arrayEmail.push($(this).data("email"));
        });
        var joinId = arrayId.length > 0 ? arrayId.join(",") : '';
        var joinEmail = arrayEmail.length > 0 ? arrayEmail.join(", ") : '';
        $("input[name=ids]").val(joinId);
        $("input[name=names]").val(null);
        $("textarea[name=emails]").text(joinEmail);
        $("#modal-search").modal("hide");
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
    
    // Button Excel
    $(document).on("click", ".btn-excel", function(e){
        e.preventDefault();
        $("#modal-import").modal("show");
    });
    
    // Change Input File
    $(document).on("change", "#file", function(){
        $("#modal-import .modal-footer").removeClass("d-none");
    });
    
    // Import Email
    $(document).on("click", ".btn-import", function(e){
        e.preventDefault();
        var file_data = $('#file')[0].files[0];
        var formData = new FormData();                  
        formData.append("file", file_data);           
        formData.append("_token", $("input[name=_token]").val());
        $.ajax({
            type: "post",
            url: "{{ route('admin.email.import') }}",
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function(response){
                var result = JSON.parse(response);
                var arrayName = [];
                var arrayEmail = [];
                var i;
                for(i = 0; i < result[0].length; i++){
                    arrayName.push(result[0][i][1]);
                    arrayEmail.push(result[0][i][2]);
                }
                var names = arrayName.join(", ");
                var emails = arrayEmail.join(", ");
                $("input[name=ids]").val(null);
                $("input[name=names]").val(names);
                $("textarea[name=emails]").val(emails);
                $("#modal-import").modal("hide");
            }
        });
    });

    // Button Submit
    $(document).on("click", "button[type=submit]", function(e){
        var myEditor = document.querySelector('#editor');
        var html = myEditor.children[0].innerHTML;
        $("textarea[name=pesan]").text(html);
        $("#form").submit();
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">
<style type="text/css">
    .modal-content {max-height: 500px; overflow-y: hidden;}
    .modal-body {overflow-y: auto;}
    #table-receivers tr td {padding: .5rem!important;}
    #table-receivers tr:hover {background-color: #eeeeee!important;}
    .tr-checkbox {cursor: pointer;}
    .tr-active {background-color: #e5e5e5!important;}
</style>

@endsection