@extends('faturcms::template.admin.main')

@section('title', 'Detail Pelatihan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Pelatihan',
        'items' => [
            ['text' => 'Pelatihan', 'url' => route('member.pelatihan.index')],
            ['text' => 'Detail Pelatihan', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    @if($pelatihan->trainer != Auth::user()->id_user && $cek_pelatihan)
    <!-- Message -->
        @if($cek_pelatihan->fee_status == 1)
        <div class="alert alert-success text-center"><i class="fa fa-check mr-2"></i>Anda Sudah Terdaftar dalam Pelatihan ini.</div>
        @else
        <div class="alert alert-warning text-center"><i class="fa fa-clock-o mr-2"></i>Sedang Menunggu Pembayaran Anda Diverifikasi oleh Admin.</div>
        @endif
    <!-- </div> -->
    @endif

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3">
            @if($pelatihan->trainer != Auth::user()->id_user && !$cek_pelatihan)
                <a href="#" class="btn btn-sm btn-block btn-info btn-register-pelatihan mb-3"><i class="fa fa-pencil mr-2"></i>Daftar Sekarang</a>
            @endif
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
                            <div><a href="{{ route('member.user.trainer', ['id' => $pelatihan->trainer ]) }}">{{ $pelatihan->nama_user }}</a></div>
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

<!-- Modal Daftar Pelatihan -->
<div class="modal fade" id="modal-register-pelatihan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-register" method="post" action="{{ route('member.pelatihan.register') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center mb-3">
                            <p class="h5">Biaya Pendaftaran:</p>
                            <p class="h1 text-success">{{ $pelatihan->fee_member > 0 ? 'Rp '.number_format($pelatihan->fee_member,0,'.','.') : 'Gratis!' }}</p>
                        </div>
                    </div>
                    @if($pelatihan->fee_member > 0)
                    <div class="alert alert-warning mb-4">
                        <p class="mb-0">Anda bisa membayarnya di rekening berikut:</p>
                        <ol style="padding-left: 1rem;">
                            @foreach($default_rekening as $data)
                            <li><strong>{{ $data->nama_platform }}</strong> dengan nomor rekening <strong>{{ $data->nomor }}</strong> a/n <strong>{{ $data->atas_nama }}</strong>.</li>
                            @endforeach
                        </ol>
                    </div>
                    @endif
                    <div class="form">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $pelatihan->id_pelatihan }}">
                        <input type="hidden" name="fee" value="{{ $pelatihan->fee_member }}">
                        <input type="file" name="foto" id="file" class="d-none" accept="image/*">
                        <div class="form-group {{ $pelatihan->fee_member > 0 ? '' : 'd-none' }}">
                            <label>Invoice:</label>
                            <input type="text" name="inv_pelatihan" class="form-control " value="{{ $invoice }}" readonly>
                        </div>
                        @if($pelatihan->fee_member > 0)
                        <div class="form-group mb-0">
                            <button type="button" class="btn btn-sm btn-block btn-info btn-browse-file mr-2"><i class="fa fa-upload mr-2"></i>Upload Bukti Pembayaran</button>
                            <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                            <img id="image" class="img-thumbnail mt-2 d-none">
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-block" {{ $pelatihan->fee_member > 0 ? 'disabled' : '' }}><i class="fa fa-pencil mr-2"></i>Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal Daftar Pelatihan -->

@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Daftar Pelatihan
    $(document).on("click", ".btn-register-pelatihan", function(e){
        e.preventDefault();
        $("#modal-register-pelatihan").modal("show");
    });

    // Change file
    $(document).on("change", "#file", function(){
        change_file(this, "image", 2);
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/quill/quill.snow.css') }}">

@endsection