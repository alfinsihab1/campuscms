@extends('faturcms::template.admin.main')

@section('title', 'Top Visitor')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Top Visitor',
        'items' => [
            ['text' => 'Visitor', 'url' => route('admin.visitor.index')],
            ['text' => 'Top Visitor', 'url' => '#'],
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
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Identitas User</th>
                                    <th width="80">Role</th>
                                    <th width="50">Total</th>
                                    <th width="90">Kunjungan Terakhir</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>{{ role($data->role) }}</td>
                                    <td>{{ number_format(count_kunjungan($data->id_user, 'all'),0,',',',') }}</td>
                                    <td>
                                        <span class="d-none">{{ $data->last_visit }}</span>
                                        {{ date('d/m/Y', strtotime($data->last_visit)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->last_visit)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.log.activity', ['id' => $data->id_user]) }}" class="btn btn-sm btn-info" data-id="{{ $data->id_visitor }}" data-toggle="tooltip" title="Lihat Aktivitas"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
    generate_datatable("#dataTable").order([3, 'desc']).draw();
</script>

@endsection