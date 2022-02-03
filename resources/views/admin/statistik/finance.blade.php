@extends('faturcms::template.admin.main')

@section('title', 'Statistik Keuangan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Statistik Keuangan',
        'items' => [
            ['text' => 'Statistik', 'url' => '#'],
            ['text' => 'Keuangan', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-xl-8 col-md-12">
            <div class="tile">
                <div class="tile-title-w-btn">
                    <h5>Revenue</h5>
                    <div>
                        <div class="d-flex">
                            <select id="revenue-month" class="form-control form-control-sm">
                                <option value="0">Semua</option>
                                @foreach(array_indo_month() as $key=>$m)
                                <option value="{{ ($key+1) }}" {{ date('n') == ($key+1) ? 'selected' : '' }}>{{ $m }}</option>
                                @endforeach
                            </select>
                            <select id="revenue-year" class="form-control form-control-sm ml-2">
                                <option value="0">Semua</option>
                                @for($i=date('Y'); $i>=2020; $i--)
                                <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tile-body">
                    <canvas id="chartRevenue" width="400" height="270"></canvas>
                    <div class="d-md-flex justify-content-between text-center mt-3">
                        <div>Income: <strong id="revenue-income">0</strong></div>
                        <div>Outcome: <strong id="revenue-outcome">0</strong></div>
                        <div>Saldo: <strong id="revenue-saldo">0</strong></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-xl-4 col-md-12">
            <div class="row">
                <div class="col-xl-12 col-md-6">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h5>Total Income</h5>
                        </div>
                        <div class="tile-body">
                            <canvas id="chartIncome" width="400" height="270"></canvas>
                            <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                        </div>
                        <div class="tile-footer p-0"></div>
                    </div>
                </div>
                <!-- /Column -->
                <!-- Column -->
                <div class="col-xl-12 col-md-6">
                    <div class="tile">
                        <div class="tile-title-w-btn">
                            <h5>Total Outcome</h5>
                        </div>
                        <div class="tile-body">
                            <canvas id="chartOutcome" width="400" height="270"></canvas>
                            <p class="text-center mt-2 mb-0">Total: <strong class="total">0</strong></p>
                        </div>
                        <div class="tile-footer p-0"></div>
                    </div>
                </div>
                <!-- /Column -->
            </div>
            <!-- /Row -->
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
    // Vars
    var chartRevenue;

    $(function(){
        // Load chart income
        generate_chart("chartIncome", "{{ route('api.finance.income') }}");
        // Load chart outcome
        generate_chart("chartOutcome", "{{ route('api.finance.outcome') }}");
        // Load chart income by year
        chart_revenue("{{ date('n')}}", "{{ date('Y')}}");
    });

    // Change year
    $(document).on("change", "#revenue-month, #revenue-year", function(){
        var month = $("#revenue-month").val();
        var year = $("#revenue-year").val();

        if(year == 0){
            $("#revenue-month").val(0);
            $("#revenue-month").attr("disabled","disabled");
        }
        else $("#revenue-month").removeAttr("disabled");

        chartRevenue.destroy();
        chart_revenue(month, year);
    });

    // Chart doughnut
    function generate_chart(selector, url){
        $.ajax({
            type: "get",
            url: url,
            success: function(response){
                var chart = new ChartDoughnut(selector, response.data, null, true);
                chart.init();
            }
        });
    }

    // Chart revenue by year
    function chart_revenue(month, year){
        $("#chartRevenue").before('<div class="text-center text-loading">Loading...</div>');
        $.ajax({
            type: "get",
            url: "/admin/api/finance/revenue/" + month + "/" + year,
            success: function(response){
                var chart = new ChartBar("chartRevenue", response.data.data, true);
                chartRevenue = chart.init();
                $("#revenue-income").text(thousand_format(response.data.total.income, 'Rp '));
                $("#revenue-outcome").text(thousand_format(response.data.total.outcome, 'Rp '));
                $("#revenue-saldo").text(thousand_format(response.data.total.saldo, 'Rp '));
            }
        });
    }
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection
