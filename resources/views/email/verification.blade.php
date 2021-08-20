@extends('faturcms::email.main')

@section('content')

	<strong>Yth {{ $user->nama_user }},</strong>
	<br>
	Selamat Datang di {{ setting('site.name') }}!
	<br>
	Akun Anda telah berhasil diverifikasi. Sekarang Anda sudah dapat menggunakan fasilitas dari kami. Caranya tinggal <strong><a href="{{ URL::to('/') }}"  target="_blank">KLIK DISINI</a></strong>.

@endsection