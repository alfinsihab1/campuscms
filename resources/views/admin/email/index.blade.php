@extends('faturcms::template.admin.main')

@section('title', 'Data Email')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Email',
        'items' => [
            ['text' => 'Email', 'url' => route('admin.email.index')],
            ['text' => 'Data Email', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <div class="btn-group">
                        <a href="{{ route('admin.email.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-pencil mr-2"></i> Tulis Pesan</a>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Email</th>
                                    <th width="150">Pengirim</th>
                                    <th width="100">Terjadwal</th>
                                    <th width="100">Waktu</th>
                                    <th width="80">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.email.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
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

<!-- Forward Modal -->
<div class="modal fade" id="modal-forward" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Teruskan Email ke...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-12 pt-3" style="background-color: #e5e5e5;">
                <div class="form-group col-md-12 checkbox-list"></div>
            </div>
            <div class="modal-body">
                <table class="table mb-0" id="table-receivers">
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <form class="form-forward" method="post" action="{{ route('admin.email.forward') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="id">
                    <input type="hidden" name="receiver">
                    <span><strong id="count-checked">0</strong> email terpilih.</span>
                    <button type="submit" class="btn btn-success btn-send">Kirim</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Forward Modal -->

<!-- Schedule Modal -->
<div class="modal fade" id="modal-schedule" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Atur Jadwal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('admin.email.schedule') }}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ old('id') }}">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Terjadwal <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="terjadwal" id="terjadwal-0" value="0" {{ old('terjadwal') == '0' ? 'checked' : '' }} {{ old('terjadwal') == null ? 'checked' : '' }}>
                                <label class="form-check-label" for="terjadwal-0">Tidak</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="terjadwal" id="terjadwal-1" value="1" {{ old('terjadwal') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="terjadwal-1">Ya</label>
                            </div>
                            @if($errors->has('terjadwal'))
                            <div class="small text-danger mt-1">{{ ucfirst($errors->first('terjadwal')) }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row form-jadwal {{ old('terjadwal') != 1 ? 'd-none' : '' }}">
                        <label class="col-md-3 col-form-label">Waktu Pengiriman Email <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <input type="text" name="scheduled" class="form-control clockpicker {{ $errors->has('scheduled') ? 'is-invalid' : '' }}" value="{{ old('scheduled') }}" autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text {{ $errors->has('scheduled') ? 'border-danger' : '' }}"><i class="fa fa-clock-o"></i></span>
                                </div>
                            </div>
                            @if($errors->has('scheduled'))
                            <div class="small text-danger mt-1">{{ ucfirst($errors->first('scheduled')) }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Schedule Modal -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript" src="{{ asset('assets/plugins/clockpicker/bootstrap-clockpicker.min.js') }}"></script>
<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable", {
        "url": "{{ route('admin.email.data') }}",
        "columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'email', name: 'email'},
            {data: 'sender', name: 'sender'},
            {data: 'scheduled', name: 'scheduled'},
            {data: 'sent_at', name: 'sent_at'},
            {data: 'options', name: 'options'},
        ],
        "order": [3, 'desc']
    });
    
    // Button Forward
    $(document).on("click", ".btn-forward", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var r = $(this).data("r");
        var receiver = r.toString().split(",");
        $("#modal-forward input[name=id]").val(id);
        $.ajax({
            type: "get",
            url: "{{ route('admin.email.member-json') }}",
            success: function(response){
                // Fetch data user
                var html = '';
                $(response.data).each(function(key,data){
                    if(receiver.indexOf(data.id_user.toString()) == -1){
                        html += '<tr class="tr-checkbox" data-id="' + data.id_user + '" data-email="' + data.email + '">';
                        html += '<td>';
                        html += '<input name="receivers[]" class="input-receivers d-none" type="checkbox" data-id="' + data.id_user + '" data-email="' + data.email + '" value="' + data.id_user + '">';
                        html += '<span class="text-primary"><i class="fa fa-user mr-2"></i>' + data.nama_user + '</span>';
                        html += '<br>';
                        html += '<span class="small text-dark"><i class="fa fa-envelope mr-2"></i>' + data.email + '</span>';
                        html += '</td>';
                        html += '<td width="30" align="center" class="td-check align-middle">';
                        html += '<i class="fa fa-check text-primary d-none"></i>';
                        html += '</td>';
                        html += '</tr>';
                    }
                });
                $("#table-receivers tbody").html(html);

                // Show checkbox list
                var html2 = '';
                for(var i=1; i<=Math.ceil(response.data.length/100); i++){
                    html2 += '<div class="form-check form-check-inline">';
                    html2 += '<input class="form-check-input checkbox-batch" name="batch" type="radio" id="checkbox-' + i + '" value="' + i + '">';
                    html2 += '<label class="form-check-label" for="checkbox-' + i + '">' + (((i - 1) * 100) + 1) + '-' + (i * 100) + '</label>';
                    html2 += '</div>';
                }
                $(".checkbox-list").html(html2);
                
                countChecked([]);

                // Show modal
                $("#modal-forward").modal("show");
            }
        });
    });
    
    // Hide Modal Forward
    $('#modal-forward').on('hidden.bs.modal', function(){
        $(".checkbox-batch").each(function(key,elem){
            $(elem).prop("checked", false);
        });
        $(".input-receivers").each(function(key,elem){
            $(elem).prop("checked", false);
            actionChecked($(elem), false);
        });
        countChecked($(".input-receivers:checked"));
    });
    
    // Button Schedule
    $(document).on("click", ".btn-schedule", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var schedule = $(this).data("schedule");
        
        // Add values
        $("#modal-schedule input[name=id]").val(id);
        if(schedule != ''){
            $("#modal-schedule #terjadwal-1").prop("checked", true);
            $("#modal-schedule .form-jadwal").removeClass("d-none");
            $("#modal-schedule input[name=scheduled]").val(schedule);
        }
        else{
            $("#modal-schedule #terjadwal-0").prop("checked", true);
            $("#modal-schedule .form-jadwal").addClass("d-none");
            $("#modal-schedule input[name=scheduled]").val(schedule);
        }

        // Show modal
        $("#modal-schedule").modal("show");
    });
    
    // Clockpicker
    $(".clockpicker").clockpicker({
        autoclose: true
    });

    // Change Terjadwal
    $(document).on("change", "input[name=terjadwal]", function(){
        var terjadwal = $(this).val();
        terjadwal == 1 ? $(".form-jadwal").removeClass("d-none") : $(".form-jadwal").addClass("d-none");
    });
    
    // Hide Modal Schedule
    $('#modal-schedule').on('hidden.bs.modal', function(){
        $("#modal-schedule input[name=id]").val(null);
        $("#modal-schedule input[name=scheduled]").val(null);
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

    // Button Send
    $(document).on("click", ".btn-send", function(e){
        e.preventDefault();
        var arrayId = [];
        $(".input-receivers:checked").each(function(){
            arrayId.push($(this).val());
        });
        var joinId = arrayId.length > 0 ? arrayId.join(",") : '';
        $(".form-forward input[name=receiver]").val(joinId);
        $(".form-forward").submit();
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
        checked <= 0 ? $(".btn-send").attr("disabled","disabled") : $(".btn-send").removeAttr("disabled");
        return checked;
    }
</script>
@if(count($errors)>0)
<script type="text/javascript">
    $("#modal-schedule").modal("show");
</script>
@endif

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/clockpicker/bootstrap-clockpicker.min.css') }}">
<style type="text/css">
    #modal-forward .modal-content {max-height: calc(100vh - 50px); overflow-y: hidden;}
    .modal-body {overflow-y: auto;}
    #table-receivers tr td {padding: .5rem!important;}
    #table-receivers tr:hover {background-color: #eeeeee!important;}
    .tr-checkbox {cursor: pointer;}
    .tr-active {background-color: #e5e5e5!important;}
</style>

@endsection