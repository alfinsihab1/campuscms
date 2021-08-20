@extends('faturcms::template.admin.main')

@section('title', 'Transaksi Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Transaksi Pelatihan',
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
            <form id="form-verify" method="post" action="{{ route('admin.pelatihan.verify') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Bukti Transfer:</label>
                            <br>
                            <img class="img-thumbnail mt-2" style="max-width: 300px;">
                        </div>
                        <input type="hidden" name="id">
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
<!-- /Modal Verifikasi Pembayaran -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable", {
        "url": "{{ route('admin.pelatihan.transaction.data') }}",
        "columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'inv_pelatihan', name: 'inv_pelatihan'},
            {data: 'waktu_membayar', name: 'waktu_membayar'},
            {data: 'user_identity', name: 'user_identity'},
            {data: 'pelatihan', name: 'pelatihan'},
            {data: 'fee', name: 'fee'},
            {data: 'status', name: 'status'},
            {data: 'options', name: 'options'},
        ],
        "order": [2, 'desc']
    });

    // Button Verify
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("#form-verify input[name=id]").val(id);
        $("#form-verify img").attr("src", proof).removeClass("d-none");
        $("#modal-verify").modal("show");
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection