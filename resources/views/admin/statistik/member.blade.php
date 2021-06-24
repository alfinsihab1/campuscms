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
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-status">0</strong></p>
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
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-gender">0</strong></p>
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
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-age">0</strong></p>
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
        $.ajax({
            type: "get",
            url: "{{ route('api.member.status') }}",
            success: function(response){
				var colors = ["#28a745", "#dc3545"];
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartStatus", data);
				generate_chart_legend(colors, response.data, "#chartStatus");
                $("#total-status").text(thousand_format(response.data.total));
            }
        });

        // Load chart jenis kelamin
        $.ajax({
            type: "get",
            url: "{{ route('api.member.gender') }}",
            success: function(response){
				var colors = ["#007bff", "#e83e8c"];
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartGender", data);
				generate_chart_legend(colors, response.data, "#chartGender");
                $("#total-gender").text(thousand_format(response.data.total));
            }
        });

        // Load chart usia
        $.ajax({
            type: "get",
            url: "{{ route('api.member.age') }}",
            success: function(response){
				var colors = ["#20c997", "#28a745", "#ffc107", "#dc3545"];
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: colors,
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartAge", data);
				generate_chart_legend(colors, response.data, "#chartAge");
                $("#total-age").text(thousand_format(response.data.total));
            }
        });
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection