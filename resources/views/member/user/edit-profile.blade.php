@extends('faturcms::template.admin.main')

@section('title', 'Edit Profil')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Edit Profil',
        'items' => [
            ['text' => 'Profil', 'url' => route('member.profile')],
            ['text' => 'Edit Profil', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                    <div class="alert alert-dismissible alert-success">
                        <button class="close" type="button" data-dismiss="alert">×</button>{{ Session::get('message') }}
                    </div>
                    @endif
                    <form id="form" method="post" action="{{ route('member.profile.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id_user }}">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nama <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nama_user" class="form-control {{ $errors->has('nama_user') ? 'is-invalid' : '' }}" value="{{ $user->nama_user }}">
                                @if($errors->has('nama_user'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nama_user')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="tanggal_lahir" class="form-control {{ $errors->has('tanggal_lahir') ? 'border-danger' : '' }}" value="{{ generate_date_format($user->tanggal_lahir, 'd/m/y') }}" placeholder="Format: dd/mm/yyyy">
                                @if($errors->has('tanggal_lahir'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('tanggal_lahir')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender-1" value="L" {{ $user->jenis_kelamin == 'L' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="gender-1">{{ gender('L') }}</label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="jenis_kelamin" id="gender-2" value="P" {{ $user->jenis_kelamin == 'P' ? 'checked' : '' }}>
                                  <label class="form-check-label" for="gender-2">{{ gender('P') }}</label>
                                </div>
                                @if($errors->has('jenis_kelamin'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('jenis_kelamin')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nomor HP <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="text" name="nomor_hp" class="form-control {{ $errors->has('nomor_hp') ? 'border-danger' : '' }}" value="{{ $user->nomor_hp }}">
                                @if($errors->has('nomor_hp'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('nomor_hp')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ $user->email }}" disabled>
                                @if($errors->has('email'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('email')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Password</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                                    <div class="input-group-append">
                                        <a href="#" class="input-group-text btn btn-toggle-password {{ $errors->has('password') ? 'border-danger' : '' }}"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="small text-muted mt-1">Kosongi saja jika tidak ingin mengganti password.</div> 
                                @if($errors->has('password'))
                                <div class="small text-danger mt-1">{{ ucfirst($errors->first('password')) }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-theme-1"><i class="fa fa-save mr-2"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection

@section('js-extra')

<script src="{{ asset('templates/vali-admin/js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    // Datepicker
    $(document).ready(function(){
        $("input[name=tanggal_lahir]").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
	#foto-profil {display: none; max-width: 300px;}
</style>

@endsection