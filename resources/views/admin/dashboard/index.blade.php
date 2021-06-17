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

    @if (Auth::user()->role==role('it'))
    <div class="greeting">
    	<div class="card mb-3">
    		<div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
    			<div class="order-2 order-md-1">
    				<h5>Selamat Datang Kembali, {{ Auth::user()->nama_user }}</h5>
	    			<p class="m-0">Sudahkah kamu bersyukur hari ini?<br>Apa fokus tujuanmu hari ini?</p>
	    		</div>	
    			<div class="order-1 order-md-2 d-flex align-items-center mb-3 mb-md-0"> 
    				<h1 style="font-size: 4rem" class="m-0" id="hours"></h1>
    				<span id="greetings"></span>
    			</div>
    		</div>
    	</div>
    </div>
    @endif
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
    		@if (Auth::user()->role==role('it'))
		    <div class="experience mb-3 d-none">
		    	<div class="card">
		    		<div class="card-body">
		    			<div class="media d-block d-md-flex align-items-center">
							<div class="text-center text-md-left">
								<img class="mr-0 mr-md-3 mb-3 mb-md-0 " width="100" src="https://image.flaticon.com/icons/svg/3731/3731790.svg">
							</div>
			    			<div class="media-body">
			    				<div class="d-block d-md-flex align-items-center mb-1">
					    			<span class="badge menu-bg-red mr-2" data-toggle="tooltip" data-placement="top" title="Percobaan untuk tema dark mode">BETA</span>
					    			<h5 class="m-0">Experience with dark mode</h5>
					    		</div>
					    		<p class="m-0">Aktifkan dark mode untuk merasakan pengalaman baru</p>
					    		<div class="d-flex align-items-center">
									<dark-mode-toggle
									    appearance="toggle"
									    permanent=""
									></dark-mode-toggle>
									<span class="badge menu-bg-blue" data-toggle="tooltip" data-placement="top" title="Klik untuk mengaktifkan dark mode"><i class="fa fa-chevron-left mr-1"></i> Klik Untuk Mengaktifkan</span>
								</div>
				    		</div>
			    		</div>
		    		</div>
		    	</div>
		    	<div id="exp">
		    		<button class="btn menu-bg-primary text">
		    			<i class="fa fa-diamond mr-2"></i>
		    			<span>Pro Version</span>
		    		</button>
		    	</div>
		    </div>
		    @endif
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
						<canvas id="chartVisitor" width="400" height="200"></canvas>
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
			
			@if(Auth::user()->role == role('it'))
            <div class="tile">
				<div class="tile-title-w-btn">
					<h5>Pengunjung Top</h5>
					<div>
						<select id="filter-top-visitor" class="form-control form-control-sm">
							<option value="week">Seminggu Terakhir</option>
							<option value="month">Sebulan Terakhir</option>
						</select>
					</div>
				</div>
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-borderless" id="table-top-visitor">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="colspan" colspan="2"><em>Loading...</em></td></tr>
                            </tbody>
                        </table>
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
	var chart;
	
	// Load page
	$(window).on("load", function(){
		count_visitor("chartVisitor", "{{ route('api.visitor.count.last-week') }}");
		top_visitor("#table-top-visitor", "{{ route('api.visitor.top.last-week') }}");
	});

	// Update chart visitor
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

	// Update table top visitor
	$(document).on("change", "#filter-top-visitor", function(){
		var value = $(this).val();
		if(value == "week"){
			top_visitor("#table-top-visitor", "{{ route('api.visitor.top.last-week') }}");
		}
		else if(value == "month"){
			top_visitor("#table-top-visitor", "{{ route('api.visitor.top.last-month') }}");
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
		return chart;
	}
	
	function top_visitor(selector, url){
		if($(selector).length == 1){
			$.ajax({
				type: "get",
				url: url,
				success: function(response){
					var html = '';
					for(var i=0; i<response.data.length; i++){
						html += '<tr>';
						html += '<td><a href="' + response.data[i].url + '">' + response.data[i].user.nama_user + '</a></td>';
						html += '<td>' + response.data[i].visits + '</td>';
						html += '</tr>';
					}
					$(selector).find("tbody").html(html);
				}
			});
		}
	}
</script>
@if (Auth::user()->role==role('it'))
<script type="text/javascript">
function waktu(){
	var today = new Date()
	var curHr = today.getHours()

	if (curHr >= 0 && curHr < 6) {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731938.svg">';
	} else if (curHr >= 6 && curHr < 12) {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731715.svg">';
	} else if (curHr >= 12 && curHr < 17) {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731894.svg">';
	} else {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="https://image.flaticon.com/icons/svg/3731/3731916.svg">';
	}
}
window.setInterval(waktu, 1000);
// var a = new Date();
// console.log(a);
// document.getElementById("hours").append(a);
</script>
@endif
<!-- <script type="text/javascript">
	$.ajax({
		url: "{{route('api.get.coordinate')}}",
		type: 'GET',
		success: function(response){
			var data = JSON.parse(response);
			console.log(data.latitude);
			console.log(data.longitude);
		}
	})
</script> -->
@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">
<style type="text/css">
    .table tr th, .table tr td {padding: .25rem;}
    .table tr th:last-child, .table tr td:last-child {text-align: right;}
    .table tr td.colspan {text-align: center!important;}
</style>

@endsection
