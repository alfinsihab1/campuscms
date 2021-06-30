@extends('faturcms::template.admin.main')

@section('title', 'Statistik Berdasarkan Kelompok')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Berdasarkan Kelompok',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Berdasarkan Kelompok', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <form method="get" action="" id="form-filter">
        <div class="row align-items-end">
            <div class="col-lg-3">
                <p class="m-0">Kelompok</p>
                <select class="form-control form-control-sm" name="kelompok">
                    <option value="" disabled selected>--Pilih--</option>
                    @if(count($kelompok)>0)
                        @foreach($kelompok as $data)
                        <option value="{{ $data->id_kelompok }}" {{ $check ? $_GET['kelompok'] == $data->id_kelompok ? 'selected' : '' : '' }}>{{ $data->nama_kelompok }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-lg-3">
                <p class="m-0">User</p>
                <select class="form-control form-control-sm" name="user">
                    <option value="" disabled selected>--Pilih--</option>
                </select>
            </div>
            <div class="col-lg-3">
                <p class="m-0">Pelatihan</p>
                <select class="form-control form-control-sm" name="pelatihan">
                    <option value="" disabled selected>--Pilih--</option>
                </select>
            </div>
            <div class="col-lg-3 text-right mt-3 mt-lg-0"><button class="btn btn-primary" type="submit" {{ $check ? '' : 'disabled' }}>Terapkan</button></div>
        </div>
    </form>
    <hr>

    @if($check)
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-6 col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Login</h5>
                </div>
                <div class="tile-body">
                    <canvas id="chartLogin" width="400" height="270"></canvas>
                </div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-6 col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Aktivitas</h5>
                </div>
                <div class="tile-body">
                    <canvas id="chartAktivitas" width="400" height="270"></canvas>
                </div>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
    @endif

</main>
<!-- /Main -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-chart')

@if($check)

<script type="text/javascript">
    $(document).ready(function(){
        get_user_by_kelompok("{{ $_GET['kelompok'] }}", "{{ $_GET['user'] }}");
        get_pelatihan_by_user("{{ $_GET['user'] }}", "{{ $_GET['pelatihan'] }}");
        chart_login("{{ $_GET['pelatihan'] }}");
        chart_aktivitas("{{ $_GET['user'] }}", "{{ $_GET['pelatihan'] }}");
    });
</script>

@endif

<script type="text/javascript">
    // Change Kelompok
    $(document).on("change", "select[name=kelompok]", function(){
        get_user_by_kelompok($(this).val());
    });

    // Change User
    $(document).on("change", "select[name=user]", function(){
        get_pelatihan_by_user($(this).val());
    });

    // Change Pelatihan
    $(document).on("change", "select[name=pelatihan]", function(){
        $("#form-filter").find("button[type=submit]").removeAttr("disabled");
    });

    // Function get user by kelompok
    function get_user_by_kelompok(id, selectedData = ''){
        $.ajax({
            type: "get",
            url: "{{ route('api.get.user-by-kelompok') }}",
            data: {id: id},
            success: function(response){
                var html = '<option value="" disabled selected>--Pilih--</option>';
                $(response.data).each(function(key,data){
                    if(selectedData == data.id_user)
                        html += '<option value="' + data.id_user + '" selected>' + data.nama_user + '</option>';
                    else
                        html += '<option value="' + data.id_user + '">' + data.nama_user + '</option>';
                });
                $("select[name=user]").html(html);
                if(selectedData == '') $("#form-filter").find("button[type=submit]").attr("disabled","disabled");
            }
        });
    }

    // Function get pelatihan by user
    function get_pelatihan_by_user(id, selectedData = ''){
        $.ajax({
            type: "get",
            url: "{{ route('api.get.pelatihan-by-user') }}",
            data: {id: id},
            success: function(response){
                var html = '<option value="" disabled selected>--Pilih--</option>';
                $(response.data).each(function(key,data){
                    if(selectedData == data.id_pelatihan)
                        html += '<option value="' + data.id_pelatihan + '" selected>' + data.nama_pelatihan + '</option>';
                    else
                        html += '<option value="' + data.id_pelatihan + '">' + data.nama_pelatihan + '</option>';
                });
                $("select[name=pelatihan]").html(html);
                if(selectedData == '') $("#form-filter").find("button[type=submit]").attr("disabled","disabled");
            }
        });
    }

    // Chart login
    function chart_login(id_pm){
        $.ajax({
            type: "get",
            url: "{{ route('api.by-kelompok.login') }}",
            data: {id: id_pm},
            success: function(response){
                var chart = new ChartBar("chartLogin", response.data, false);
                chart.init();
            }
        });
    }

    // Chart aktivitas
    function chart_aktivitas(user, pelatihan){
        $.ajax({
            type: "get",
            url: "{{ route('api.by-kelompok.aktivitas') }}",
            data: {user: user, pelatihan: pelatihan},
            success: function(response){
                var chart = new ChartBar("chartAktivitas", response.data, false);
                chart.init();
            }
        });
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection