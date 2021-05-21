@extends('faturcms::template.admin.main')

@section('title', 'Data Kategori Folder')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Kategori Folder',
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => 'Kategori Folder', 'url' => route('admin.folder.kategori.index')],
            ['text' => 'Data Kategori Folder', 'url' => '#'],
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
                        <a href="{{ route('admin.folder.kategori.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Kategori</th>
                                    <th>Slug</th>
                                    <th width="60">Tipe</th>
                                    <th width="60">Status</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->folder_kategori }}</td>
                                    <td>{{ $data->slug_kategori }}</td>
                                    <td>{{ ucfirst($data->tipe_kategori) }}</td>
                                    <td><span class="badge {{ $data->status_kategori == 1 ? 'badge-success' : 'badge-danger' }}">{{ $data->status_kategori == 1 ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.folder.kategori.edit', ['id' => $data->id_fk]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_fk }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.folder.kategori.delete') }}">
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