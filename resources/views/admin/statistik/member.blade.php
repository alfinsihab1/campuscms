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
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <h5>Status</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartStatus" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-status">0</strong></p>
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
                    <h5>Jenis Kelamin</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartGender" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-gender">0</strong></p>
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
                    <h5>Usia</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartAge" width="400" height="270"></canvas>
                    <p class="text-center mt-2 mb-0">Total: <strong id="total-age">0</strong></p>
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
        // Load chart status
        $.ajax({
            type: "get",
            url: "{{ route('api.member.status') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#28a745", "#dc3545"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartStatus", data);
                $("#total-status").text(thousand_format(response.data.total));
            }
        });

        // Load chart jenis kelamin
        $.ajax({
            type: "get",
            url: "{{ route('api.member.gender') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#007bff", "#e83e8c"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartGender", data);
                $("#total-gender").text(thousand_format(response.data.total));
            }
        });

        // Load chart usia
        $.ajax({
            type: "get",
            url: "{{ route('api.member.age') }}",
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: ["#20c997", "#28a745", "#ffc107", "#dc3545"],
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut("chartAge", data);
                $("#total-age").text(thousand_format(response.data.total));
            }
        });
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection