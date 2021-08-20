@extends('faturcms::template.admin.main')

@section('title', 'Data Refer')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Refer',
        'items' => [
            ['text' => 'User', 'url' => route('admin.user.index')],
            ['text' => 'Data Refer', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
                    </div>
                    @endif
                    <h5 class="mb-3">{{ $user->nama_user }}</h5>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Identitas User</th>
                                    <th width="70">Saldo</th>
                                    <th width="50">Status</th>
                                    <th width="90">Waktu Daftar</th>
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($refer as $user)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ $user->id_user == Auth::user()->id_user ? route('admin.profile') : route('admin.user.detail', ['id' => $user->id_user]) }}">{{ $user->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $user->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $user->nomor_hp }}</small>
                                    </td>
                                    <td>{{ $user->is_admin == 0 ? number_format($user->saldo,0,',',',') : '-' }}</td>
                                    <td><span class="badge badge-{{ $user->status == 1 ? 'success' : 'danger' }}">{{ status($user->status) }}</span></td>
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
</script>

@endsection