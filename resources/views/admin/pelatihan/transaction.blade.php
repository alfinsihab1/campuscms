@extends('faturcms::template.admin.main')

@section('title', 'Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pelatihan',
        'items' => [
            ['text' => 'Transaksi', 'url' => '#'],
            ['text' => 'Pelatihan', 'url' => '#'],
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
                                    <th width="120">Waktu Membayar</th>
                                    <th>Identitas User</th>
                                    <th>Pelatihan</th>
                                    <th width="120">Jumlah (Rp.)</th>
                                    <th width="80">Status</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelatihan_member as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->inv_pelatihan }}</td>
                                    <td>
                                        @if($data->pm_at != null)
                                            <span class="d-none">{{ $data->pm_at }}</span>
                                            {{ date('d/m/Y', strtotime($data->pm_at)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->pm_at)) }} WIB</small>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-2"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-2"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <a href="/admin/pelatihan/detail/{{ $data->id_pelatihan }}">{{ $data->nama_pelatihan }}</a>
                                        <br>
                                        <small><i class="fa fa-tag mr-2"></i>{{ $data->nomor_pelatihan }}</small>
                                    </td>
                                    <td>
                                        {{ $data->fee > 0 ? number_format($data->fee,0,',',',') : 'Free' }}
                                    </td>
                                    <td>
                                        @if($data->fee_status == 1)
                                            <strong class="text-success">Diterima</strong>
                                        @else
                                            @if($data->fee_bukti == '')
                                                <strong class="text-danger">User Belum Membayar</strong>
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center">
                                        <div class="btn-group"> 
                                            @if($data->fee_status == 0 && $data->fee_bukti != '')
                                                <a href="#" class="btn btn-sm btn-sucess btn-verify" data-id="{{ $data->id_pm }}" data-proof="{{ asset('assets/images/fee-pelatihan/'.$data->fee_bukti) }}" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>
                                            @endif
                                            @if($data->fee_bukti != '')
                                                <a href="{{ asset('assets/images/fee-pelatihan/'.$data->fee_bukti) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                            @endif
                                        </div>
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

<!-- Modal Verifikasi Pembayaran -->
<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-verify" method="post" action="{{ route('admin.pelatihan.verify') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Transfer:</label>
                            <br>
                            <img id="komisi-proof" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                        <input type="hidden" name="id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-verify">Verifikasi</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Verifikasi Pembayaran -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    /* Verifikasi Pelatihan */
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("input[name=id]").val(id);
        $("#komisi-proof").attr("src", proof);
        $("#modal-verify").modal("show");
    });
    
    $(document).on("click", "#btn-submit-verify", function(e){
        e.preventDefault();
        $("#form-verify")[0].submit();
    });
    $('#modal-verify').on('hidden.bs.modal', function(){
        $("#komisi-proof").removeAttr("src");
    });

    /* Upload File */
    $(document).on("click", ".btn-send", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("input[name=id_withdrawal]").val(id);
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