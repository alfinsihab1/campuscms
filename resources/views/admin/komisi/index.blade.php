@extends('faturcms::template.admin.main')

@section('title', 'Komisi')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Komisi',
        'items' => [
            ['text' => 'Transaksi', 'url' => '#'],
            ['text' => 'Komisi', 'url' => '#'],
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
                                    <th>Identitas Sponsor</th>
                                    <th width="120">Komisi</th>
                                    <th width="80">Status</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($komisi as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->inv_komisi }}</td>
                                    <td>
                                        @if($data->komisi_at != null)
                                            <span class="d-none">{{ $data->komisi_at }}</span>
                                            {{ date('d/m/Y', strtotime($data->komisi_at)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->komisi_at)) }} WIB</small>
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user ]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_sponsor->id_user ]) }}">{{ $data->id_sponsor->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->id_sponsor->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->id_sponsor->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <strong>Aktivasi Komisi:</strong><br>
                                        Rp. {{ number_format($data->komisi_aktivasi,0,',',',') }}<br><br>
                                        <strong>Hasil Komisi:</strong><br>
                                        Rp. {{ number_format($data->komisi_hasil,0,',',',') }}
                                    </td>
                                    <td>
                                        @if($data->komisi_status == 1)
                                            <strong class="text-success">Diterima</strong>
                                        @else
                                            @if($data->komisi_proof != '')
                                                <a href="#" class="btn btn-sm btn-success btn-verify" data-id="{{ $data->id_komisi }}" data-proof="{{ asset('assets/images/komisi/'.$data->komisi_proof) }}" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>
                                            @else
                                                <strong class="text-danger">User Belum Membayar</strong>
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center">
                                        @if($data->komisi_proof != '')
                                            <a href="{{ asset('assets/images/komisi/'.$data->komisi_proof) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                        @else
                                            <!--<strong class="text-danger"><i class="fa fa-times"></i></strong>-->
                                            <a href="#" class="btn btn-sm btn-success btn-confirm" data-id="{{ $data->id_komisi }}" data-toggle="tooltip" title="Konfirmasi Pembayaran"><i class="fa fa-check"></i></a>
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
<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Komisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-verify" method="post" action="{{ route('admin.komisi.verify') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Transfer:</label>
                            <br>
                            <img id="komisi-proof" class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                        <input type="hidden" name="id_komisi">
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
<!-- End Modal Kirim Komisi -->

<!-- Modal Konfirmasi -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-confirm" method="post" action="{{ route('admin.komisi.confirm') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <br>
                            <button id="btn-choose" type="button" class="btn btn-md btn-info mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
                            <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                            <br><br>
                            <img id="image" class="img-thumbnail d-none">
                            <input type="hidden" name="src_image" id="src_image">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-confirm" disabled>Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Konfirmasi -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    /* Verifikasi Komisi */
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("#form-verify input[name=id_komisi]").val(id);
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

    /* Konfirmasi Pendaftaran */
    $(document).on("click", ".btn-confirm", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("#form-confirm input[name=id_komisi]").val(id);
        $("#modal-confirm").modal("show");
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
            else if(!validateExtension(this.files[0].name, "image")){
                alert("Ekstensi file tidak diizinkan!");
                $("#file").val(null);
                $("#btn-submit-send").attr("disabled","disabled");
            }
            // validasi sukses
            else{
                readURL(this);
                $("#btn-submit-confirm").removeAttr("disabled");
            }
            // console.log(this.files[0]);
        }
    });
    
    $(document).on("click", "#btn-submit-confirm", function(e){
        e.preventDefault();
        $("#form-confirm")[0].submit();
    });

    // function getFileExtension(filename){
    //     var split = filename.split(".");
    //     var extension = split[split.length - 1];
    //     return extension;
    // }

    // function validateExtension(filename){
    //     var ext = getFileExtension(filename);

    //     // ekstensi yang diizinkan
    //     var extensions = ['jpg', 'jpeg', 'png', 'bmp', 'svg'];
    //     for(var i in extensions){
    //         if(ext == extensions[i]) return true;
    //     }
    //     return false;
    // }

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e){
                imageURL = e.target.result;
                // $("#src_image").val(e.target.result);
                $("#image").attr("src", e.target.result).removeClass("d-none");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endsection