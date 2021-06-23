@extends('faturcms::template.admin.main')

@section('title', 'Detail File')

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => $kategori->prefix_kategori.' '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->prefix_kategori.' '.$kategori->folder_kategori, 'url' => route('member.filemanager.index', ['kategori' => $kategori->slug_kategori])],
            ['text' => 'Detail File', 'url' => '#'],
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
                        <li class="breadcrumb-item"><a href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama == '/' ? 'Home' : $data->folder_nama }}</a></li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $file->file_nama }}</li>
                    </ol>
                    <!-- /Breadcrumb Direktori -->
                </div>
                <!-- /Tile Title -->
                <!-- Tile Body -->
                <div class="tile-body">
                    <button class="btn btn-success btn-sm btn-copy mb-2" type="button" data-toggle="tooltip" title="Salin Teks"><i class="fa fa-copy mr-2"></i>Salin Teks</button>
                    <textarea class="form-control" id="textarea" rows="25" readonly>{!! html_entity_decode($file->file_konten) !!}</textarea>
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
    // Button Copy to Clipboard
    $(document).on("click", ".btn-copy", function(e){
        e.preventDefault();
        var copyText = document.getElementById("textarea");
        copyText.select();
        copyText.setSelectionRange(0, 999999);
        console.log(document.execCommand("copy"));
        $(this).attr('data-original-title','Berhasil Menyalin Teks!');
        $(this).tooltip("show");
        $(this).attr('data-original-title','Salin Teks');
    });
</script>

@endsection