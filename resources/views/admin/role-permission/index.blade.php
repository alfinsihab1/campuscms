@extends('faturcms::template.admin.main')

@section('title', 'Data Hak Akses')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Hak Akses',
        'items' => [
            ['text' => 'Hak Akses', 'url' => route('admin.rolepermission.index')],
            ['text' => 'Data Hak Akses', 'url' => '#'],
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
                        <a href="{{ route('admin.permission.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                        <p>Menampilkan <strong>{{ count($permissions) }}</strong> akses dan <strong>{{ count($roles) }}</strong> role.</p>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Akses</th>
                                    @foreach($roles as $role)
                                    <th width="50">{{ $role->nama_role }}</th>
                                    @endforeach
                                    <th width="60">Opsi</th>
                                </tr>
                            </thead>
                            <tbody class="sortable">
                                @foreach($permissions as $permission)
                                <tr class="sortable-item" data-id="{{ $permission->id_permission }}">
                                    <td>{{ $permission->nama_permission }}<br><span class="small text-muted">{{ $permission->key_permission }}</span></td>
                                    @foreach($roles as $role)
                                    <td><input class="checkbox" type="checkbox" data-permission="{{ $permission->id_permission }}" data-role="{{ $role->id_role }}" {{ has_access($permission->key_permission, $role->id_role, false) ? 'checked' : '' }}></td>
                                    @endforeach
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.permission.edit', ['id' => $permission->id_permission]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $permission->id_permission }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.permission.delete') }}">
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

<div class="toast" style="position: fixed; top: 65px; right: 15px; z-index: 9999; display: none;">
    <div class="card" style="background-color: var(--green-s); color: var(--green);">
        <div class="card-body font-weight-bold"></div>
    </div>
</div>

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-sortable', ['url' => route('admin.permission.sort')])

<script type="text/javascript">
    // Change Status
    $(document).on("change", ".checkbox", function(e){
        e.preventDefault();
        var permission = $(this).data("permission");
        var role = $(this).data("role");
        var access = $(this).prop("checked") == true ? 1 : 0;
        $.ajax({
            type: "post",
            url: "{{ route('admin.rolepermission.update') }}",
            data: {_token: "{{ csrf_token() }}", permission: permission, role: role, access: access},
            success: function(response){
                $(".toast").find(".card-body").text(response);
                $(".toast").fadeIn(500).delay(2000).fadeOut(500);
            }
        });
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .table tr th, .table tr td:not(:first-child) {text-align: center; vertical-align: middle;}
    .table tr th, .table tr td {padding: .5rem;}
</style>

@endsection