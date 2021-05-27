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
                    
                    @if(count($kategori)>0)
                        <p><em>Drag (geser) konten di bawah ini untuk mengurutkan dari yang teratas sampai terbawah.</em></p>
                        <ul class="list-group sortable">
                            @foreach($kategori as $data)
                                <div class="list-group-item d-flex justify-content-between align-items-center sortable-item" data-id="{{ $data->id_fk }}">
                                    <div>
                                        <h5 class="mt-0">{{ $data->folder_kategori }}</h5>
                                        <p class="mb-1">
                                            <span class="badge badge-info">{{ ucfirst($data->tipe_kategori) }}</span>
                                            <span class="badge {{ $data->status_kategori == 1 ? 'badge-success' : 'badge-danger' }}">{{ $data->status_kategori == 1 ? 'Aktif' : 'Tidak Aktif' }}</span>
                                        </p>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.folder.kategori.edit', ['id' => $data->id_fk]) }}" class="btn btn-sm btn-warning" title="Edit" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" title="Hapus" data-id="{{ $data->id_fk }}" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.folder.kategori.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
                    @else
                        <div class="alert alert-danger text-center">Tidak ada data tersedia.</div>
                    @endif
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

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.folder.kategori.sort')])

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection