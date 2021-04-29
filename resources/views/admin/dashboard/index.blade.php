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
<!--     <div class="alert alert-success text-center shadow">
        🔔 Selamat datang <span class="font-weight-bold">{{ Auth::user()->nama_user }}</span> di {{ setting('site.name') }}.
    </div> -->
    <!-- /Welcome Text -->
    <div class="menu-grid">
    	<div class="row">
    		<div class="col-6 col-lg-3 mb-3">
    			<a href="#" class="text-decoration-none">
    			<div class="card menu-bg-red">
    				<div class="card-body">
    					<div class="media d-block d-md-flex text-center text-md-left">
    						<div class="mr-0 mr-md-3 h1">3</div>
    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--red)">
    							<p class="m-0">Materi<br>E-Learning</p>
    						</div>
    					</div>
    				</div>
    			</div>
    			</a>
    		</div>
    		<div class="col-6 col-lg-3 mb-3">
    			<a href="#" class="text-decoration-none">
    			<div class="card menu-bg-green">
    				<div class="card-body">
    					<div class="media d-block d-md-flex text-center text-md-left">
    						<div class="mr-0 mr-md-3 h1">3</div>
    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--green)">
    							<p class="m-0">Materi<br>E-Library</p>
    						</div>
    					</div>
    				</div>
    			</div>
    			</a>
    		</div>
    		<div class="col-6 col-lg-3 mb-3">
    			<a href="#" class="text-decoration-none">
    			<div class="card menu-bg-primary">
    				<div class="card-body">
    					<div class="media d-block d-md-flex text-center text-md-left">
    						<div class="mr-0 mr-md-3 h1">3</div>
    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--primary)">
    							<p class="m-0">Materi<br>E-Competence</p>
    						</div>
    					</div>
    				</div>
    			</div>
    			</a>
    		</div>
    		<div class="col-6 col-lg-3 mb-3">
    			<a href="#" class="text-decoration-none">
    			<div class="card menu-bg-blue">
    				<div class="card-body">
    					<div class="media d-block d-md-flex text-center text-md-left">
    						<div class="mr-0 mr-md-3 h1">3</div>
    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--blue)">
    							<p class="m-0">Materi<br>E-Course</p>
    						</div>
    					</div>
    				</div>
    			</div>
    			</a>
    		</div>
    	</div>
    </div>
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

@endsection