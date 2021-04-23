@extends('faturcms::template.admin.main')

@section('title', 'Data Command')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Command',
        'items' => [
            ['text' => 'Command', 'url' => route('admin.command.index')],
            ['text' => 'Data Command', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-3 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Update Package</h5>
                    <p class="card-text small">composer update ajifatur/faturcms</p>
                    <a href="{{ route('admin.command.updatepackage') }}" class="btn btn-sm btn-info"><i class="fa fa-terminal mr-2"></i>Run Command</a>
                </div>
            </div>
        </div>
        <!-- /Column -->
        <!-- Column -->
        <div class="col-lg-3 col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Check Composer Version</h5>
                    <p class="card-text small">composer --version</p>
                    <a href="{{ route('admin.command.composerversion') }}" class="btn btn-sm btn-info"><i class="fa fa-terminal mr-2"></i>Run Command</a>
                </div>
            </div>
        </div>
        <!-- /Column -->
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection