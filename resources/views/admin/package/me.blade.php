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
                        <span class="badge badge-danger">{{ ucfirst($package['type']) }}</span>
                        <span class="badge badge-info">{{ $package['license'] }}</span>
                    </p>
                    <p class="mb-1">{{ array_key_exists('description', $package) ? $package['description'] : '' }}</p>
                    <p><a href="https://github.com/{{ $package['name'] }}" target="_blank"><i class="fa fa-link mr-1"></i>https://github.com/{{ $package['name'] }}</a></p>

                    <p class="mb-0"><strong>Author:</strong></p>
                    <ul>
                        @foreach($package['authors'] as $author)
                        <li>{{ $author['name'] }} ({{ $author['email'] }})</li>
                        @endforeach
                    </ul>
                    
                    <p class="mb-0"><strong>Require:</strong></p>
                    <ul>
                        @foreach($package['require'] as $key=>$require)
                        <li>{{ $key }}: {{ $require }}</li>
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
                <h5></h5>
                <div class="output w-100 mb-3"></div>
                <div class="text-center">
                    <a class="btn btn-primary" href="{{ route('admin.package.me') }}"><i class="fa fa-refresh mr-1"></i>Refresh</a>
                </div>
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
                $("#modal-update-me .modal-body h5").html(response.status + ": " + response.statusText);
                $("#modal-update-me .output").html(html);
                $("#modal-update-me").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            },
            success: function(response){
                $("#modal-update-me .modal-body h5").html("");
                $("#modal-update-me .output").html(response);
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