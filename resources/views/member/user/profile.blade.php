@extends('faturcms::template.admin.main')

@section('title', 'Profil')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Profil',
        'items' => [
            ['text' => 'Profil', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3">
            @if($user->is_admin == 0)
            <!-- Saldo -->
            <div class="alert alert-success text-center">
                Saldo:
                <br>
                <p class="h5 mb-0">Rp {{ number_format($user->saldo,0,'.','.') }}</p>
            </div>
            <!-- /Saldo -->
            @endif
            <!-- Tile -->
            <div class="tile mb-3">
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="text-center">
                        <a href="#" class="btn-image">
                            <img src="{{ image('assets/images/user/'.$user->foto, 'user') }}" class="img-fluid rounded-circle" height="175" width="175">
                        </a>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-9">
            @if($user->is_admin == 0)
            <!-- Link Referral -->
            <div class="alert alert-warning text-center">
                Link Referral:
                <br>
                <a class="h5" href="{{ URL::to('/') }}?ref={{ $user->username }}" target="_blank">{{ URL::to('/') }}?ref={{ $user->username }}</a>
            </div>
            <!-- /Link Referral -->
            @endif
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <a class="btn btn-sm btn-primary" href="{{ route('member.profile.edit') }}"><i class="fa fa-edit mr-1"></i>Edit Profil</a>
                    <div class="list-group list-group-flush mt-3">
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Nama:</div>
                            <div>{{ $user->nama_user }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Tanggal Lahir:</div>
                            <div>{{ generate_date($user->tanggal_lahir) }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Jenis Kelamin:</div>
                            <div>{{ gender($user->jenis_kelamin) }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Nomor HP:</div>
                            <div>{{ $user->nomor_hp }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Username:</div>
                            <div>{{ $user->username }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Email:</div>
                            <div>{{ $user->email }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Profesi:</div>
                            <div>{{ $user->kategori }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Role:</div>
                            <div>{{ $user->nama_role }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Status:</div>
                            <div>
                                @if($user->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($user->status == 0 && $user->email_verified == 1)
                                    <span class="badge badge-warning">Belum Aktif</span>
                                @elseif($user->status == 0 && $user->email_verified == 0)
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        @if($user->is_admin == 0)
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Sponsor:</div>
                            <div>{{ $sponsor ? $sponsor->nama_user : '' }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Refer:</div>
                            <div>{{ count_refer($user->username) }} orang</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Refer Aktif:</div>
                            <div>{{ count_refer_aktif($user->username) }} orang</div>
                        </div>
                        @endif
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Kunjungan Terakhir:</div>
                            <div>{{ generate_date_time($user->last_visit) }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Mendaftar:</div>
                            <div>{{ generate_date_time($user->register_at) }}</div>
                        </div>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                    <h5>Pelatihan yang Diikuti</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="40">No.</th>
                                    <th width="100">Waktu</th>
                                    <th>Pelatihan</th>
                                    <th width="60">Status</th>
                                    <th width="40">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($pelatihan)>0)
                                    @php $i = 1; @endphp
                                    @foreach($pelatihan as $data)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <span class="d-none">{{ $data->tanggal_pelatihan_from }}</span>
                                            {{ date('d/m/Y', strtotime($data->tanggal_pelatihan_from)) }}
                                            <br>
                                            <small><i class="fa fa-clock-o mr-1"></i>{{ date('H:i', strtotime($data->tanggal_pelatihan_from)) }} WIB</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('member.pelatihan.detail', ['id' => $data->id_pelatihan]) }}">{{ $data->nama_pelatihan }}</a>
                                            <br>
                                            <small><i class="fa fa-tag mr-1"></i>{{ $data->nomor_pelatihan }}</small>
                                        </td>
                                        <td><span class="badge {{ $data->status_pelatihan == 0 ? 'badge-danger' : 'badge-success' }}">{{ $data->status_pelatihan == 0 ? 'Belum Lulus' : 'Lulus' }}</span></td>
                                        <td>
                                            @if($data->status_pelatihan != 0)
                                            <div class="btn-group">
                                                <a href="{{ route('member.sertifikat.peserta.detail', ['id' => $data->id_pm]) }}" target="_blank" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                @endif
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

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 300, 'croppieHeight' => 300])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-table')

<script type="text/javascript">
    // DataTable
    generate_datatable("#dataTable");
</script>

@include('faturcms::template.admin._js-image', ['imageType' => 'user', 'croppieWidth' => 300, 'croppieHeight' => 300, 'id' => $id_direct])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection