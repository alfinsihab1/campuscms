@extends('faturcms::template.admin.main')

@section('title', 'E-Sertifikat Peserta')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'E-Sertifikat Peserta',
        'items' => [
            ['text' => 'E-Sertifikat', 'url' => '#'],
            ['text' => 'E-Sertifikat Peserta', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th width="100">Kode Sertifikat</th>
                                    <th>Pelatihan</th>
                                    <th width="100">Waktu Pelatihan</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sertifikat as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->kode_sertifikat }}</td>
                                    <td>
                                        <a href="{{ route('admin.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
                                        <br>
                                        <small><i class="fa fa-tag mr-1"></i>{{ $data->nomor_pelatihan }}</small>
                                    </td>
                                    <td>
                                        <span class="d-none">{{ $data->tanggal_pelatihan_from }}</span>
                                        {{ date('d/m/Y', strtotime($data->tanggal_pelatihan_from)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->tanggal_pelatihan_from)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('member.sertifikat.peserta.detail', ['id' => $data->id_pm]) }}" target="_blank" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>
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

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection