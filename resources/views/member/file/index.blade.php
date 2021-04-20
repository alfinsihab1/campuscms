@extends('faturcms::template.member.main')

@php $prefix = $kategori->tipe_kategori == 'ebook' || $kategori->tipe_kategori == 'video'  ? 'Materi' : 'Kumpulan'; @endphp

@section('title', $prefix.' '.$kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.member._breadcrumb', ['breadcrumb' => [
        'title' => $prefix.' '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $prefix.' '.$kategori->folder_kategori, 'url' => '#'],
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
                <div class="tile-title-w-btn">
                    <!-- Breadcrumb Direktori -->
                    <ol class="breadcrumb bg-white p-0 mb-0">
                        @foreach(file_breadcrumb($directory) as $key=>$data)
                            @if($key + 1 == count(file_breadcrumb($directory)))
                            <li class="breadcrumb-item active" aria-current="page">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                    <div></div>
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <!-- Folder -->
                    <div class="row">
                        @if(count($folders)>0)
                            @foreach($folders as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <a href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">
                                                <img src="{{ image('assets/images/folder/'.$data->folder_icon, 'folder') }}" height="100" style="max-width: 100%;">
                                            </a>
                                            <p class="h6 mt-3 mb-0"><a href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama }}</a></p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            <span data-toggle="tooltip" title="{{ count_folders($data->id_folder, $data->folder_kategori) }} Folder"><i class="fa fa-folder-open mr-1"></i>{{ count_folders($data->id_folder, $data->folder_kategori) }}</span>
                                            <span data-toggle="tooltip" title="{{ count_files($data->id_folder, $data->folder_kategori) }} File"><i class="fa fa-file mr-1"></i>{{ count_files($data->id_folder, $data->folder_kategori) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /Folder -->

                    <!-- File -->
                    <div class="row">
                        @if(count($files)>0)
                            @foreach($files as $data)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card">
                                        <a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('member.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">
                                            <img class="card-img-top" src="{{ $data->tipe_kategori == 'ebook' ? image('assets/images/file/'.$data->file_thumbnail, 'pdf') : image('assets/images/file/'.$data->file_thumbnail, 'file') }}" height="{{ $data->tipe_kategori == 'ebook' ? 100 : 'auto' }}">
                                        </a>
                                        <div class="card-body text-center">
                                            <p class="h6 my-0"><a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('member.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">{{ $data->file_nama }}</a></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- /File -->
                    
                    <!-- Empty Result -->
                    @if(count($folders)<=0 && count($files)<=0)
                    <div class="alert alert-danger text-center mb-0">Tidak ada data di direktori ini.</div>
                    @endif
                    <!-- /Empty Result -->
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