@extends('faturcms::template.admin.main')

@section('title', 'Log')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Log',
        'items' => [
            ['text' => 'Log', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row mt-3">
        @if(count($logs)>0)
            @foreach($logs as $data)
            <!-- Column -->
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="tile mb-0">
                    <div class="tile-body">
                        <h5 class="card-title">{{ $data['title'] }}</h5>
                        <p class="card-text small">{{ $data['description'] }}</p>
                        <a href="{{ $data['url'] }}" class="btn btn-sm btn-secondary"><i class="fa fa-list mr-2"></i>Buka</a>
                    </div>
                </div>
            </div>
            <!-- /Column -->
            @endforeach
        @endif
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection