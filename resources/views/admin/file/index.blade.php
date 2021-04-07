@extends('faturcms::template.admin.main')

@section('title', 'Materi '.$kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Materi '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => 'Materi '.$kategori->folder_kategori, 'url' => '#'],
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
                    <!-- Breadcrumb Direktori -->
                    <ol class="breadcrumb bg-white p-0 mb-0">
                        @foreach($breadcrumb as $key=>$data)
                            @if($key + 1 == count($breadcrumb))
                            <li class="breadcrumb-item active" aria-current="page">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                    <div class="btn-group">
                        <a href="{{ route('admin.blog.tag.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Folder</a>
                        <a href="{{ route('admin.blog.tag.create') }}" class="btn btn-sm btn-secondary"><i class="fa fa-plus mr-2"></i> Tambah File</a>
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
                                    <td>
                                        <i class="fa fa-folder-open mr-1"></i>
                                        <a href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama }}</a>
                                    </td>
                                    <td>{{ $data->folder_voucher }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->folder_up }}</span>
                                        {{ date('d/m/Y', strtotime($data->folder_up)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->folder_up)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ asset('assets/images/folder/'.$data->folder_icon) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Icon"><i class="fa fa-image"></i></a>
                                            <a href="#" class="btn btn-sm btn-success" data-toggle="tooltip" title="Pindah"><i class="fa fa-arrow-right"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_folder }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($files as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><i class="fa fa-file mr-1"></i><a href="#">{{ $data->file_nama }}</a></td>
                                    <td></td>
                                    <td>
                                        <span class="d-none">{{ $data->file_up }}</span>
                                        {{ date('d/m/Y', strtotime($data->file_up)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->file_up)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ asset('assets/images/file/'.$data->file_thumbnail) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Thumbnail"><i class="fa fa-image"></i></a>
                                            <a href="#" class="btn btn-sm btn-success" data-toggle="tooltip" title="Pindah"><i class="fa fa-arrow-right"></i></a>
                                            <a href="#" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_file }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
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