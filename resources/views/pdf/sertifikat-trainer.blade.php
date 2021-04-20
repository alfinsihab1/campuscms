<!DOCTYPE html>
<html>
<head>
	<title>Sertifikat Trainer Pelatihan</title>
	<link rel="shortcut icon" href="{{ asset('assets/images/icon/'.setting('site.icon')) }}">
	<style type="text/css">
		/* Font */
		@font-face {font-family: 'Lato-Regular'; src: url({{ asset('assets/fonts/Lato-Regular.ttf') }});}
		@font-face {font-family: 'Lato-Bold'; src: url({{ asset('assets/fonts/Lato-Bold.ttf') }});}
		@font-face {font-family: 'Lato-Bold-Italic'; src: url({{ asset('assets/fonts/Lato-Bold-Italic.ttf') }});}
		
		/* Page */
		@page {margin: 0px;}
		html {margin: 0px;}
		body {margin: 0px; font-family: 'Lato-Regular'; font-size: 18.5px; background-color: {{ setting('site.sertifikat.background_color') }};}
		
		/* Layout */
		#img-shape-1 {position: absolute; top: 0; left: 0;}
		#img-shape-1 img {height: 250px;}
		#img-shape-2 {position: absolute; bottom: 0; right: 0;}
		#img-shape-2 img {height: 250px;}
		#img-shape-3 {position: absolute; top: 0; right: 0;}
		#img-shape-3 img {height: 500px;}
		#logo {position: absolute; top: 40px; right: 40px;}
		#logo img {max-height: 90px;}
		
		/* Content Page 1 */
		#nomor-seri {font-size: 12px; position: absolute; top: 5px; left: 15px;}
		#text-sertifikat {font-family: 'Lato-Bold'; font-size: 66px; position: absolute; top: 145px; left: 88px; width: 950px; color: {{ setting('site.color.primary') }}; text-align: center; text-transform: uppercase;}
		#nomor-sertifikat {font-size: 29px; position: absolute; top: 242px; left: 88px; width: 950px; text-align: center;}
		#text-diberikan-kepada {font-family: 'Lato-Bold'; font-size: 23px; position: absolute; top: 302px; left: 88px; width: 950px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: 50px; position: absolute; top: 335px; left: 88px; width: 950px; text-align: center; text-decoration: underline;}
		#tipe {font-family: 'Lato-Bold'; font-size: 21px; position: absolute; top: 437px; left: 88px; width: 950px; text-align: center;}
		#deskripsi {position: absolute; top: 488px; left: 88px; width: 950px; line-height: 20px; text-align: center;}
		#judul {font-family: 'Lato-Bold';}
		#text-mengetahui {position: absolute; top: 575px; left: 88px;}
		#text-direktur {position: absolute; top: 597px; left: 88px;}
		#direktur {position: absolute; top: 705px; left: 88px;}
		#sign-direktur {position: absolute; top: 620px; left: 108px; max-height: 90px;}
		#tanggal {position: absolute; top: 575px; left: 790px;}
		#text-dosen {position: absolute; top: 597px; left: 790px;}
		#dosen {position: absolute; top: 705px; left: 790px;}
		#sign-dosen {position: absolute; top: 620px; left: 810px; max-height: 90px;}
		#line-1 {position: absolute; top: 708px; left: 85px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
		#line-2 {position: absolute; top: 708px; left: 787px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
	</style>
</head>
<body>
	<!-- Layout -->
	<div id="img-shape-1"><img src="{{ asset('assets/images/others/shape1.png') }}"></div>
	<div id="img-shape-2"><img src="{{ asset('assets/images/others/shape2.png') }}"></div>
	<div id="img-shape-3"><img src="{{ asset('assets/images/others/shape3.png') }}"></div>
	<div id="logo"><img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}"></div>
	
	<!-- Content Page 1 -->
	<div id="nomor-seri">Nomor Seri: {{ $pelatihan->kode_trainer }}</div>
	<div id="text-sertifikat">Sertifikat</div>
	<div id="nomor-sertifikat">Nomor: {{ $pelatihan->nomor_pelatihan }}</div>
	<div id="text-diberikan-kepada">Diberikan Kepada:</div>
	<div id="nama">{{ $pelatihan->nama_user}}</div>
	<div id="tipe">Sebagai Trainer</div>
	<div id="deskripsi">{{ $pelatihan->kategori }} dengan tema <span id="judul">"{{ $pelatihan->nama_pelatihan }}"</span>. <br>Diselenggarakan oleh {{ setting('site.name') }} pada tanggal {{ date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_from)) == date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_to)) ? generate_date($pelatihan->tanggal_sertifikat_to) : generate_date($pelatihan->tanggal_sertifikat_from).' sampai '.generate_date($pelatihan->tanggal_sertifikat_to) }}{{ $pelatihan->tempat_pelatihan != '' ? ' di '.$pelatihan->tempat_pelatihan : '' }}.</div>
	<div id="text-mengetahui">Mengetahui,</div>
	<div id="text-direktur">Direktur {{ setting('site.name') }}</div>
	<div id="direktur">{{ $direktur->nama_user }}</div>
	<img id="sign-direktur" src="{{ $signature_direktur ? asset('assets/images/signature/'.$signature_direktur->signature) : '' }}" style="display:{{ $signature_direktur ? 'block' : 'none' }};">
	<div id="tanggal">{{ setting('site.city') }}, {{ generate_date($pelatihan->tanggal_pelatihan_to) }}</div>
	<div id="text-dosen">Manager</div>
	<div id="dosen">{{ $dosen->nama_user }}</div>
	<img id="sign-dosen" src="{{ $signature_dosen ? asset('assets/images/signature/'.$signature_dosen->signature) : '' }}" style="display:{{ $signature_dosen ? 'block' : 'none' }};">
	<hr id="line-1">
	<hr id="line-2">
</body>
</html>