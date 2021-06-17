@extends('faturcms::template.admin.main')

@section('title', 'Data Absensi')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Absensi',
        'items' => [
            ['text' => 'Absensi', 'url' => route('admin.absensi.index')],
            ['text' => 'Data Absensi', 'url' => '#'],
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
                        <a href="{{ route('admin.absensi.export', ['tanggal' => $tanggal]) }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-2"></i> Export ke Excel</a>
                    </div>
                    <div>
                        <form method="get" action="{{ route('admin.absensi.index') }}">
                            <div class="input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                              </div>
                              <input type="text" name="tanggal" class="form-control form-control-sm" value="{{ $tanggal }}" readonly>
                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Filter"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Tile Title -->
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
                                    <th>Identitas User</th>
                                    <th width="100">Instansi</th>
                                    <th width="100">Jurusan / Kelas</th>
                                    <th width="90">Waktu Absen</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absensi as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_absensi]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>{{ $data->instansi }}</td>
                                    <td>{{ $data->jurusan }}<br><small>Kelas: {{ $data->kelas }}</small></td>
                                    <td>
                                        <span class="d-none">{{ $data->absensi_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->absensi_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->absensi_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_absensi }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.absensi.delete') }}">
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

<script src="{{ asset('templates/vali-admin/js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Datepicker
        $("input[name=tanggal]").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });

    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection