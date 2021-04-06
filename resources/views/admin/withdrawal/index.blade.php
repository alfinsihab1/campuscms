@extends('faturcms::template.admin.main')

@section('title', 'Withdrawal')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Withdrawal',
        'items' => [
            ['text' => 'Transaksi', 'url' => '#'],
            ['text' => 'Withdrawal', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th width="80">Invoice</th>
                                    <th width="120">Waktu Penarikan</th>
                                    <th>Identitas User</th>
                                    <th>Ditransfer ke</th>
                                    <th width="100">Status</th>
                                    <th width="100">Jumlah (Rp.)</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawal as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->inv_withdrawal }}</td>
                                    <td>
                                        @if($data->withdrawal_at != null)
                                            <span class="d-none">{{ $data->withdrawal_at }}</span>
                                            {{ date('d/m/Y', strtotime($data->withdrawal_at)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->withdrawal_at)) }} WIB</small>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>{{ $data->nama_platform }} | {{ $data->nomor }} | {{ $data->atas_nama }}</td>
                                    <td>
                                        @if($data->withdrawal_status == 0)
                                            <strong class="text-danger">Sedang Diproses</strong>
                                        @else
                                            <strong class="text-success">Diterima</strong>
                                        @endif
                                    </td>
                                    <td>{{ number_format($data->nominal,0,',',',') }}</td>
                                    <td>
                                        @if($data->withdrawal_status == 0)
                                            <a href="#" class="btn btn-sm btn-warning btn-send" data-id="{{ $data->id_withdrawal }}" data-toggle="toggle" title="Kirim Komisi"><i class="fa fa-chevron-right"></i></a>
                                        @else
                                            <a href="{{ asset('assets/images/withdrawal/'.$data->withdrawal_proof) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

<!-- Modal Kirim Komisi -->
<div class="modal fade" id="modal-send" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kirim Komisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-send" method="post" action="{{ route('admin.withdrawal.send') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <br>
                            <button id="btn-choose" type="button" class="btn btn-md btn-info"><i class="fa fa-folder-open mr-1"></i>Pilih File...</button>
                            <input type="file" id="file" class="d-none" accept="image/*">
                            <br><br>
                            <img id="image" class="img-thumbnail d-none">
                            <input type="hidden" name="src_image" id="src_image">
                        </div>
                        <input type="hidden" name="id_withdrawal">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-send" disabled>Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Kirim Komisi -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    /* Upload File */
    $(document).on("click", ".btn-send", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("input[name=id_withdrawal]").val(id);
        $("#modal-send").modal("show");
    });
    
    $(document).on("click", "#btn-choose", function(e){
        e.preventDefault();
        $("#file").trigger("click");
    });

    $(document).on("change", "#file", function(){
        // ukuran maksimal upload file
        $max = 2 * 1024 * 1024;

        // validasi
        if(this.files && this.files[0]) {
            // jika ukuran melebihi batas maksimum
            if(this.files[0].size > $max){
                alert("Ukuran file terlalu besar dan melebihi batas maksimum! Maksimal 2 MB");
                $("#file").val(null);
                $("#btn-submit-send").attr("disabled","disabled");
            }
            // jika ekstensi tidak diizinkan
            else if(!validateExtension(this.files[0].name)){
                alert("Ekstensi file tidak diizinkan!");
                $("#file").val(null);
                $("#btn-submit-send").attr("disabled","disabled");
            }
            // validasi sukses
            else{
                readURL(this);
                $("#btn-submit-send").removeAttr("disabled");
            }
            // console.log(this.files[0]);
        }
    });
    
    $(document).on("click", "#btn-submit-send", function(e){
        e.preventDefault();
        $("#form-send")[0].submit();
    });

    $('#modal').on('hidden.bs.modal', function(){
        $("#file").val(null);
        $("#src_image").val(null);
        $("input[name=id_withdrawal]").val(null);
        $("#image").removeAttr("src").addClass("d-none");
        $("#btn-submit-send").attr("disabled","disabled");
    });

    function getFileExtension(filename){
        var split = filename.split(".");
        var extension = split[split.length - 1];
        return extension;
    }

    function validateExtension(filename){
        var ext = getFileExtension(filename);

        // ekstensi yang diizinkan
        var extensions = ['jpg', 'jpeg', 'png', 'bmp', 'svg'];
        for(var i in extensions){
            if(ext == extensions[i]) return true;
        }
        return false;
    }

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imageURL = e.target.result;
                $("#src_image").val(e.target.result);
                $("#image").attr("src", e.target.result).removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection