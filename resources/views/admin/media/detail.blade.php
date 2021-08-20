@extends('faturcms::template.admin.main')

@section('title', 'Detail Media: '.$directory[$category]['title'])

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => 'Detail Media: '.$directory[$category]['title'],
        'items' => [
            ['text' => 'Media', 'url' => route('admin.media.index')],
            ['text' => 'Detail Media: '.$directory[$category]['title'], 'url' => '#'],
        ]
    ]])
    <!-- /Breadcrumb -->

    <!-- Row -->
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12 mb-3">
            <!-- Tile -->
            <div class="tile mb-0">
                <!-- Tile Title -->
                <div class="tile-title-w-btn">
                    <div>{{ 'public/assets/'.$directory[$category]['dir'] }} <strong>({{ number_format(count($files),0,',',',') }} file &#8211; {{ generate_size($folder_size) }})</strong></div>
                    <div class="btn-group">
                        <a href="#" class="btn btn-sm btn-danger btn-delete-batch-media"><i class="fa fa-trash mr-2"></i> Hapus Semua File Tidak Terpakai</a>
                    </div>
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
                    <div class="row"> 
                        @if(count($files)>0)
                            @foreach($files as $file)
                            <div class="col mb-3">
                                <div class="card card-image">
                                    <div class="card-body p-2 text-center">
                                        <div class="card-overlay justify-content-center align-items-center">
                                            <div class="btn-group">
                                                <a class="btn btn-sm btn-info btn-magnify-popup" href="{{ asset('assets/images/'.$category.'/'.$file) }}" data-toggle="tooltip" title="Lihat File"><i class="fa fa-eye"></i></a>
                                                <a class="btn btn-sm btn-danger btn-delete-media" href="{{ $file }}" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <span class="badge badge-{{ in_array($file, $file_used) ? 'success' : 'danger' }}">{{ in_array($file, $file_used) ? 'Terpakai' : 'Tidak Terpakai' }}</span>
                                        <img class="lazy" height="100" data-src="{{ asset('assets/images/'.$category.'/'.$file) }}">
                                        <div class="small text-dark mt-2">
                                            {{ $file }}
                                            <br>
                                            ({{ generate_size(\File::size('assets/'.$directory[$category]['dir'].'/'.$file)) }})
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="col">
                            <div class="alert alert-danger text-center">Tidak ada file tersedia.</div>
                        </div>
                        @endif
                        <form id="form-delete-media" class="d-none" method="post" action="{{ route('admin.media.delete') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="category" value="{{ $category }}">
                            <input type="hidden" name="file">
                        </form>
                        <form id="form-delete-batch-media" class="d-none" method="post" action="{{ route('admin.media.delete-batch') }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="category" value="{{ $category }}">
                        </form>
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

@section('js-extra')

@include('faturcms::template.admin._js-lazy')

<script type="text/javascript" src="{{ asset('templates/vali-admin/vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('templates/vali-admin/vendor/magnific-popup/meg.init.js') }}"></script>
<script type="text/javascript">    
    // Button Magnify Popup
    $('.btn-magnify-popup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        image: {
            verticalFit: true
        },
        gallery: {
            enabled: true
        }
    });

    // Button Delete Media
    $(document).on("click", ".btn-delete-media", function(e){
        e.preventDefault();
        var ask = confirm("Anda yakin ingin menghapus file ini?");
        if(ask){
            var file = $(this).attr("href");
            $("#form-delete-media input[name=file]").val(file);
            $("#form-delete-media").submit();
        }
    });

    // Button Delete Batch Media
    $(document).on("click", ".btn-delete-batch-media", function(e){
        e.preventDefault();
        var ask = confirm("Anda yakin ingin menghapus semua file tidak terpakai?");
        if(ask){
            $("#form-delete-batch-media").submit();
        }
    });
</script>

@endsection

@section('css-extra')

<link rel="stylesheet" type="text/css" href="{{ asset('templates/vali-admin/vendor/magnific-popup/magnific-popup.css') }}">
<style type="text/css">
    .card-image .card-overlay {display: none;}
    .card-image:hover .card-overlay {display: flex; position: absolute; background-color: rgba(0,0,0,.45); height: 100%; width: 100%; top: 0; left: 0; border-radius: .25rem; transition: .5s ease-in;}
    .card-image img {border-radius: .25rem;}
    .card-image .badge {position: absolute; top: .5rem; left: .5rem;}
</style>

@endsection