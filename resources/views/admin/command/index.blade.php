@extends('faturcms::template.admin.main')

@section('title', 'Command List')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Command List',
        'items' => [
            ['text' => 'Terminal', 'url' => route('admin.command.index')],
            ['text' => 'Command List', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        @if(count($composerCommands)>0)
            @foreach($composerCommands as $data)
            <!-- Column -->
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $data['title'] }}</h5>
                        <p class="card-text small">{{ $data['description'] }}</p>
                        <a href="{{ $data['url'] }}" data-artisan="false" class="btn btn-sm btn-info btn-terminal"><i class="fa fa-terminal mr-2"></i>Run Command</a>
                    </div>
                </div>
            </div>
            <!-- /Column -->
            @endforeach
        @endif
    </div>
    <!-- /Row -->

    <!-- Row -->
    <div class="row mt-3">
        @if(count($artisanCommands)>0)
            @foreach($artisanCommands as $data)
            <!-- Column -->
            <div class="col-lg-3 col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $data['title'] }}</h5>
                        <p class="card-text small">{{ $data['description'] }}</p>
                        <a href="{{ $data['command'] }}" data-artisan="true" class="btn btn-sm btn-info btn-terminal"><i class="fa fa-terminal mr-2"></i>Run Command</a>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
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
        var artisan = $(this).data("artisan");
        $.ajax({
            type: artisan ? "post" : "get",
            url: artisan ? "{{ route('admin.command.artisan') }}" : url,
            data: artisan ? {_token: "{{ csrf_token() }}", command: url} : '',
            success: function(response){
                $("#modal-terminal .modal-body").html(response);
                $("#modal-terminal").modal("show");
            }
        });
    });
</script>

@endsection