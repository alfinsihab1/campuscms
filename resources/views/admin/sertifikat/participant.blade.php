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
                                    <th>Identitas Peserta</th>
                                    <th>Pelatihan</th>
                                    <th width="100">Waktu Pelatihan</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.sertifikat.peserta.delete') }}">
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

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable", {
        "url": "{{ route('admin.sertifikat.peserta.data') }}",
        "columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'kode_sertifikat', name: 'kode_sertifikat'},
            {data: 'user_identity', name: 'user_identity'},
            {data: 'pelatihan', name: 'pelatihan'},
            {data: 'tanggal_pelatihan_from', name: 'tanggal_pelatihan_from'},
            {data: 'options', name: 'options'},
        ],
        "order": [4, 'desc']
    });
</script>

@endsection