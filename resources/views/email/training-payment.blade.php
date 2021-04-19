@extends('faturcms::email.main')

@section('content')

    <strong>Hai,</strong>
    <br>
    Sekedar memberitahukan bahwa <strong>{{ is_object($user) ? $user->nama_user : $user }}</strong> telah melakukan pembayaran atas pelatihan <strong>{{ $pelatihan->nama_pelatihan }}</strong> dengan biaya sebesar <strong>Rp {{ number_format($pelatihan->fee,0,'.','.') }}</strong>.
    <br>
    Kode Invoice Anda adalah: <strong>{{ $pelatihan->inv_pelatihan }}</strong>
    <br>
    <img id="komisi-proof" src="{{ asset('assets/images/fee-pelatihan/'.$pelatihan->fee_bukti) }}">
    <br>
    Harap segera memverifikasi pembayaran tersebut. Terimakasih.

@endsection