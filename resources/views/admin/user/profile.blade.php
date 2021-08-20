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
                    <a class="btn btn-sm btn-primary mb-3" href="{{ route('admin.profile.edit') }}"><i class="fa fa-edit mr-1"></i>Edit Profil</a>
                    <div class="list-group list-group-flush">
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
                            <div><a href="{{ $sponsor ? route('admin.user.detail', ['id' => $sponsor->id_user]) : '' }}">{{ $sponsor ? $sponsor->nama_user : '' }}</a></div>
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
</main>
<!-- /Main -->

@include('faturcms::template.admin._modal-image', ['croppieWidth' => 300, 'croppieHeight' => 300])

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-image', ['imageType' => 'user', 'croppieWidth' => 300, 'croppieHeight' => 300, 'id' => $id_direct])

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/croppie/croppie.css') }}">

@endsection