@extends('faturcms::template.admin.main')

@section('title', 'Data Artikel')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Artikel',
        'items' => [
            ['text' => 'Artikel', 'url' => route('admin.blog.index')],
            ['text' => 'Data Artikel', 'url' => '#'],
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
                        <a href="{{ route('admin.blog.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Judul Artikel</th>
                                    <th width="100">Kategori</th>
                                    <th width="150">Author / Kontributor</th>
                                    <th width="100">Waktu</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blog as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="/artikel/{{ $data->blog_permalink }}" target="_blank">{{ $data->blog_title }}</a>
                                    </td>
                                    <td>{{ $data->kategori }}</td>
                                    <td>
                                        @if($data->blog_kontributor == 0)
                                            <a href="{{ $data->id_user == Auth::user()->id_user ? route('admin.profile') : route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                            <br>
                                            <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                            <br>
                                            <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                        @else
                                            {{ $data->kontributor }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="d-none">{{ $data->blog_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->blog_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->blog_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/artikel/{{ $data->blog_permalink }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail" target="_blank"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.blog.edit', ['id' => $data->id_blog]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_blog }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.blog.delete') }}">
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