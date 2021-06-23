@extends('faturcms::template.admin.main')

@section('title', 'Detail Video')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => $kategori->prefix_kategori.' '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->prefix_kategori.' '.$kategori->folder_kategori, 'url' => route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori])],
            ['text' => 'Detail Video', 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <!-- Tile -->
            <div class="tile">
                <!-- Tile Title -->
                <div class="tile-title-w-btn mb-2">
                    <!-- Breadcrumb Direktori -->
                    <ol class="breadcrumb bg-white p-0 mb-0">
                        @foreach(file_breadcrumb($directory) as $key=>$data)
                        <li class="breadcrumb-item"><a href="{{ route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <div class="row">
                        <div class="col-lg-8 order-2 order-lg-1">
                            <div class="embed-responsive embed-responsive-16by9 mb-3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $file->file_konten }}?rel=0&modestbranding=1&autoplay=1" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-secondary"><i class="fa fa-user mr-2"></i>{{ $file->nama_user }}</span>
                                <span class="text-secondary"><i class="fa fa-calendar mr-2"></i>{{ generate_date_time($file->file_at) }}</span>
                            </div>
                            <p class="h3">{{ $file->file_nama }}</p>
                            <p>{!! nl2br($file->file_deskripsi) !!}</p>
                            @if($file->file_keterangan != '')
                                @php
                                    $html = html_entity_decode($file->file_keterangan);
                                    $explode = explode(' ', $html);
                                    $src = '';
                                    foreach($explode as $data){
                                        if(is_int(strpos($data, 'src='))){
                                            $src = str_replace('src=', '', $data);
                                        }
                                    }
                                @endphp
                                <div class="embedded">
                                    <iframe class="embed-responsive-item" src={!! html_entity_decode($src) !!} height="360" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0" style="border-left: 1px solid #bebebe;">
                            <p class="h4 mb-3">Navigasi</p>
                            <div class="list-group list-group-flush">
                                @foreach($file_list as $data)
                                <a class="list-group-item list-group-item-action p-1 {{ $file->id_file == $data->id_file ? 'active' : '' }}" href="{{ route('admin.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">
                                    {{ $data->file_nama }}
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
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

@section('css-extra')

<style type="text/css">
    ul {list-style: none; padding-left: 0;}
    .embedded iframe {width: 100%;}
</style>

@endsection