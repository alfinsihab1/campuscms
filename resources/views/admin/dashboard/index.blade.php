@extends('faturcms::template.admin.main')

@section('title', 'Dashboard')

@section('content')

<!-- Main -->
<main class="app-content">


    <!-- Breadcrumb -->
<!--     @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Dashboard',
        'items' => [
            ['text' => 'Dashboard', 'url' => '#'],
        ]
    ]]) -->
    <!-- /Breadcrumb -->

    <div class="greeting">
    	<div class="card mb-3">
    		<div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
    			<div class="order-2 order-md-1">
    				<h5>Selamat Datang Kembali {{ Auth::user()->nama_user }}</h5>
	    			<p class="m-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit<br>sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	    		</div>	
    			<div class="order-1 order-md-2 d-flex align-items-center mb-3 mb-md-0"> 
    				<h1 style="font-size: 4rem" class="m-0">23°</h1>
    				<span id="demo"></span>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="menu-grid">
    	<div class="row">
    		@php $colors = ["red", "green", "yellow", "blue"]; @endphp
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
			    				<div class="d-block d-md-flex align-items-center mb-1">
					    			<span class="badge menu-bg-red mr-2" data-toggle="tooltip" data-placement="top" title="Percobaan untuk tema dark mode">BETA</span>
					    			<h5 class="m-0">Experience with dark mode</h5>
					    		</div>
					    		<p class="m-0">Aktifkan dark mode untuk merasakan pengalaman baru</p>
					    		<div class="d-flex align-items-center">
									<dark-mode-toggle
										appearance="toggle" 
										remember="" 
										></dark-mode-toggle>
									<span class="badge menu-bg-blue" data-toggle="tooltip" data-placement="top" title="Klik untuk mengaktifkan dark mode"><i class="fa fa-chevron-left mr-1"></i> Klik Untuk Mengaktifkan</span>
								</div>
				    		</div>
			    		</div>
		    		</div>
		    	</div>
		    </div>
		    <div class="pengunjung">
	            <div class="tile">
	                <div class="tile-title-w-btn">
	                	<h5>Statistik Pengunjung</h5>
	                    <div>
	                        <select id="filter-visitor" class="form-control form-control-sm">
	                            <option value="week">Seminggu Terakhir</option>
	                            <option value="month">Sebulan Terakhir</option>
	                        </select>
	                    </div>
	                </div>
	                <div class="tile-body">
						<canvas id="chartVisitor" width="400" height="270"></canvas>
	                </div>
	            </div>
	        </div>
    	</div>
        <div class="col-lg-4">
        	@if(count($array)>0)
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
            @endif
        </div>
    </div>
</main>

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-chart')

<script>
	$(window).on("load", function(){
		count_visitor("chartVisitor", "{{ route('api.visitor.count.last-week') }}");
	});

	var chart;

	// Update chart
	$(document).on("change", "#filter-visitor", function(){
		var value = $(this).val();
		if(value == "week"){
			chart.destroy();
			count_visitor("chartVisitor", "{{ route('api.visitor.count.last-week') }}");
		}
		else if(value == "month"){
			chart.destroy();
			count_visitor("chartVisitor", "{{ route('api.visitor.count.last-month') }}");
		}
	});
	
	function count_visitor(selector, url){
		$.ajax({
			type: "get",
			url: url,
			success: function(response){
				var dateString = [];
				var visitorAll = [];
				var visitorAdmin = [];
				var visitorMember = [];
				$(response.data).each(function(key,data){
					dateString.push(data.dateString);
					visitorAll.push(data.visitorAll);
					visitorAdmin.push(data.visitorAdmin);
					visitorMember.push(data.visitorMember);
				});
				var data = {
					labels: dateString,
					datasets: [
						{
							label: 'Semua',
							data: visitorAll,
							backgroundColor: '#28b779',
							borderColor: '#28b779',
							fill: false,
							borderWidth: 1
						},
						{
							label: 'Admin',
							data: visitorAdmin,
							backgroundColor: '#da542e',
							borderColor: '#da542e',
							fill: false,
							borderWidth: 1
						},
						{
							label: 'Member',
							data: visitorMember,
							backgroundColor: '#27a9e3',
							borderColor: '#27a9e3',
							fill: false,
							borderWidth: 1
						}
					]
				};
				chart = generate_chart_line(selector, data);
			}
		});
		return myChart;
	}
</script>
<script type="text/javascript">
var today = new Date()
var curHr = today.getHours()

if (curHr >= 0 && curHr < 6) {
    document.getElementById("demo").innerHTML = 'What are you doing that early?';
} else if (curHr >= 6 && curHr < 12) {
    document.getElementById("demo").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731715.svg">';
} else if (curHr >= 12 && curHr < 17) {
    document.getElementById("demo").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731894.svg">';
} else {
    document.getElementById("demo").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731916.svg">';
}
</script>
@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection