@extends('faturcms::template.admin.main')

@section('title', 'Data Email')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Email',
        'items' => [
            ['text' => 'Email', 'url' => route('admin.email.index')],
            ['text' => 'Data Email', 'url' => '#'],
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
                        <a href="{{ route('admin.email.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-pencil mr-2"></i> Tulis Pesan</a>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20"><input type="checkbox"></th>
                                    <th>Subjek</th>
                                    <th width="150">Pengirim</th>
                                    <th width="100">Waktu</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($email as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td><a href="{{ route('admin.email.detail', ['id' => $data->id_email]) }}">{{ $data->subject }}</a></td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td>
                                        <span class="d-none">{{ $data->sent_at }}</span>
                                        {{ date('d/m/Y', strtotime($data->sent_at)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->sent_at)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.email.detail', ['id' => $data->id_email]) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-id="{{ $data->id_email }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.email.delete') }}">
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