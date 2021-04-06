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
                                    <th width="90">Waktu Daftar</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ $user->id_user == Auth::user()->id_user ? route('admin.profile') : route('admin.user.detail', ['id' => $user->id_user]) }}">{{ $user->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $user->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $user->nomor_hp }}</small>
                                    </td>
                                    <td>{{ $user->nama_role }}</td>
                                    <td>{{ $user->is_admin == 0 ? number_format($user->saldo,0,',',',') : '-' }}</td>
                                    <td>{{ $user->is_admin == 0 ? number_format(count_refer($user->username),0,',',',') : '-' }}</td>
                                    <td>
                                        <span class="d-none">{{ $user->register_at }}</span>
                                        {{ date('d/m/Y', strtotime($user->register_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($user->register_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.user.detail', ['id' => $user->id_user]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.user.edit', ['id' => $user->id_user]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger {{ $user->id_user > 6 ? 'btn-delete' : '' }}" data-id="{{ $user->id_user }}" style="{{ $user->id_user > 6 ? '' : 'cursor: not-allowed' }}" data-toggle="tooltip" title="{{ $user->id_user <= 6 ? $user->id_user == Auth::user()->id_user ? 'Tidak dapat menghapus akun sendiri' : 'Akun ini tidak boleh dihapus' : 'Hapus' }}"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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
    generate_datatable("#dataTable");

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