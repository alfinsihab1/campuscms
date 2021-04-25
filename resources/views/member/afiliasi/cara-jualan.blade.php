@extends('faturcms::template.admin.main')

@section('title', 'Cara Jualan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Cara Jualan',
        'items' => [
            ['text' => 'Afiliasi', 'url' => '#'],
            ['text' => 'Cara Jualan', 'url' => '#'],
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
                    <!-- Link Referral -->
                    <div class="alert alert-warning text-center">
                        Link Referral:
                        <br>
                        <a class="h5" href="{{ URL::to('/') }}?ref={{ Auth::user()->username }}" target="_blank">{{ URL::to('/') }}?ref={{ Auth::user()->username }}</a>
                    </div>
                    <!-- /Link Referral -->
                    <div class="col-12 mt-4 text-center">
                        <p class="h6">Promosikan URL Referral Anda dan dapatkan Komisi Sponsor sebesar <strong class="text-danger">Rp. {{ Auth::user()->role == role('trainer') ? number_format(setting('site.komisi_trainer'),0,',','.') : number_format(setting('site.komisi_student'),0,',','.') }}</strong> setiap ada member baru yang bergabung melalui URL Anda. Tidak ada batasan jumlah member yang Anda sponsori, Anda bisa mensponsori puluhan, bahkan ratusan member.</p>
                    </div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                    <h5>Apa itu Referral?</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <p>Referral adalah seseorang yang kita ajak (refer) dimana mereka mendaftar ke salah satu situs yang kita tawarkan. Setiap PTC akan memberikan alat kepada anggota untuk mempromosikan situs mereka kepada orang lain. Ini dapat berupa text link (URL) atau banner yang tentunya menggunakan kode script.</p>
                    <p>Jika orang yang diajak mendaftar melalui URL referral, maka kita biasanya kita akan mendapatkan komisi. Disini, kami memberikan komisi berupa uang sebesar <strong class="text-danger">Rp. {{ Auth::user()->role == role('trainer') ? number_format(setting('site.komisi_trainer'),0,',','.') : number_format(setting('site.komisi_student'),0,',','.') }}</strong> setiap ada member baru yang bergabung melalui URL referral.</p>
                    <p class="mb-1">Berikut adalah tips sebelum memulai program referral:</p>
                    <ol>
                        <li>Pahami dan kuasai sistem produk secara baik.</li>
                        <li>Buatlah daftar calon prospek. Bisa dimulai dari orang terdekat Anda, atau bisa juga mitra Anda.</li>
                        <li>Promosikan URL Referral Anda melalui situs iklan baris, PPC (Pay-Per-Click), PTC (Pay-To-Click), atau situs-situs lain yang <em>trafficnya</em> tinggi.</li>
                    </ol>
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