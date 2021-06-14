@extends('faturcms::template.admin.main')

@section('title', 'Detail Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('admin.pelatihan.index')],
            ['text' => 'Detail Pelatihan', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="text-center">
                        <img src="{{ image('assets/images/pelatihan/'.$pelatihan->gambar_pelatihan, 'pelatihan') }}" class="img-fluid">
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-9">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Nama Pelatihan:</div>
                            <div>{{ $pelatihan->nama_pelatihan }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Nomor:</div>
                            <div>{{ $pelatihan->nomor_pelatihan }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Kategori:</div>
                            <div>{{ kategori_pelatihan($pelatihan->kategori_pelatihan) }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Trainer:</div>
                            <div><a href="{{ route('admin.user.detail', ['id' => $pelatihan->id_user]) }}">{{ $pelatihan->nama_user }}</a></div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Tempat:</div>
                            <div>{{ $pelatihan->tempat_pelatihan != '' ? $pelatihan->tempat_pelatihan : '-' }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Waktu:</div>
                            <div>{{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['from'] }} s.d. {{ generate_date_range('join', $pelatihan->tanggal_pelatihan_from.' - '.$pelatihan->tanggal_pelatihan_to)['to'] }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Biaya:</div>
                            <div>{{ $pelatihan->fee_member != 0 ? 'Rp '.number_format($pelatihan->fee_member,0,'.','.') : 'Gratis' }}</div>
                        </div>
                        <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                            <div class="font-weight-bold">Jumlah Peserta:</div>
                            <div><a href="{{ route('admin.pelatihan.participant', ['id' => $pelatihan->id_pelatihan]) }}">{{ count_peserta_pelatihan($pelatihan->id_pelatihan) }} orang</a></div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong>Deskripsi:</strong>
                        <div class="ql-snow"><div class="ql-editor p-0">{!! html_entity_decode($pelatihan->deskripsi_pelatihan) !!}</div></div>
                    </div>
                    @if(count($pelatihan->materi_pelatihan)>0)
                    <div class="mt-3">
                        <strong>Materi:</strong>
                        <div class="list-group list-group-flush">
                            @foreach($pelatihan->materi_pelatihan as $data)
                            <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                                <span>{{ $data['kode'] }}</span>
                                <span>{{ $data['judul'] }}</span>
                                <span>{{ $data['durasi'] }} Jam</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
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

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">

@endsection