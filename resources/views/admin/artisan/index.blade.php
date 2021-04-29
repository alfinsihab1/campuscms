@extends('faturcms::template.admin.main')

@section('title', 'Artisan')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Artisan',
        'items' => [
            ['text' => 'Sistem', 'url' => '#'],
            ['text' => 'Artisan', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row mt-3">
        @if(count($commands)>0)
            @foreach($commands as $data)
            <!-- Column -->
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="tile mb-0">
                    <div class="tile-body">
                        <h5 class="card-title">{{ $data['title'] }}</h5>
                        <p class="card-text small">{{ $data['description'] }}</p>
                        <a href="{{ $data['command'] }}" class="btn btn-sm btn-secondary btn-terminal"><i class="fa fa-terminal mr-2"></i>Run Command</a>
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

<!-- Modal Terminal -->
<div class="modal fade" id="modal-terminal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Output</h5>
            </div>
            <div class="modal-body">
                <div class="output w-100 mb-3"></div>
                <div class="text-center">
                    <a class="btn btn-primary" href="{{ route('admin.artisan.index') }}"><i class="fa fa-refresh mr-1"></i>Refresh</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Terminal -->

@endsection

@section('js-extra')

<script type="text/javascript">
    // Button Terminal
    $(document).on("click", ".btn-terminal", function(e){
        e.preventDefault();
        var url = $(this).attr("href");
        $.ajax({
            type: "post",
            url: "{{ route('admin.artisan.call') }}",
            data: {_token: "{{ csrf_token() }}", command: url},
            success: function(response){
                $("#modal-terminal .output").html(response);
                $("#modal-terminal").modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    });
</script>

@endsection