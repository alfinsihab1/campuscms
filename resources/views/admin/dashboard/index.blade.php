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
    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-6">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                	<h5>Statistik Pengunjung</h5>
                    <div>
                        <select id="filter-visitor" class="form-control form-control-sm">
                            <option value="week">Seminggu Terakhir</option>
                            <option value="month">Sebulan Terakhir</option>
                        </select>
                    </div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
					<canvas id="chartVisitor" width="400" height="270"></canvas>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-6">
        	@if(count($array)>0)
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
							<span>{{ $data['title'] }}</span>
							<span>{{ number_format($data['total'],0,'.','.') }}</span>
						</a>
						@endforeach
					</div>
                </div>
                <!-- /Tile Body -->
            </div>
            <!-- /Tile -->
            @endif
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

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
	}
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/chart.js/chart.min.css') }}">

@endsection