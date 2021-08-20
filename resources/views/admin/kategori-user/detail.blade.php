@extends('faturcms::template.admin.main')

@section('title', 'Detail Kategori User')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Kategori User',
        'items' => [
            ['text' => 'User', 'url' => route('admin.user.index')],
            ['text' => 'Kategori User', 'url' => route('admin.user.kategori.index')],
            ['text' => 'Detail Kategori User', 'url' => '#'],
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
                    <h5>Kategori: {{ $kategori->kategori }}</h5>
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
                                    <th width="70">Saldo</th>
                                    <th width="50">Refer</th>
                                    <th width="50">Status</th>
                                    <th width="90">Waktu Daftar</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ $data->id_user == Auth::user()->id_user ? route('admin.profile') : route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>{{ $data->is_admin == 0 ? number_format($data->saldo,0,',',',') : '-' }}</td>
                                    <td>
                                        @if($data->is_admin == 0)
                                            <a href="{{ route('admin.user.refer', ['id' => $data->id_user]) }}" data-toggle="tooltip" title="Lihat Data Refer">{{ number_format(count_refer($data->username),0,',',',') }}</a>
                                        @endif
                                    </td>
                                    <td><span class="badge {{ $data->status == 1 ? 'badge-success' : 'badge-danger' }}">{{ status($data->status) }}</span></td>
                                    <td>
                                        <span class="d-none">{{ $data->register_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->register_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->register_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
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
    generate_datatable("#dataTable");
</script>

@endsection