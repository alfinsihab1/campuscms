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
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Perangkat</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartDevice" width="400" height="270"></canvas>
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
                    <h5>Browser</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartBrowser" width="400" height="270"></canvas>
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
                    <h5>Platform</h5>
                </div>
                <div class="tile-body">
					<canvas id="chartPlatform" width="400" height="270"></canvas>
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
        // Load chart device
        generate_chart("chartDevice", "{{ route('api.visitor.device') }}");
        // Load chart browser
        generate_chart("chartBrowser", "{{ route('api.visitor.browser') }}");
        // Load chart platform
        generate_chart("chartPlatform", "{{ route('api.visitor.platform') }}");
    });

    function generate_chart(selector, url){
        $.ajax({
            type: "get",
            url: url,
            success: function(response){
                var data = {
                    labels: response.data.labels,
                    datasets: [{
                        data: response.data.data,
                        backgroundColor: response.data.colors,
                        borderWidth: 0
                    }]
                };
                generate_chart_doughnut(selector, data);
                generate_chart_legend(response.data.colors, response.data, "#"+selector);
                $("#"+selector).parents(".tile-body").find(".total").text(thousand_format(response.data.total));
            }
        });
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection