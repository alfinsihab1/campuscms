@extends('faturcms::template.admin.main')

@section('title', 'Data Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('admin.pelatihan.index')],
            ['text' => 'Data Pelatihan', 'url' => '#'],
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
                        <a href="{{ route('admin.pelatihan.create') }}" class="btn btn-sm btn-theme-1"><i class="fa fa-plus mr-2"></i> Tambah Data</a>
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
                                    <th>Pelatihan</th>
                                    <th width="150">Trainer</th>
                                    <th width="80">Peserta</th>
                                    <th width="100">Waktu</th>
                                    <th width="80">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pelatihan as $data)
                                <tr>
                                    <td><input type="checkbox"></td>
                                    <td>
                                        <a href="{{ route('admin.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
                                        <br>
                                        <small><i class="fa fa-tag mr-1"></i>{{ $data->nomor_pelatihan }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.detail', ['id' => $data->id_user]) }}">{{ $data->nama_user }}</a>
                                        <br>
                                        <small><i class="fa fa-envelope mr-1"></i>{{ $data->email }}</small>
                                        <br>
                                        <small><i class="fa fa-phone mr-1"></i>{{ $data->nomor_hp }}</small>
                                    </td>
                                    <td><a href="{{ route('admin.pelatihan.participant', ['id' => $data->id_pelatihan]) }}" data-toggle="tooltip" title="Lihat Daftar Peserta">{{ number_format(count_peserta_pelatihan($data->id_pelatihan),0,'.','.') }} orang</a></td>
                                    <td>
                                        <span class="d-none">{{ $data->tanggal_pelatihan_from }}</span>
                                        {{ date('d/m/Y', strtotime($data->tanggal_pelatihan_from)) }}
                                        <br>
                                        <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->tanggal_pelatihan_from)) }} WIB</small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pelatihan.detail', ['id' => $data->id_pelatihan]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                            <a href="#" class="btn btn-sm btn-success btn-duplicate" data-id="{{ $data->id_pelatihan }}" data-toggle="tooltip" title="Duplikasi"><i class="fa fa-copy"></i></a>
                                            <a href="{{ route('admin.pelatihan.edit', ['id' => $data->id_pelatihan]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{ $data->id_pelatihan }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form id="form-delete" class="d-none" method="post" action="{{ route('admin.pelatihan.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="id">
                        </form>
                        <form id="form-duplicate" class="d-none" method="post" action="{{ route('admin.pelatihan.duplicate') }}">
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

    // Button Duplikasi
    $(document).on("click", ".btn-duplicate", function(e){
        e.preventDefault();
        var id = $(this).data("id");
        var ask = confirm("Anda yakin ingin menduplikasi data ini?");
        if(ask){
            $("#form-duplicate input[name=id]").val(id);
            $("#form-duplicate").submit();
        }
    });
</script>

@endsection