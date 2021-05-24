@extends('faturcms::template.admin.main')

@section('title', 'Data Halaman')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Halaman',
        'items' => [
            ['text' => 'Halaman', 'url' => route('admin.halaman.index')],
            ['text' => 'Data Halaman', 'url' => '#'],
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
                        <a href="{{ route('admin.halaman.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Judul Halaman</th>
                                    <th width="80">Tipe</th>
                                    <th width="100">Waktu</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($halaman as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ URL::to($data->halaman_permalink) }}" target="_blank">{{ $data->halaman_title }}</a>
                                        <br>
                                        <small><i class="fa fa-link mr-1"></i>{{ URL::to($data->halaman_permalink) }}</small>
                                    </td>
                                    <td><span class="badge {{ $data->halaman_tipe == 1 ? 'badge-success' : 'badge-info' }}">{{ tipe_halaman($data->halaman_tipe) }}</span></td>
                                    <td>
                                        <span class="d-none">{{ $data->halaman_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->halaman_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->halaman_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/{{ $data->halaman_permalink }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail" target="_blank"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.halaman.edit', ['id' => $data->id_halaman]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_halaman }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.halaman.delete') }}">
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
    generate_datatable("#dataTable");
</script>

@endsection