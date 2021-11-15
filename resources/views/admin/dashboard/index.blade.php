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
	    						<div class="mr-0 mr-md-3 h1">{{ number_format($data['total'],0,'.','.') }}</div>
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
    	<div class="col-lg-6 order-2 order-lg-1">
    		@if (Auth::user()->role==role('it'))
		    <div class="experience mb-3 d-none">
		    	<div class="card">
		    		<div class="card-body">
		    			<div class="media d-block d-md-flex align-items-center">
							<div class="text-center text-md-left">
								<img class="mr-0 mr-md-3 mb-3 mb-md-0 " width="100" src="https://image.flaticon.com/icons/svg/3731/3731790.svg" alt="img">
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
        <div class="col-lg-6 order-1 order-lg-2">
		    <div class="menu-grid">
		    	<div class="row">
	    		@php $user_colors = ["green", "red"]; @endphp
	    		@if(count($array_card_user)>0)
	    			@foreach($array_card_user as $key=>$data)
		    		<div class="col-6 mb-3">
		    			<a href="{{ $data['url'] }}" class="text-decoration-none">
		    			<div class="card menu-bg-{{ $user_colors[$key] }}">
		    				<div class="card-body">
		    					<div class="media d-block d-md-flex text-center text-md-left">
	    						<div class="mr-0 mr-md-3 h1">{{ number_format($data['total'],0,'.','.') }}</div>
		    						<div class="media-body pl-0 pl-md-3 " style="border-left: 1px solid var(--{{ $user_colors[$key] }})">
		    							<p class="m-0">Member<br>{{ $data['title'] }}</p>
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

        	@if(count($array)>=2)
            <div class="tile">
                <div class="tile-title">
                	<h5>Sekilas</h5>
                </div>
                <div class="tile-body">
                	<div class="row">
						@foreach($array as $key=>$data)
						<div class="col-md-6">
							<a href="{{ $data['url'] }}" class="list-group-item list-group-item-action border-0 d-flex align-items-center">
								<i class="app-menu__icon fa {{$data['icon']}}"></i>
								<div class="d-flex justify-content-between w-100">
									<span>{{ $data['title'] }}</span>
									<span>{{ number_format($data['total'],0,'.','.') }}</span>
								</div>
							</a>
						</div>
						@endforeach
                	</div>
                </div>
            </div>
            @endif
			
			@if(has_access('VisitorController::index', Auth::user()->role, false))
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
                                    <th width="40">No.</th>
                                    <th>Member</th>
                                    <th>Kunjungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td class="colspan" colspan="3"><em>Loading...</em></td></tr>
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
	
	$(function(){
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
		$("#"+selector).before('<div class="text-center text-loading">Loading...</div>'); // Add loading
		$.ajax({
			type: "get",
			url: url,
			success: function(response){
                var chartVisitor = new ChartLine(selector, response.data, false);
                chart = chartVisitor.init();
			}
		});
	}
	
	function top_visitor(selector, url){
		if($(selector).length == 1){
			var loading = '';
			loading += '<tr>';
			loading += '<td colspan="3" class="text-center"><em>Loading...</em></td>';
			loading += '</tr>';
			$(selector).find("tbody").html(loading);
			$.ajax({
				type: "get",
				url: url,
				success: function(response){
					var html = '';
					if(response.data.length > 0){
						for(var i=0; i<response.data.length; i++){
							html += '<tr>';
							html += '<td>' + (i+1) + '</td>';
							html += '<td><a href="' + response.data[i].url + '">' + response.data[i].user.nama_user + '</a></td>';
							html += '<td>' + response.data[i].visits + '</td>';
							html += '</tr>';
						}
					}
					else{
						html += '<tr>';
						html += '<td colspan="3" class="text-center"><em class="text-danger">Tidak ada data pengunjung.</em></td>';
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
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="{{ asset('assets/images/icon/bed.png') }}">';
	} else if (curHr >= 6 && curHr < 12) {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="{{ asset('assets/images/icon/clouds-and-sun.png') }}">';
	} else if (curHr >= 12 && curHr < 17) {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="{{ asset('assets/images/icon/sun.png') }}">';
	} else {
	    document.getElementById("greetings").innerHTML = '<img class="weather" src="{{ asset('assets/images/icon/half-moon.png') }}">';
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
