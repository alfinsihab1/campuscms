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
                                    <th width="40">No.</th>
                                    <th width="80">Invoice</th>
                                    <th width="100">Waktu</th>
                                    <th>Ditransfer ke</th>
                                    <th width="100">Status</th>
                                    <th width="100">Jumlah (Rp.)</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($withdrawal as $data)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $data->inv_withdrawal }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->withdrawal_success_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->withdrawal_success_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->withdrawal_success_at)) }} WIB</small>
                                    </td>
                                    <td>{{ $data->nama_platform }} | {{ $data->nomor }} | {{ $data->atas_nama }}</td>
                                    <td>
                                        @if($data->withdrawal_status == 0)
                                            <span class="badge badge-danger">Sedang Diproses</span>
                                        @else
                                            <span class="badge badge-success">Diterima</span>
                                        @endif
                                    </td>
                                    <td align="right">{{ number_format($data->nominal,0,',',',') }}</td>
                                    <td>
                                        @if($data->withdrawal_status == 1)
                                            <a href="{{ asset('assets/images/withdrawal/'.$data->withdrawal_proof) }}" class="btn btn-info btn-sm btn-magnify-popup" title="Bukti Transfer"><i class="fa fa-image"></i></a>
                                        @else
                                        @endif
                                    </td>
                                </tr>
                                @php $i++; @endphp
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

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">

@endsection