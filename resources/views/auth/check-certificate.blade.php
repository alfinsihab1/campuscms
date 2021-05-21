@extends('faturcms::auth.layout')

@section('title', 'Cek Sertifikat')

@section('content')

    <!-- Navbar -->
    <nav class="navbar navbar-light fixed-top bg-white shadow-sm justify-content-center">
      <a class="navbar-brand" href="{{ route('site.home') }}">
        <img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" class="img-fluid" width="200" alt="logo">
      </a>
    </nav>
    <!-- /Navbar -->

    <div class="main-wrapper mt-5 mt-lg-0">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="container">
                @if($member)
                    <div class="alert alert-success text-center p-5">Sertifikat ini telah <strong>RESMI</strong> terdaftar di {{ setting('site.name') }} dengan nomor seri <strong>{{ $member->kode_sertifikat }}</strong> atas nama <strong>{{ $member->nama_user }}</strong>.</div>
                @else
                    <div class="alert alert-danger text-center p-5">Sertifikat ini <strong>TIDAK TERDAFTAR</strong> di {{ setting('site.name') }}.</div>
                @endif
            </div>
        </div>
    </div>

@endsection