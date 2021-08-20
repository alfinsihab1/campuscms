@extends('faturcms::template.admin.main')

@section('title', 'Statistik Berdasarkan Tanggal')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Berdasarkan Tanggal',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Berdasarkan Tanggal', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <form method="get" action="">
        <div class="row align-items-end">
            <div class="col-lg-3"><p class="font-weight-bold m-0">Pilih Tanggal</p></div>
            <div class="col-lg-3">
                <p class="m-0">Mulai</p>            
                <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text bg-warning"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" name="tanggal1" id="tanggal1" class="form-control form-control-sm" value="{{ $tanggal1 }}" readonly>
                </div>
            </div>
            <div class="col-lg-3">
                <p class="m-0">Akhir</p>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-warning"><i class="fa fa-calendar"></i></span>
                </div>
                <input type="text" name="tanggal2" id="tanggal2" class="form-control form-control-sm" value="{{ $tanggal2 }}" readonly>
                </div>
            </div>
            <div class="col-lg-3 text-right mt-3 mt-lg-0"><button class="btn btn-primary" type="submit">Terapkan</button></div>
        </div>
    </form>
    <hr>

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Kunjungan</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartKunjungan" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                </div>
				<div class="tile-footer p-0"></div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Ikut Pelatihan</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartIkutPelatihan" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                </div>
				<div class="tile-footer p-0"></div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Churn Rate</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartChurnRate" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                </div>
				<div class="tile-footer p-0"></div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Hari Kunjungan</h5>
                </div>
                <div class="tile-body">
                    <canvas id="chartHariKunjungan" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                </div>
                <div class="tile-footer p-0"></div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Jam Kunjungan</h5>
                </div>
                <div class="tile-body">
                    <canvas id="chartJamKunjungan" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                </div>
                <div class="tile-footer p-0"></div>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-chart')

<script src="{{ asset('templates/vali-admin/js/plugins/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        // Datepicker
        $("input[name=tanggal1], input[name=tanggal2]").datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true
        });
    });
</script>
<script type="text/javascript">
    var tanggal1 = "{{ $tanggal1 }}";
    var tanggal2 = "{{ $tanggal2 }}";

    $(function(){
        // Load chart kunjungan
        generate_chart("chartKunjungan", "{{ route('api.by-tanggal.kunjungan') }}");
        // Load chart ikut pelatihan
        generate_chart("chartIkutPelatihan", "{{ route('api.by-tanggal.ikut-pelatihan') }}");
        // Load chart churn rate
        generate_chart("chartChurnRate", "{{ route('api.by-tanggal.churn-rate') }}");
        // Load chart hari kunjungan
        generate_chart("chartHariKunjungan", "{{ route('api.by-tanggal.kunjungan-hari') }}");
        // Load chart jam kunjungan
        generate_chart("chartJamKunjungan", "{{ route('api.by-tanggal.kunjungan-jam') }}");
    });

    function generate_chart(selector, url){
        $.ajax({
            type: "get",
            url: url,
            data: {tanggal1: tanggal1, tanggal2: tanggal2},
            success: function(response){
                var chart = new ChartDoughnut(selector, response.data, 4);
                chart.init();
            }
        });
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection