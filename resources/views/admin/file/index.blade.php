@extends('faturcms::template.admin.main')

@section('title', $kategori->prefix_kategori.' '.$kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => $kategori->prefix_kategori.' '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->prefix_kategori.' '.$kategori->folder_kategori, 'url' => '#'],
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
                        @foreach(file_breadcrumb($directory) as $key=>$data)
                            @if($key + 1 == count(file_breadcrumb($directory)))
                            <li class="breadcrumb-item active" aria-current="page">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                    <div class="btn-group">
                        <a href="{{ route('admin.folder.create', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Folder</a>
                        <a href="{{ route('admin.file.create', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-plus mr-2"></i> Tambah File</a>
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
                                            <a href="{{ image('assets/images/folder/'.$data->folder_icon, 'folder') }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Icon"><i class="fa fa-image"></i></a>
                                            <!-- <a href="#" class="btn btn-sm btn-success btn-move" data-id="{{ $data->id_folder }}" data-type="folder" data-toggle="tooltip" title="Pindah"><i class="fa fa-arrow-right"></i></a> -->
                                            <a href="{{ route('admin.folder.edit', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_folder, 'dir' => $directory->folder_dir]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete-folder" data-id="{{ $data->id_folder }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @foreach($files as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><i class="fa {{ $file_icon }} mr-1"></i><a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('admin.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">{{ $data->file_nama }}</a></td>
                                    <td></td>
                                    <td>
                                        <span class="d-none">{{ $data->file_up }}</span>
                                        {{ date('d/m/Y', strtotime($data->file_up)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->file_up)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ image('assets/images/file/'.$data->file_thumbnail, $data->tipe_kategori) }}" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Thumbnail"><i class="fa fa-image"></i></a>
                                            <a href="#" class="btn btn-sm btn-success btn-move" data-id="{{ $data->id_file }}" data-type="file" data-toggle="tooltip" title="Pindah"><i class="fa fa-arrow-right"></i></a>
                                            <a href="{{ route('admin.file.edit', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file, 'dir' => $directory->folder_dir]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete-file" data-id="{{ $data->id_file }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete-folder" class="d-none" method="post" action="{{ route('admin.folder.delete', ['kategori' => $kategori->slug_kategori]) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
                        <form id="form-delete-file" class="d-none" method="post" action="{{ route('admin.file.delete', ['kategori' => $kategori->slug_kategori]) }}">
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

@php

function loop_folder($folder){
    $html = '';
    $html .= '<ul class="list-group list-group-flush">';
    if(count($folder) > 0){
        foreach($folder as $key=>$data){
            $html .= '<li class="list-group-item btn-available-folder" data-id="'.$data['id'].'"><i class="fa fa-folder mr-2"></i>'.$data['nama'].'</li>';
            $html .= loop_folder($data['children']);
        }
    }
    $html .= '</ul>';

    return $html;
}

@endphp

<!-- Modal Pindah Folder -->
<div class="modal fade" id="modal-move" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pindahkan ke...</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-move" method="post" action="#">
                    {{ csrf_field() }}
                    <input type="hidden" name="id">
                    <input type="hidden" name="type">
                    <input type="hidden" name="destination">
                    <div class="available-folders">
                        {!! loop_folder($available_folders) !!}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn-submit-move" disabled>Pilih</button>
                <button type="button" class="btn btn-danger"data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Pindah Folder -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");

    // Button Move
    $(document).on("click", ".btn-move", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var type = $(this).data("type");
        $("#form-move input[name=id]").val(id);
        $("#form-move input[name=type]").val(type);
        $("#modal-move").modal("show");
    });
    
    // Button Click Available Folder
    $(document).on("click", ".btn-available-folder", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $(this).addClass("menu-btn-primary");
        $("#form-move input[name=destination]").val(id);
        $(".btn-available-folder").each(function(key,elem){
            var elemId = $(elem).data("id");
            if(elemId != id) $(elem).removeClass("menu-btn-primary");
        });
        $("#btn-submit-move").removeAttr("disabled");
    });

    // Button Submit Move
    $(document).on("click", "#btn-submit-move", function(e){
        var action = "";
        var type = $("#form-move input[name=type]").val();
        if(type == "file") action = "{{ route('admin.file.move', ['kategori' => $kategori->slug_kategori]) }}";
        else if(type == "folder") action = "{{ route('admin.folder.move', ['kategori' => $kategori->slug_kategori]) }}";
        $("#form-move").attr("action", action).submit();
    });

    // Close Modal Move
    $("#modal-move").on('hidden.bs.modal', function(e){
        $("#form-move input[name=id]").val(null);
        $("#form-move input[name=type]").val(null);
        $("#form-move input[name=destination]").val(null);
        $(".btn-available-folder").removeClass("menu-btn-primary");
        $("#btn-submit-move").attr("disabled","disabled");
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">
<style type="text/css">
    .available-folders ul li {padding: .5rem;}
    .available-folders ul li:hover {background-color: #eee; cursor: pointer;}
    .available-folders ul ul {padding-left: 1rem;}
    .available-folders .list-group-flush .list-group-item{border-radius: .25rem; border: unset;}
</style>

@endsection