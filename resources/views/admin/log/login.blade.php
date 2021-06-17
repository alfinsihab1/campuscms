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
                    <!-- Identitas -->
                    <div class="mb-4">
                        <p class="mb-1"><i class="fa fa-exclamation-triangle mr-2"></i>{{ number_format(count($logs),0,',',',') }}x Login Error</p>
                    </div>
                    <!-- /Identitas -->
                    <!-- Logs -->
                    @if($logs != false)
                    <div class="table-responsive">
                        @if(count($logs) > 0)
                            <table class="table table-hover table-striped table-borderless table-stretch">
                                @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->username != '' ? $log->username : '-' }}</td>
                                    <td width="150">{{ $log->ip }}</td>
                                    <td width="150">{{ date('d/m/Y', $log->time).', '.date('H:i:s', $log->time) }}</td>
                                </tr>
                                @endforeach
                            </table>
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