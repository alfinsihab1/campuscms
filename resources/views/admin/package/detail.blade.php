@extends('faturcms::template.admin.main')

@section('title', 'Detail Package')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Package',
        'items' => [
            ['text' => 'Sistem', 'url' => '#'],
            ['text' => 'Detail Package', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">

                    <!-- Detail Package -->
                    <h5>{{ $package['full_name'] }}</h5>
                    <p class="mb-1">{{ array_key_exists('description', $package) ? $package['description'] : '' }}</p>
                    <p><a href="{{ $package['html_url'] }}" target="_blank"><i class="fa fa-link mr-1"></i>{{ $package['html_url'] }}</a></p>
                    <!-- /Detail Package -->

                    @if(count($releases)>0)
                    <!-- Accordion -->
                    <div id="accordion" class="mt-5">
                        <h5>Release</h5>
                        @foreach($releases as $key=>$data)
                        <div class="card">
                            <div class="card-header p-0" id="heading-{{ $key }}">
                                <button class="btn btn-link text-primary text-justify w-100" data-toggle="collapse" data-target="#collapse-{{ $key }}" aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="mr-2"><i class="fa fa-tag mr-1"></i>{{ $data['tag_name'] }}</span>
                                            @if($key == 0)
                                            <span class="badge badge-success">Terbaru</span><br>
                                            @endif
                                        </div>
                                        <div><i class="fa fa-chevron-down"></i></div>
                                    </div>
                                </button>
                            </div>
                            <div id="collapse-{{ $key }}" class="collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading-{{ $key }}" data-parent="#accordion">
                                <div class="card-body p-3">
                                    {!! nl2br($data['body']) !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- /Accordion -->
                    @else
                    <div class="alert alert-danger text-center mt-5">Tidak dapat membaca releases dari Github</div>
                    @endif
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

@section('css-extra')

<style type="text/css">
    .btn-link:hover, .btn-link:focus {text-decoration: none; background-color: #e5e5e5;}
</style>

@endsection