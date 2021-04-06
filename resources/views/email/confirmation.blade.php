@extends('faturcms::email.main')

@section('content')

	<strong>Hai,</strong>
	<br>
	Sekedar memberitahukan bahwa <strong>{{ $user->nama_user }}</strong> telah mendaftar di {{ setting('site.name') }} dan melakukan pembayaran dengan invoice <strong>{{ $komisi->inv_komisi }}</strong>.
	<br>
	<img id="komisi-proof" src="{{ asset('assets/images/komisi/'.$komisi->komisi_proof) }}">
	<br>
	Harap segera memverifikasi akun tersebut. Terimakasih.

@endsection