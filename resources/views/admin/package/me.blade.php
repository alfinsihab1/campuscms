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
                <div>Jangan sampai ketinggalan update terbaru dari <strong>{{ config('faturcms.name') }}</strong>!</div>
                <div class="mt-2 mt-md-0"><a class="btn btn-primary btn-update-me" href="#"><i class="fa fa-level-up mr-1"></i>Update</a></div>
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

<!-- Modal Update Me -->
<div class="modal fade" id="modal-update-me" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Output</h5>
            </div>
            <div class="modal-body">
                <h5 class="mb-3"></h5>
                <div class="output w-100 mb-3"></div>
			</div>
            <div class="modal-footer justify-content-center">
                <a class="btn btn-primary btn-refresh" href="{{ route('admin.package.me') }}"><i class="fa fa-refresh mr-1"></i>Refresh</a>
                <a class="btn btn-primary btn-update-me" href="#"><i class="fa fa-level-up mr-1"></i>Update Ulang</a>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Update Me -->

@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Update Me
    $(document).on("click", ".btn-update-me", function(e){
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ route('admin.package.update-me') }}",
            error: function(response){
                var responseText = JSON.parse(response.responseText);
                var html = '';
                html += '<div class="alert alert-danger">' + responseText.message + '</div>';
                html += '<p class="mb-1">File:<br>' + responseText.file + ' on line ' + responseText.line + '</p>';
                html += '<p class="mb-1">Exception:<br>' + responseText.exception + '</p>';
                html += '<ul>';
                $(responseText.trace).each(function(key, array){
                    html += '<li>' + array.class + '::' + array.function + ' (line ' + array.line + ')</li>';
                });
                html += '</ul>';
                $("#modal-update-me .modal-body h5").html('<i class="fa fa-exclamation-circle mr-2"></i>' + response.status + ": " + response.statusText);
                $("#modal-update-me .output").html(html);
				$("#modal-update-me .btn-refresh").addClass("d-none");
				$("#modal-update-me .btn-update-me").removeClass("d-none");
                $("#modal-update-me").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            success: function(response){
                $("#modal-update-me .modal-body h5").html('<i class="fa fa-check-circle mr-2"></i>200: success!');
                $("#modal-update-me .output").html(response);
				$("#modal-update-me .btn-refresh").removeClass("d-none");
				$("#modal-update-me .btn-update-me").addClass("d-none");
                $("#modal-update-me").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    });
</script>

@endsection

@section('css-extra')

<style type="text/css">
    #modal-update-me .modal-body a {color: #fff;}
    #modal-update-me .modal-body a:hover {color: #fff;}
</style>

@endsection