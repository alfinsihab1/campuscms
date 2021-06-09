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
                                    <th width="100">Waktu</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($email as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.email.detail', ['id' => $data->id_email]) }}">{{ $data->subject }}</a>
                                        <br>
                                        @if(count_penerima_email($data->receiver_id)>0)
                                            <small class="text-muted"><i class="fa fa-check-circle mr-1"></i>Sudah dikirim kepada {{ number_format(count_penerima_email($data->receiver_id),0,'.','.') }} dari total {{ number_format(count_member_aktif(),0,'.','.') }} member.</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <span class="d-none">{{ $data->sent_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->sent_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->sent_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.email.detail', ['id' => $data->id_email]) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                            <a href="#" class="btn btn-success btn-sm btn-forward" data-id="{{ $data->id_email }}" data-r="{{ $data->receiver_id }}" data-toggle="tooltip" title="Teruskan"><i class="fa fa-share"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $data->id_email }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
    
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

@endsection

@section('css-extra')

<style type="text/css">
    #modal-forward .modal-content {max-height: 500px; overflow-y: hidden;}
    .modal-body {overflow-y: auto;}
    #table-receivers tr td {padding: .5rem!important;}
    #table-receivers tr:hover {background-color: #eeeeee!important;}
    .tr-checkbox {cursor: pointer;}
    .tr-active {background-color: #e5e5e5!important;}
</style>

@endsection