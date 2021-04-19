@extends('faturcms::auth.layout')

@section('title', 'Lupa Password')

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
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="d-flex align-items-center h-100">
                            <img class="img-fluid" src="{{asset('assets/images/ilustrasi/undraw_Login_re_4vu2.svg')}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="wrapper">
                            <div class="card border-0 shadow-sm rounded-2">
                                <div class="card-header pt-4 bg-transparent text-left">
                                    <h5 class="h2">Lupa Password?</h5>
                                    <p class="m-0">Masukkan email Anda di bawah ini dan Kami akan mengirimi Anda instruksi untuk mengembalikan password Anda.</p>
                                </div>
                                <div class="card-body">
                                    <form class="login-form" action="{{ route('auth.postforgotpassword') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="referral" value="{{ $_GET['ref'] }}">
                                        @if(Session::get('message'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                                        <div class="form-group ">
                                            <label class="control-label">Email</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text {{ $errors->has('email') ? 'border-danger' : '' }}" id="basic-addon1"><i class="fa fa-envelope"></i></span>
                                                </div>
                                                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" type="email" placeholder="Email" autofocus>
                                            </div>
                                            @if($errors->has('email'))
                                            <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('email')) }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group btn-container">
                                            <button type="submit" class="btn btn-theme-1 btn-lg rounded px-4 shadow-sm btn-block">Recover</button>
                                            <a href="{{ route('auth.login') }}" class="btn btn-light btn-lg rounded px-4 shadow-sm btn-block">Kembali ke Login</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection