@extends('faturcms::template.admin.main')

@section('title', 'Data Psikolog')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Psikolog',
        'items' => [
            ['text' => 'Psikolog', 'url' => route('admin.psikolog.index')],
            ['text' => 'Data Psikolog', 'url' => '#'],
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
                        <a href="{{ route('admin.psikolog.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Identitas Psikolog</th>
                                    <th width="150">Kode</th>
                                    <th width="100">Kategori</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($psikolog as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        {{ $data->nama_psikolog }}
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_telepon_psikolog }}</small>
                                        <br>
                                        @if($data->instagram_psikolog != '')
                                        <small><i class="fa fa-instagram mr-1"></i>{{ $data->instagram_psikolog }}</small>
                                        <br>
                                        @endif
                                        <small><i class="fa fa-map-marker mr-1"></i>{{ $data->alamat_psikolog }}</small>
                                    </td>
                                    <td>{{ $data->kode_psikolog }}</td>
                                    <td>{{ psikolog($data->kategori_psikolog) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.psikolog.edit', ['id' => $data->id_psikolog]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_psikolog }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.psikolog.delete') }}">
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