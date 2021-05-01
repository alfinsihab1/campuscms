@extends('faturcms::template.admin.main')

@section('title', 'Login Error')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Login Error',
        'items' => [
            ['text' => 'Log', 'url' => route('admin.log.index')],
            ['text' => 'Login Error', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Logs -->
                    @if($logs != false)
                    <div class="list-group list-group-flush">
                        @if(count($logs) > 0)
                            @foreach($logs as $log)
                            <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                                <div>{{ $log->username }}</div>
                                <div>{{ $log->ip }}</div>
                                <div>{{ generate_date(date('Y-m-d H:i:s', $log->time)).', '.date('H:i:s', $log->time) }}</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    @else
                    <div class="alert alert-danger text-center mb-0">Belum ada log yang tercatat.</div>
                    @endif
                    <!-- /Logs -->
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

@section('js-extra')

<script type="text/javascript">
    // Scroll to down
    $(window).on("load", function(){
       $("html, body").animate({scrollTop: $(document).height()}, 1000); 
    });
</script>

@endsection