<!DOCTYPE html>
<html dir="ltr">

<head>
    <title>Login | {{ setting('site.name') }} &#8211; {{ setting('site.tagline') }}</title>
    @include('faturcms::template.admin._head')
    <style type="text/css">
        body{ background-color: var(--light)}
        .auth-wrapper {height: calc(100vh)!important;}
        .auth-box {background-color: {{ setting('site.tertiary_color') }}!important; border-color: {{ setting('site.secondary_color') }}!important; margin: auto!important;}
		/*#loginform img {filter: brightness(0) invert(1);}*/
		#loginform img {max-width: 100%;}
        .input-group>.input-group-append:not(:last-child)>.input-group-text {border-top-right-radius: 2px; border-bottom-right-radius: 2px;}
        #btn-toggle-password {cursor: pointer;}
        .btn-theme-1{background-color: {{ setting('site.primary_color') }}; color: #fff; transition: .25s ease}
        .btn-theme-1:hover{filter: saturate(0.5);}
        .rounded{border-radius: .25em!important}
        .rounded-1{border-radius: .5em}
        .rounded-2{border-radius: 1em}
    </style>
</head>

<body>
    <div class="main-wrapper">
        @include('faturcms::template.admin._preloader')
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
<!--         <div class="auth-wrapper d-flex no-block justify-content-center align-items-center">
            <div class="auth-box border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><a href="/{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}"><img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" alt="logo" /></a></span>
                    </div>                    <form class="form-horizontal m-t-20" id="loginform" action="/login" method="post">
                        {{ csrf_field() }}
						@if(isset($message))
						<div class="alert alert-danger">
							{{ $message }}
						</div>
						@endif
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white {{ $errors->has('username') ? 'border-danger bg-danger' : 'bg-success' }}" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'border-danger' : '' }}" value="{{ old('username') }}" placeholder="Email atau Username" aria-label="Username" aria-describedby="basic-addon1">
                                    @if($errors->has('username'))
                                    <small class="form-row col-12 mt-1 text-danger">{{ ucfirst($errors->first('username')) }}</small>
                                    @endif
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white {{ $errors->has('password') ? 'border-danger bg-danger' : 'bg-success' }}" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <a href="#" class="input-group-text text-white {{ $errors->has('password') ? 'border-danger bg-danger' : 'bg-success' }}" id="btn-toggle-password"><i class="fa fa-eye"></i></a>
                                    </div>
                                    @if($errors->has('password'))
                                    <small class="form-row col-12 mt-1 text-danger">{{ ucfirst($errors->first('password')) }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-warning btn-block mb-3" type="submit">Login</button>
                                        <a class="btn btn-block btn-danger" href="/recovery-password">Lupa password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <p class="text-center text-white">Belum punya akun?</p>
                                        <a class="btn btn-block btn-primary" href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">Daftar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->

    <!-- Just an image -->
    <nav class="navbar navbar-light fixed-top bg-white shadow-sm justify-content-center">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/images/logo/'.setting('site.logo')) }}" class="img-fluid" width="200" alt="logo">
      </a>
    </nav>
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
                                    <h5 class="h2">Selamat Datang Kembali :)</h5>
                                    <p class="m-0">Untuk tetap terhubung dengan kami, silakan login dengan informasi pribadi Anda melalui email dan kata sandi 🔔</p>
                                </div>
                                <div class="card-body">
                                    <form class="login-form" action="{{ route('auth.postlogin') }}" method="post">
                                        {{ csrf_field() }}
                                        @if(isset($message))
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                        @endif
                                        <div class="form-group ">
                                            <label class="control-label">Username</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="ti-email"></i></span>
                                                </div>
                                                <input class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name="username" type="text" placeholder="Username" autofocus>
                                            </div>
                                            @if($errors->has('username'))
                                            <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('username')) }}</div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Password</label>
                                            <div class="input-group input-group-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="ti-key"></i></span>
                                                </div>
                                                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'border-danger' : '' }}" placeholder="Password">
                                                <div class="input-group-append">
                                                    <a href="#" class="input-group-text text-dark {{ $errors->has('password') ? 'border-danger bg-danger' : 'bg-theme-1' }}" id="btn-toggle-password"><i class="fa fa-eye"></i></a>
                                                </div>
                                            </div>
                                            @if($errors->has('password'))
                                            <div class="form-control-feedback text-danger">{{ ucfirst($errors->first('password')) }}</div>
                                            @endif
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                          <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Ingat Saya</label>
                                          </div>
                                          <div class="form-group">
                                            <a href="/recovery-password" class="text-body">Lupa Password?</a>
                                          </div>
                                        </div>
                                        <div class="form-group btn-container">
                                            <button type="submit" class="btn btn-theme-1 btn-lg rounded px-4 shadow-sm btn-block">Masuk</button>
                                            <a href="/register{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}" class="btn btn-light btn-lg rounded px-4 shadow-sm btn-block">Daftar</a>
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
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>

    $(".preloader").fadeOut();

    // Button toggle password
    $(document).on("click", "#btn-toggle-password", function(e){
        e.preventDefault();
        if(!$(this).hasClass("show")){
            $("input[name=password]").attr("type","text");
            $(this).find(".fa").removeClass("fa-eye").addClass("fa-eye-slash");
            $(this).addClass("show");
        }
        else{
            $("input[name=password]").attr("type","password");
            $(this).find(".fa").removeClass("fa-eye-slash").addClass("fa-eye");
            $(this).removeClass("show");
        }
    });
    </script>

</body>

</html>