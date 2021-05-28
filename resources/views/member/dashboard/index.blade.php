@extends('faturcms::template.admin.main')

@section('title', 'Dashboard')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Dashboard',
        'items' => [
            ['text' => 'Dashboard', 'url' => '#']
        ]
    ]])
    <!-- /Breadcrumb -->

    @if(Auth::user()->status == 1)
    <div class="card mb-4">
        <div class="card-body">{{ $deskripsi->deskripsi }}</div>
    </div>
    @endif

    @if(Auth::user()->status == 1)
    <!-- User Aktif -->
    <!-- Row -->
    <div class="row">
        @if(Auth::user()->role == role('trainer') && !$signature)
        <!-- Signature -->
        <!-- Column -->
        <div class="col-lg-12">
            <div class="alert alert-danger text-center shadow">
                Anda merupakan {{ role(role('trainer')) }} tetapi belum mempunyai Tanda Tangan Digital. <a href="{{ route('member.signature.input') }}">Buat disini</a>.
            </div>
        </div>
        <!-- /Column -->
        <!-- /Signature -->
        @endif
        <!-- Column -->

        <!-- /Column -->
        <!-- Column -->
        <div class="col-md-12">
            <div class="row">
                @if(count($fitur)>0)
                    @foreach($fitur as $data)
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <a href="{{ URL::to('member/'.$data->url_fitur) }}">
                                        <img src="{{ image('assets/images/fitur/'.$data->gambar_fitur, 'fitur') }}" height="100" style="max-width: 100%;">
                                    </a>
                                    <p class="h6 mt-3 mb-0"><a href="{{ URL::to('member/'.$data->url_fitur) }}">{{ $data->nama_fitur }}</a></p>
                                    <p class="mt-2 mb-0">{{ $data->deskripsi_fitur }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    <!-- /User Aktif -->
    @endif

    @if(Auth::user()->status == 0 && Auth::user()->email_verified == 1)
    <!-- User Belum Aktif tapi Sudah Memverifikasi Email -->
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning text-center shadow">
                Email Anda sudah terverifikasi. Tahap selanjutnya adalah melakukan pembayaran.
            </div>
        </div>
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <h4 class="card-title">Aktivasi Akun Anda</h4>
                    <div class="m-t-20 m-b-20">
                        <div class="alert alert-info">Kode pembayaran Anda adalah <strong>{{ $komisi->inv_komisi }}</strong>. Kode ini akan digunakan saat Anda melakukan konfirmasi pembayaran.</div>
                        <p class="mb-1">Aktivasi akun Anda dengan melakukan pembayaran sejumlah <del>Rp {{ number_format(setting('site.harga_dicoret'),0,'.','.') }}</del> <strong>Rp {{ number_format($komisi->komisi_aktivasi,0,'.','.') }}</strong> ke rekening berikut:</p>
                        <ol>
                            @foreach($default_rekening as $data)
                            <li><strong>{{ $data->nama_platform }}</strong> dengan nomor rekening <strong>{{ $data->nomor }}</strong> a/n <strong>{{ $data->atas_nama }}</strong>.</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <h4 class="card-title">Anda Sudah Membayar?</h4>
                    <div class="m-t-20 m-b-20">
                        @if($komisi->komisi_proof == '')
                        <p>Jika Anda sudah membayar, segera lakukan konfirmasi pembayaran <a href="#" class="font-weight-bold btn-confirm">DISINI</a>.</p>
                        @else
                        <div class="alert alert-success">Anda sudah membayar dan melakukan konfirmasi pembayaran. Tunggu beberapa saat sampai pihak Admin memverifikasi konfirmasi pembayaran Anda.</div>
                        @endif
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    @endif

    @if(Auth::user()->status == 0 && Auth::user()->email_verified == 0)
    <!-- User Belum Aktif dan Belum Memverifikasi Email -->
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <div class="alert alert-warning text-center shadow">
                <i class="fa fa-exclamation-triangle mr-2"></i> Verifikasi email Anda untuk dapat menuju ke tahap berikutnya. <strong>Cek inbox email Anda atau juga di folder spam untuk melakukan verifikasi email.</strong>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    <!-- /User Belum Aktif dan Belum Memverifikasi Email -->
    @endif
</main>
<!-- /Main -->

@if(Auth::user()->status == 0 && Auth::user()->email_verified == 1)
<!-- Modal Konfirmasi -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-confirm" method="post" action="{{ route('member.komisi.confirm') }}" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Kode Pembayaran</label>
                            <input type="text" name="kode_pembayaran" class="form-control" value="{{ $komisi->inv_komisi }}" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label>Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <br>
                            <button type="button" class="btn btn-sm btn-info btn-browse-file mr-2"><i class="fa fa-folder-open mr-2"></i>Pilih File...</button>
                            <input type="file" id="file" name="foto" class="d-none" accept="image/*">
                            <br><br>
                            <img id="image" class="img-thumbnail d-none">
                        </div>
                        <input type="hidden" name="id_komisi">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" disabled>Konfirmasi</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Modal Konfirmasi -->
@endif

<!-- Modal Intro -->
<div class="modal fade" id="modal-intro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <img width="30" class="mr-3" src="{{asset('assets/images/icon/'.setting('site.icon'))}}">
                <h5 class="modal-title" id="exampleModalLabel">{{ count($popup)>0 && Auth::user()->status == 1 ? 'Informasi' : $deskripsi->judul_deskripsi }}</h5>
                <button type="button" class="close menu-btn-green" data-dismiss="modal" aria-label="Close" style="padding: .5em .7em; border-radius: .5em; margin-right: 0">
                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                @if(count($popup)>0 && Auth::user()->status == 1)
                <div class="owl-carousel owl-theme carousel-popup">
                    @foreach($popup as $data)
                        @if($data->popup_tipe == 1)
                        <div class="item">
                            <a href="#" title="{{ $data->popup_judul }}. Klik untuk info lebih lanjut">
                                <img src="{{ asset('assets/images/pop-up/'.$data->popup) }}" class="img-fluid">
                            </a>
                        </div>
                        @elseif($data->popup_tipe == 2)
                        <div class="item item-video">
                            <a class="owl-video" href="{{ $data->popup }}" title="{{ $data->popup_judul }}. Klik untuk info lebih lanjut"></a>
                        </div>
                        @endif
                    @endforeach
                </div>
                @else
                <p>{{ $deskripsi->deskripsi }}</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn menu-btn-red" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Intro -->

@endsection

@section('js-extra')

<script type="text/javascript" src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
    // Button Confirm
    $(document).on("click", ".btn-confirm", function(e){
        e.preventDefault();
        $("#modal-confirm").modal("show");
    });

    // Change file
    $(document).on("change", "#file", function(){
        change_file(this, "image", 2);
    });
</script>
@if(Auth::user()->status == 1)
<!-- <script type="text/javascript">
    $(window).on('load', function() {
        $('#modal-intro').modal('show');
    });
</script> -->
@endif
@if(count($popup)>0 && Auth::user()->status == 1)
<script type="text/javascript">
    var owl = $(".carousel-popup").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        items: 1,
        autoHeight: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        video: true,
    });
    owl.on('changed.owl.carousel', function(event) {
        if($(".owl-item.active iframe", this.$element).length > 0){
            $(".owl-item.active iframe", this.$element).remove();
        }
    });
    
    // Hide Modal Intro
    $('#modal-intro').on('hidden.bs.modal', function(){
        owl.trigger('destroy.owl.carousel');
    });
</script>
@endif
<script type="text/javascript">
const span = document.getElementById('clicktocopy');

span.onclick = function() {
  document.execCommand("copy");
}

span.addEventListener("copy", function(event) {
  event.preventDefault();
  if (event.clipboardData) {
    event.clipboardData.setData("text/plain", span.textContent);
    alert("Berhasil menyalin " + event.clipboardData.getData("text"))
    // console.log(event.clipboardData.getData("text"))
  }
});

</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
<style type="text/css">
    #modal-intro .modal-body {max-height: 70vh; overflow-y: auto;}
    .owl-nav {position: absolute; width: 100%; top: 45%;}
    .owl-carousel .owl-nav button.owl-prev {position: absolute; font-size: 30px; top: 0; left: -10px; width: 20px; background-color: var(--primary-light); color: var(--primary-dark);}
    .owl-carousel .owl-nav button.owl-next {position: absolute; font-size: 30px; top: 0; right: -10px; width: 20px; background-color: var(--primary-light); color: var(--primary-dark);}
    .owl-carousel .owl-nav button.owl-prev:hover, .owl-carousel .owl-nav button.owl-next:hover {background-color: var(--primary-dark); color: var(--primary-light);}
    .item-video, .item-video iframe {height: 400px;}
</style>

@endsection
