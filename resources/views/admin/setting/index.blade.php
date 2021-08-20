@extends('faturcms::template.admin.main')

@section('title', 'Pengaturan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Pengaturan',
        'items' => [
            ['text' => 'Pengaturan', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        @if(count($setting)>0)
            @foreach($setting as $data)
            <!-- Column -->
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="tile">
                    <div class="tile-body">
                        <h5 class="card-title">{{ $data['title'] }}</h5>
                        <p class="card-text small">{{ $data['description'] }}</p>
                        <a href="{{ $data['url'] }}" class="btn btn-sm btn-info"><i class="fa fa-cog mr-2"></i>Buka</a>
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