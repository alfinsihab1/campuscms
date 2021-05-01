@extends('faturcms::template.admin.main')

@section('title', 'Log Aktivitas')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Log Aktivitas',
        'items' => [
            ['text' => 'Log', 'url' => route('admin.log.index')],
            ['text' => 'Log Aktivitas', 'url' => '#'],
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
                        <h5>{{ $user->nama_user }}</h5>
                        <p class="mb-1"><i class="fa fa-envelope mr-2"></i>{{ $user->email }}</p>
                        <p class="mb-1"><i class="fa fa-globe mr-2"></i>{{ number_format(count_kunjungan($user->id_user, 'all'),0,',',',') }}x Kunjungan</p>
                        <p class="mb-1"><i class="fa fa-clock-o mr-2"></i>Terakhir Kunjungan pada {{ generate_date_time($user->last_visit) }}</p>
                    </div>
                    <!-- /Identitas -->
                    <!-- Logs -->
                    @if($logs != false)
                    <div class="list-group list-group-flush">
                        @if(count($logs) > 0)
                            @foreach($logs as $log)
                            <div class="list-group-item d-sm-flex justify-content-between px-0 py-1">
                                <div class="font-weight-bold"><a href="{{ URL::to($log->url) }}" target="_blank">{{ URL::to($log->url) }}</a></div>
                                <div>{{ generate_date(date('Y-m-d H:i:s', $log->time)).', '.date('H:i:s', $log->time) }}</div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    @else
                    <div class="alert alert-danger text-center mb-0">Belum ada aktivitas yang tercatat.</div>
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