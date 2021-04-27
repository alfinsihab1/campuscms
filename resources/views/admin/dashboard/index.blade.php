@extends('faturcms::template.admin.main')

@section('title', 'Dashboard')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Dashboard',
        'items' => [
            ['text' => 'Dashboard', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Welcome Text -->
    <div class="alert alert-success text-center shadow">
        🔔 Selamat datang <span class="font-weight-bold">{{ Auth::user()->nama_user }}</span> di {{ setting('site.name') }}.
    </div>
    <!-- /Welcome Text -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                	<h5>Pengunjung 7 Hari Terakhir</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="myChart" width="400" height="270"></canvas>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title">
                	<h5>Statistik</h5>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<div class="list-group mt-3">
						@foreach($array as $key=>$data)
						<a href="{{ $data['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between {{ $key == 0 ? 'bg-primary' : '' }}">
							<span>{{ $data['data'] }}</span>
							<span>{{ number_format($data['total'],0,'.','.') }}</span>
						</a>
						@endforeach
					</div>
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

<script type="text/javascript" src="{{ asset('assets/plugins/chart.js/chart.min.js') }}"></script>
<script>
	$(window).on("load", function(){
		count_visitor();
	});
	
	function count_visitor(){
		$.ajax({
			type: "get",
			url: "{{ route('admin.ajax.countvisitor') }}",
			success: function(response){
				var result = JSON.parse(response);
				var date = [];
				var date_str = [];
				var visitor_all = [];
				var visitor_admin = [];
				var visitor_member = [];
				$(result).each(function(key,data){
					date.push(data.date);
					date_str.push(data.date_str);
					visitor_all.push(data.visitor_all);
					visitor_admin.push(data.visitor_admin);
					visitor_member.push(data.visitor_member);
				});
				chart_js("myChart", "line", date_str, visitor_all, visitor_admin, visitor_member);
			}
		});
	}
	
	function chart_js(selector, type, labels, data1, data2, data3){
		var ctx = document.getElementById(selector);
		var myChart = new Chart(ctx, {
			type: type,
			data: {
				labels: labels,
				datasets: [
					{
						label: 'Semua',
						data: data1,
						backgroundColor: '#28b779',
						borderColor: '#28b779',
						fill: false,
						borderWidth: 1
					},
					{
						label: 'Admin',
						data: data2,
						backgroundColor: '#da542e',
						borderColor: '#da542e',
						fill: false,
						borderWidth: 1
					},
					{
						label: 'Member',
						data: data3,
						backgroundColor: '#27a9e3',
						borderColor: '#27a9e3',
						fill: false,
						borderWidth: 1
					},
				]
			},
			options: {
				responsive: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							//stepSize: 2
						}
					}]
				}
			}
		});
	}
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">
<style type="text/css">
	.card-title {text-align: center!important;}
    .border-top, .border-bottom {padding: 1.25rem;}
</style>

@endsection