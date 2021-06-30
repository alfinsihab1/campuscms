@extends('faturcms::template.admin.main')

@section('title', 'Pelatihan Kamu')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pelatihan Kamu',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('member.pelatihan.index')],
            ['text' => 'Pelatihan Kamu', 'url' => '#'],
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
                    @if(Auth::user()->role == role('trainer'))
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
                                        <th width="80">Peserta</th>
                                        <th width="100">Waktu</th>
                                        <th width="60">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pelatihan as $data)
                                    <tr>
                                        <td><input type="checkbox"></td>
                                        <td>
                                            <a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
                                            <br>
                                            <small><i class="fa fa-tag mr-1"></i>{{ $data->nomor_pelatihan }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('member.pelatihan.participant', ['id' => $data->id_pelatihan]) }}" data-toggle="tooltip" title="Lihat Daftar Peserta">{{ number_format(count_peserta_pelatihan($data->id_pelatihan),0,'.','.') }} orang</a>
                                        </td>
                                        <td>
                                            <span class="d-none">{{ $data->tanggal_pelatihan_from }}</span>
                                            {{ date('d/m/Y', strtotime($data->tanggal_pelatihan_from)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->tanggal_pelatihan_from)) }} WIB</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('member.pelatihan.participant', ['id' => $data->id_pelatihan]) }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Lihat Peserta"><i class="fa fa-user"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(Auth::user()->role == role('student'))
                    <div class="alert alert-warning text-center mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Anda tidak login sebagai Trainer.</div>
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

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@endsection