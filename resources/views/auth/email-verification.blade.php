@extends('faturcms::auth.layout')

@section('title', 'Cek Email')

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
                @if($status == 1)
                    <div class="alert alert-success text-center p-5">Pengguna dengan email <strong>{{ $_GET['email'] }}</strong> sudah terverifikasi. Silahkan <a href="/login">Login disini</a>.</div>
                @elseif($status == 0)
                    <div class="alert alert-danger text-center p-5">Tidak ada pengguna yang terdaftar dengan email <strong>{{ $_GET['email'] }}</strong>. Pastikan Anda benar-benar mendaftar menggunakan email ini atau tidak.</div>
                @endif
            </div>
        </div>
    </div>

@endsection