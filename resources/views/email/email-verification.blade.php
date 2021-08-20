@extends('faturcms::email.main')

@section('content')

    <strong>Yth {{ $user->nama_user }},</strong>
    <br>
    Selamat Datang di {{ setting('site.name') }}!
    <br>
    Pertama Anda harus melakukan verifikasi email Anda untuk dapat menuju ke tahap selanjutnya. Caranya tinggal <strong><a href="{{ URL::to('/verify?email='.$user->email) }}"  target="_blank">KLIK DISINI</a></strong>.

@endsection