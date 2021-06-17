@extends('faturcms::template.admin.main')

@section('title', 'Data User')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data User',
        'items' => [
            ['text' => 'User', 'url' => route('admin.user.index')],
            ['text' => 'Data User', 'url' => '#'],
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
                        <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
                        <a href="{{ route('admin.user.export', ['filter' => $filter]) }}" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-2"></i> Export ke Excel</a>
                    </div>
                    <div>
                        <select id="filter" class="form-control form-control-sm">
                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>Semua</option>
                            <option value="admin" {{ $filter == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ $filter == 'member' ? 'selected' : '' }}>Member</option>
                            <option value="aktif" {{ $filter == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="belum-aktif" {{ $filter == 'belum-aktif' ? 'selected' : '' }}>Belum Aktif</option>
                        </select>
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
                                    <th width="80">Role</th>
                                    <th width="70">Saldo</th>
                                    <th width="50">Refer</th>
                                    <th width="50">Status</th>
                                    <th width="90">Waktu Daftar</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.user.delete') }}">
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
    generate_datatable("#dataTable", {
		"url": "{{ route('admin.user.data', ['filter' => $filter]) }}",
        "columns": [
            {data: 'checkbox', name: 'checkbox'},
            {data: 'user_identity', name: 'user_identity'},
            {data: 'nama_role', name: 'nama_role'},
            {data: 'saldo', name: 'saldo'},
            {data: 'refer', name: 'refer'},
            {data: 'status', name: 'status'},
            {data: 'register_at', name: 'register_at'},
            {data: 'options', name: 'options'},
        ],
        "order": [6, 'desc']
	});

    // Filter
    $(document).on("change", "#filter", function(){
        var value = $(this).val();
        if(value == 'all') window.location.href = "{{ route('admin.user.index', ['filter' => 'all']) }}";
        else if(value == 'admin') window.location.href = "{{ route('admin.user.index', ['filter' => 'admin']) }}";
        else if(value == 'member') window.location.href = "{{ route('admin.user.index', ['filter' => 'member']) }}";
        else if(value == 'aktif') window.location.href = "{{ route('admin.user.index', ['filter' => 'aktif']) }}";
        else if(value == 'belum-aktif') window.location.href = "{{ route('admin.user.index', ['filter' => 'belum-aktif']) }}";
    });
</script>

@endsection