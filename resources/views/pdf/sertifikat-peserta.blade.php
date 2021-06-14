<!DOCTYPE html>
<html>
<head>
	<title>Sertifikat Peserta Pelatihan</title>
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
		.page-break {page-break-after: always;}
		
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
		#qr-code {position: absolute; top: 35px; left: 15px; display: none;}
		#nomor-seri {font-size: 12px; position: absolute; top: 5px; left: 15px;}
		#text-sertifikat {font-family: 'Lato-Bold'; font-size: 66px; position: absolute; top: 145px; left: 88px; width: 950px; color: {{ setting('site.color.primary') }}; text-align: center; text-transform: uppercase;}
		#nomor-sertifikat {font-size: 29px; position: absolute; top: 242px; left: 88px; width: 950px; text-align: center;}
		#text-diberikan-kepada {font-family: 'Lato-Bold'; font-size: 23px; position: absolute; top: 302px; left: 88px; width: 950px; text-align: center;}
		#nama {font-family: 'Lato-Bold-Italic'; font-size: 50px; position: absolute; top: 335px; left: 88px; width: 950px; text-align: center; text-decoration: underline;}
		#tipe {font-family: 'Lato-Bold'; font-size: 21px; position: absolute; top: 437px; left: 88px; width: 950px; text-align: center;}
		#deskripsi {position: absolute; top: 488px; left: 88px; width: 950px; line-height: 20px; text-align: center;}
		#judul {font-family: 'Lato-Bold';}
		#predikat {font-family: 'Lato-Bold'; font-size: 21px;}
		#text-mengetahui {position: absolute; top: 575px; left: 88px;}
		#text-direktur {position: absolute; top: 597px; left: 88px;}
		#direktur {position: absolute; top: 705px; left: 88px;}
		#sign-direktur {position: absolute; top: 620px; left: 108px; max-height: 90px;}
		#stempel {position: absolute; top: 620px; left: 48px; max-height: 90px;}
		#tanggal {position: absolute; top: 575px; left: 790px;}
		#text-dosen {position: absolute; top: 597px; left: 790px;}
		#dosen {position: absolute; top: 705px; left: 790px;}
		#sign-dosen {position: absolute; top: 620px; left: 810px; max-height: 90px;}
		#line-1 {position: absolute; top: 708px; left: 85px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
		#line-2 {position: absolute; top: 708px; left: 787px; width: 250px; border-color: #333; margin: 0; border-width: 1.25px;}
		
		/* Content Page 2 */
		#text-materi {font-family: 'Lato-Bold'; font-size: 24px; position: absolute; top: 70px; left: 88px; width: 950px; text-align: center; text-transform: uppercase;}
		#table {position: absolute; top: 140px; left: 88px; width: 950px;}
		#table table {width: 100%; border-collapse: collapse; font-size: 17px;}
		#table table td {padding: 0px 5px;}
		#table table thead td, #table table tfoot td {font-family: 'Lato-Bold'; border: 1px #333 solid;}
		#table table tbody tr td {border-left: 1px #333 solid; border-right: 1px #333 solid;}
		#tanggal-2 {position: absolute; top: 575px; left: 88px; width: 950px; text-align: center;}
		#div-sign {position: absolute; top: 620px; left: 88px; width: 950px; text-align: center;}
		#sign-trainer {max-height: 90px;}
		#stempel-2 {position: absolute; top: 620px; left: 415px; max-height: 90px;}
		#text-trainer {position: absolute; top: 597px; left: 88px; width: 950px; text-align: center;}
		#trainer {position: absolute; top: 705px; left: 88px; width: 950px; text-align: center;}
		#div-line {position: absolute; top: 695px; text-align: center;}
		#line {width: 250px; border-color: #333; border-width: 1.25px;}
	</style>
</head>
<body>
	
	@php
		if($member->status_pelatihan == 11)
			$status_pelatihan = 'A (Sangat Baik)';
		elseif($member->status_pelatihan == 12)
			$status_pelatihan = 'B (Baik)';
		elseif($member->status_pelatihan == 13)
			$status_pelatihan = 'C (Cukup)';
		else
			$status_pelatihan = '';
	@endphp
	
	<!-- Layout -->
	<div id="img-shape-1"><img src="{{ asset('assets/images/others/shape1.png') }}"></div>
	<div id="img-shape-2"><img src="{{ asset('assets/images/others/shape2.png') }}"></div>
	<div id="img-shape-3"><img src="{{ asset('assets/images/others/shape3.png') }}"></div>
	<div id="logo"><img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}"></div>
	
	<!-- Content Page 1 -->
	<div id="qr-code">
		<img width="80" src="data:image/png;base64, {!! $qrcode !!}">
	</div>
	<div id="nomor-seri">Nomor Seri: {{ $member->kode_sertifikat }}</div>
	<div id="text-sertifikat">Sertifikat</div>
	<div id="nomor-sertifikat">Nomor: {{ $pelatihan->nomor_pelatihan }}</div>
	<div id="text-diberikan-kepada">Diberikan Kepada:</div>
	<div id="nama">{{ $member->nama_user}}</div>
	<div id="tipe">Sebagai Peserta</div>
	<div id="deskripsi">
		{{ $pelatihan->kategori }} dengan tema <span id="judul">"{{ $pelatihan->nama_pelatihan }}"</span>.
		<br>
		Diselenggarakan oleh {{ setting('site.name') }} pada tanggal {{ date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_from)) == date('Y-m-d', strtotime($pelatihan->tanggal_sertifikat_to)) ? generate_date($pelatihan->tanggal_sertifikat_to) : generate_date($pelatihan->tanggal_sertifikat_from).' sampai '.generate_date($pelatihan->tanggal_sertifikat_to) }}{{ $pelatihan->tempat_pelatihan != '' ? ' di '.$pelatihan->tempat_pelatihan : '' }}{{ $status_pelatihan == '' ? '.' : ',' }}
		@if($status_pelatihan != '')
			<br>
			dengan predikat:
			<span id="predikat">{{ $status_pelatihan }}</span>
		@endif
	</div>
	<div id="text-mengetahui">Mengetahui,</div>
	<div id="text-direktur">Direktur {{ setting('site.name') }}</div>
	<div id="direktur">{{ $direktur->nama_user }}</div>
	<img id="sign-direktur" src="{{ $signature_direktur ? asset('assets/images/signature/'.$signature_direktur->signature) : '' }}" style="display:{{ $signature_direktur ? 'block' : 'none' }};">
	<!-- <img id="stempel" src="{{ asset('assets/images/others/stempel.png') }}"> -->
	<div id="tanggal">{{ setting('site.city') }}, {{ generate_date($pelatihan->tanggal_pelatihan_to) }}</div>
	<div id="text-dosen">Manager</div>
	<div id="dosen">{{ $dosen->nama_user }}</div>
	<img id="sign-dosen" src="{{ $signature_dosen ? asset('assets/images/signature/'.$signature_dosen->signature) : '' }}" style="display:{{ $signature_dosen ? 'block' : 'none' }};">
	<hr id="line-1">
	<hr id="line-2">
	
	@if(count($pelatihan->materi_pelatihan)>0)
	<!-- Page Break -->
	<div class="page-break"></div>
	
	<!-- Layout -->
	<div id="img-shape-1"><img src="{{ asset('assets/images/others/shape1.png') }}"></div>
	<div id="img-shape-2"><img src="{{ asset('assets/images/others/shape2.png') }}"></div>
	<div id="img-shape-3"><img src="{{ asset('assets/images/others/shape3.png') }}"></div>
	
	<!-- Content Page 2 -->
	<div id="nomor-seri">Nomor Seri: {{ $member->kode_sertifikat }}</div>
	<div id="text-materi">Materi {{ $pelatihan->kategori }}</div>
	<div id="table">
		<table>
			<thead>
				<tr>
					<td align="center">No.</td>
					<td align="center">Kode Unit Kompetensi</td>
					<td>Judul Unit Kompetensi</td>
					<td align="center">Durasi (JP)</td>
				</tr>
			</thead>
			<tbody>
				@foreach($pelatihan->materi_pelatihan as $key=>$materi)
				<tr>
					<td align="center">{{ ($key+1) }}.</td>
					<td align="center">{{ $materi['kode'] }}</td>
					<td>{{ $materi['judul'] }}</td>
					<td align="center">{{ $materi['durasi'] }} Jam</td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td align="center" colspan="3">TOTAL WAKTU</td>
					<td align="center">{{ $pelatihan->total_jam_pelatihan }} Jam</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div id="tanggal-2">{{ setting('site.city') }}, {{ generate_date($pelatihan->tanggal_sertifikat_to) }}</div>
	<div id="text-trainer">Trainer</div>
	<div id="div-sign">
		<img id="sign-trainer" src="{{ $signature_trainer ? asset('assets/images/signature/'.$signature_trainer->signature) : '' }}" style="display:{{ $signature_trainer ? 'block' : 'none' }};">
	</div>
	<!-- <img id="stempel-2" src="{{ asset('assets/images/others/stempel.png') }}"> -->
	<div id="trainer">{{ $pelatihan->nama_user }}</div>
	<div id="div-line"><hr id="line"></div>
	@endif
</body>
</html>