@extends('faturcms::template.admin.main')

@section('title', 'Data Kategori Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Kategori Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('admin.pelatihan.index')],
            ['text' => 'Kategori', 'url' => route('admin.pelatihan.kategori.index')],
            ['text' => 'Data Kategori Pelatihan', 'url' => '#'],
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
                        <a href="{{ route('admin.pelatihan.kategori.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategori as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>{{ $data->kategori }}</td>
                                    <td>{{ $data->slug }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pelatihan.kategori.edit', ['id' => $data->id_kp]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_kp }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.pelatihan.kategori.delete') }}">
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