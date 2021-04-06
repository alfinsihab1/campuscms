@extends('faturcms::email.main')

@section('content')

	<strong>Hai,</strong>
	<br>
	Sekedar memberitahukan bahwa <strong>{{ $user->nama_user }}</strong> telah meminta pengambilan komisi sebesar <strong>Rp. {{ number_format($withdrawal->nominal,0,'.','.') }}</strong> dengan invoice <strong>{{ $withdrawal->inv_withdrawal }}</strong>.
	<br>
	Harap segera menanggapi permintaan tersebut. Terimakasih.

@endsection