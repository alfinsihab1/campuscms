@extends('faturcms::template.admin.main')

@section('title', 'Data Media')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Data Media',
        'items' => [
            ['text' => 'Media', 'url' => '#'],
            ['text' => 'Data Media', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row mt-3">
        @if(count($directory)>0)
            @foreach($directory as $key=>$data)
                @if(($data['type'] == 'content' && has_access($data['access'], Auth::user()->role, false)) || $data['type'] == 'setting')
                    <!-- Column -->
                    <div class="col-lg-3 col-md-4 mb-3">
                        <div class="tile mb-0">
                            <div class="tile-body">
                                <h5 class="card-title">{{ $data['title'] }}</h5>
                                <p class="card-text small">{{ 'public/assets/'.$data['dir'] }}</p>
                                <a href="{{ route('admin.media.detail', ['category' => $key]) }}" class="btn btn-sm btn-secondary"><i class="fa fa-folder-open mr-2"></i>Buka</a>
                            </div>
                        </div>
                    </div>
                    <!-- /Column -->
                @endif
            @endforeach
        @endif
    </div>
    <!-- /Row -->
</main>
<!-- /Main -->

@endsection