@extends('faturcms::template.admin.main')

@section('title', 'Statistik Perangkat')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Perangkat',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Perangkat', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <h5>Perangkat</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartDevice" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-device">0</strong></p>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <h5>Browser</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartBrowser" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-browser">0</strong></p>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <h5>Platform</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartPlatform" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-platform">0</strong></p>
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

@include('faturcms::template.admin._js-chart')

<script type="text/javascript">
    $(function(){
        // Load chart device
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.device') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#007bff", "#e83e8c", "#28a745", "#dc3545", "#a3acb3"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartDevice", data);
                $("#total-device").text(thousand_format(response.data.total));
            }
        });

        // Load chart browser
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.browser') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#4a8af5", "#fb9d35", "#f7192d", "#a3acb3"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartBrowser", data);
                $("#total-browser").text(thousand_format(response.data.total));
            }
        });

        // Load chart platform
        $.ajax({
            type: "get",
            url: "{{ route('api.visitor.platform') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#00a8e8", "#f7c700", "#444", "#a4c639", "#a3acb3"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartPlatform", data);
                $("#total-platform").text(thousand_format(response.data.total));
            }
        });
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection