@extends('faturcms::template.admin.main')

@section('title', 'Statistik Member')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Member',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Member', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Status</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartStatus" width="400" height="270"></canvas>
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
                    <h5>Jenis Kelamin</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartGender" width="400" height="270"></canvas>
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
                    <h5>Usia</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartAge" width="400" height="270"></canvas>
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

<script type="text/javascript">
    $(function(){
        // Load chart status
        generate_chart("chartStatus", "{{ route('api.member.status') }}");
        // Load chart gender
        generate_chart("chartGender", "{{ route('api.member.gender') }}");
        // Load chart age
        generate_chart("chartAge", "{{ route('api.member.age') }}");
    });

    function generate_chart(selector, url){
        $.ajax({
            type: "get",
            url: url,
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