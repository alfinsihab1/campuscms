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

<!-- Modal Verifikasi Komisi -->
<div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Komisi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-verify" method="post" action="{{ route('admin.komisi.verify') }}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Transfer:</label>
                            <br>
                            <img class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Verifikasi</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal Verifikasi Komisi -->

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
            <form id="form-confirm" method="post" action="{{ route('admin.komisi.confirm') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <br>
                            <button type="button" class="btn btn-sm btn-info btn-browse-file mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
                            <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                            <br><br>
                            <img id="image" class="img-thumbnail d-none">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" disabled>Konfirmasi</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal Konfirmasi -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable", {
		"url": "{{ route('admin.komisi.data') }}",
		"columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'inv_komisi', name: 'inv_komisi'},
            {data: 'komisi_at', name: 'komisi_at'},
            {data: 'user_identity', name: 'user_identity'},
            {data: 'sponsor', name: 'sponsor'},
            {data: 'komisi', name: 'komisi'},
            {data: 'komisi_status', name: 'komisi_status'},
            {data: 'options', name: 'options'},
		],
        "order": [6, 'asc']
	});

    // Button Verify
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("#form-verify input[name=id_komisi]").val(id);
        $("#form-verify img").attr("src", proof).removeClass("d-none");
        $("#modal-verify").modal("show");
    });

    // Button Confirm
    $(document).on("click", ".btn-confirm", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $("#form-confirm input[name=id_komisi]").val(id);
        $("#modal-confirm").modal("show");
    });

    // Change file
    $(document).on("change", "#file", function(){
        change_file(this, "image", 2);
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection