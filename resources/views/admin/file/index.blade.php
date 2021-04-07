@extends('faturcms::template.admin.main')

@section('title', $kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => $kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->folder_kategori, 'url' => '#'],
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
                        <a href="{{ route('admin.blog.tag.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Folder / File</th>
                                    <th width="100">Voucher</th>
                                    <th width="100">Waktu Diubah</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($folders as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><i class="fa fa-folder-open mr-1"></i><a href="#">{{ $data->folder_nama }}</a></td>
                                    <td>{{ $data->folder_voucher }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->folder_up }}</span>
                                        {{ date('d/m/Y', strtotime($data->folder_up)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->folder_up)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-success" data-toggle="tooltip" title="Buka"><i class="fa fa-folder-open"></i></a>
                                            <a href="{{ asset('assets/images/icon/'.$data->folder_icon) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Folder Icon"><i class="fa fa-image"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger {{ $data->id_tag == 0 ? 'btn-forbidden' : 'btn-delete' }}" data-id="{{ $data->id_tag }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.blog.tag.delete') }}">
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