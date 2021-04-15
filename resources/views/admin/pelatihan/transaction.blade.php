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
                                        <a href="{{ route('admin.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
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
                                            @else
                                                <strong class="text-danger">Belum Diverifikasi</strong>
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center">
                                        <div class="btn-group"> 
                                            @if($data->fee_status == 0 && $data->fee_bukti != '')
                                                <a href="#" class="btn btn-sm btn-success btn-verify" data-id="{{ $data->id_pm }}" data-proof="{{ asset('assets/images/fee-pelatihan/'.$data->fee_bukti) }}" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>
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
    generate_datatable("#dataTable");

    // Button Verify
    $(document).on("click", ".btn-verify", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var proof = $(this).data("proof");
        $("#form-verify input[name=id]").val(id);
        $("#form-verify img").attr("src", proof);
        $("#modal-verify").modal("show");
    });
</script>

@endsection