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

    <div class="menu-grid">
    	<div class="row">
    		@php $colors = ["red", "green", "primary", "blue"]; @endphp
    		@if(count($array_card)>0)
    			@foreach($array_card as $key=>$data)
		    		<div class="col-6 col-lg-3 mb-3">
		    			<a href="{{ $data['url'] }}" class="text-decoration-none">
		    			<div class="card menu-bg-{{ $colors[$key] }}">
		    				<div class="card-body">
		    					<div class="media d-block d-md-flex text-center text-md-left">
	    						<div class="mr-0 mr-md-3 h1">{{ number_format($data['total'],0,',',',') }}</div>
		    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--{{ $colors[$key] }})">
		    							<p class="m-0">Materi<br>{{ $data['title'] }}</p>
		    						</div>
		    					</div>
		    				</div>
		    			</div>
		    			</a>
		    		</div>
    			@endforeach
    		@endif
    	</div>
    </div>
    <div class="row">
    	<div class="col-lg-8">
		    <div class="experience mb-3">
		    	<div class="card">
		    		<div class="card-body">
		    			<div class="media align-items-center">
			    			<img class="mr-3" width="100" src="https://image.flaticon.com/icons/svg/3731/3731790.svg">
			    			<div class="media-body">
			    				<div class="d-flex align-items-center mb-1">
					    			<span class="badge menu-bg-red mr-2" data-toggle="tooltip" data-placement="top" title="Percobaan untuk tema dark mode">BETA</span>
					    			<h5 class="m-0">Experience with dark mode</h5>
					    		</div>
					    		<p class="m-0">Aktifkan dark mode untuk merasakan pengalaman baru</p>
					    		<div class="d-flex align-items-center">
									<dark-mode-toggle appearance="toggle"></dark-mode-toggle>
									<span class="badge menu-bg-blue" data-toggle="tooltip" data-placement="top" title="Klik untuk mengaktifkan dark mode"><i class="fa fa-chevron-left mr-1"></i> Klik Untuk Mengaktifkan</span>
								</div>
				    		</div>
			    		</div>
		    		</div>
		    	</div>
		    </div>
		    <div class="pengunjung">
	            <div class="tile">
	                <div class="tile-title">
	                	<h5>Pengunjung 7 Hari Terakhir</h5>
	                </div>
	                <div class="tile-body">
						<canvas id="myChart" width="400" height="200"></canvas>
	                </div>
	            </div>
	        </div>
    	</div>
        <div class="col-lg-4">
            <div class="tile">
                <div class="tile-title">
                	<h5>Statistik</h5>
                </div>
                <div class="tile-body">
					<div class="list-group mt-3">
						@foreach($array as $key=>$data)
						<a href="{{ $data['url'] }}" class="list-group-item list-group-item-action d-flex justify-content-between {{ $key == 0 ? 'bg-primary' : '' }}">
							<span>{{ $data['title'] }}</span>
							<span>{{ number_format($data['total'],0,'.','.') }}</span>
						</a>
						@endforeach
					</div>
                </div>
            </div>
        </div>
    </div>
</main>

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