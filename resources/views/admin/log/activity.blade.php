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
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <h5>Log: {{ $user->nama_user }}</h5>
                    <div class="btn-group">
                        <a href="{{ route('admin.user.detail', ['id' => $user->id_user]) }}" class="btn btn-sm btn-success"><i class="fa fa-user mr-2"></i> Kunjungi Profil</a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete-log"><i class="fa fa-trash mr-2"></i> Hapus Log ({{ generate_size(\File::size(storage_path('logs/user-activities/'.$user->id_user.'.log'))) }})</a>
                    </div>
                    <form id="form-delete-log" class="d-none" method="post" action="{{ route('admin.log.activity.delete') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $user->id_user }}">
                    </form>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    @if(Session::get('message') != null)
                        <div class="alert alert-success alert-dismissible mb-4 fade show" role="alert">
                            {{ Session::get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- Identitas -->
                    <div class="mb-4">
                        <p class="mb-1"><i class="fa fa-envelope mr-2"></i>{{ $user->email }}</p>
                        <p class="mb-1"><i class="fa fa-globe mr-2"></i>{{ number_format(count_kunjungan($user->id_user, 'all'),0,',',',') }}x Kunjungan</p>
                        <p class="mb-1"><i class="fa fa-refresh mr-2"></i>{{ number_format(count($logs),0,',',',') }}x Request</p>
                        <p class="mb-1"><i class="fa fa-clock-o mr-2"></i>Terakhir Kunjungan pada {{ generate_date_time($user->last_visit) }}</p>
                    </div>
                    <!-- /Identitas -->
                    <!-- Logs -->
                    @if($logs != false)
                        @if(count($logs) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-borderless table-stretch">
                                @foreach($logs as $log)
                                <tr>
                                    <td><a href="{{ URL::to($log->url) }}" target="_blank">{{ strlen($log->url) <= 100 ? URL::to($log->url) : URL::to(substr($log->url,0,100)).'....' }}</a></td>
                                    <td width="150">{{ date('d/m/Y', $log->time).', '.date('H:i:s', $log->time) }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        @endif
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

    // Button Delete Log
    $(document).on("click", ".btn-delete-log", function(e){
        e.preventDefault();
        var ask = confirm("Anda yakin ingin menghapus log ini?");
        if(ask){
            $("#form-delete-log").submit();
        }
    });
</script>

@endsection