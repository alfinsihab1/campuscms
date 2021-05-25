@extends('faturcms::template.admin.main')

@section('title', 'My Package')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'My Package',
        'items' => [
            ['text' => 'Sistem', 'url' => '#'],
            ['text' => 'My Package', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <div class="tile mb-3" style="padding-top: 15px; padding-bottom: 15px;">
        <div class="tile-body">
            <div class="d-md-flex justify-content-between align-items-center">
                <div>
                    @if($my_package->package_version == package_version())
                        Kamu saat ini sudah menggunakan versi terbaru dari <strong>{{ config('faturcms.name') }} ({{ $my_package->package_version }})</strong>!
                    @else
                        Jangan sampai ketinggalan update terbaru dari <strong>{{ config('faturcms.name') }}</strong>!
                        <br>
                        Kamu saat ini menggunakan versi <strong>{{ $my_package->package_version }}</strong>.
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Info -->
                    <h5>{{ $package['name'] }}</h5>
                    <p class="mb-1">
                        <img src="https://poser.pugx.org/ajifatur/faturcms/d/total.svg" alt="Total Downloads">
                        <img src="https://poser.pugx.org/ajifatur/faturcms/v/stable.svg" alt="Latest Stable Version">
                        <img src="https://poser.pugx.org/ajifatur/faturcms/license.svg" alt="License">
                        <img src="https://img.shields.io/badge/php-7.2-brightgreen.svg?logo=php" alt="PHP Version">
                        <img src="https://img.shields.io/badge/laravel-7.x-orange.svg?logo=laravel" alt="Laravel Version">
                    </p>
                    <p class="mb-1"><strong>[{{ ucfirst($package['type']) }}]</strong> {{ array_key_exists('description', $package) ? $package['description'] : '' }}</p>
                    <p><a href="https://github.com/{{ $package['name'] }}" target="_blank"><i class="fa fa-github mr-2"></i>https://github.com/{{ $package['name'] }}</a></p>

                    <p class="mb-0"><strong>Author:</strong></p>
                    <ul class="list-unstyled">
                        @foreach($package['authors'] as $author)
                        <li><a href="https://github.com/{{ $author['name'] }}" target="_blank"><i class="fa fa-github mr-2"></i>{{ $author['name'] }} ({{ $author['email'] }})</a></li>
                        @endforeach
                    </ul>
                    
                    <p class="mb-0"><strong>Require:</strong></p>
                    <ul class="list-unstyled">
                        @foreach($package['require'] as $key=>$require)
                        <li><a href="https://github.com/{{ $key }}" target="_blank"><i class="fa fa-github mr-2"></i>{{ $key }}: {{ $require }}</a></li>
                        @endforeach
                    </ul>
                    <!-- /Info -->
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