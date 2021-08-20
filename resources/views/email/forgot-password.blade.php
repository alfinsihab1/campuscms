@extends('faturcms::email.main')

@section('content')

	<strong>Yth {{ $user->nama_user }},</strong>
	<br>
	Anda telah berhasil melakukan recovery password.
	<br>
	Password baru Anda adalah: <strong>{{ $new_password }}</strong>

@endsection