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
                    @if($file->file_keterangan != '')
                        @php
                            $html = html_entity_decode($file->file_keterangan);
                            $explode = explode(' ', $html);
                            $src = '';
                            if(is_int(strpos($html, 'src='))) {
                                foreach($explode as $data){
                                    if(is_int(strpos($data, 'src='))){
                                        $src = str_replace('src=', '', $data);
                                    }
                                }
                            }
                            else $src = $html;
                        @endphp
                        <div class="embedded">
                            <iframe class="embed-responsive-item" src={!! html_entity_decode($src) !!} height="360" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"></iframe>
                        </div>
                    @else
                        @if($file->file_konten != '')
                        <div class="row">
                            <div class="col-12 mx-auto text-center" id="image-wrapper">
                                @foreach($file_list as $key=>$data)
                                    @php
                                        $explode_dot = explode('.', $data->nama_fd);
                                        $explode_strip = explode('-', $explode_dot[0]);
                                    @endphp
                                    <p class="font-weight-bold mb-1">{{ remove_zero($explode_strip[1]) }} / {{ count($file_list) }}</p>
                                    @if($key == 0)
                                    <img class="border border-secondary mb-2 first-image" style="max-width: 100%;" src="{{ asset('assets/uploads/'.$data->nama_fd) }}">
                                    @else
                                    <img class="border border-secondary mb-2 lazy" style="max-width: 100%;" data-src="{{ asset('assets/uploads/'.$data->nama_fd) }}">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endif
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

@if($file->file_konten != '')

@section('js-extra')

<script type="text/javascript">
	$(window).on("load", function(){
		resize_image();
	});
	
	$(window).on("resize", function(){
		resize_image();
	});
	
    // Resize Image Fit
	function resize_image(){
		var images = $("#image-wrapper img");
		$(images).each(function(key,elem){
            var imageHeight = $(".first-image").height();
            var imageWidth = $(".first-image").width();
            // If mobile browser, image height is auto
            if($(window).width() <= 576)
                $(elem).hasClass("first-image") ? $(elem).css({"height": "auto"}) : $(elem).css({"height": imageHeight, "width": imageWidth});
            // If large-screen browser, image height is fit to page
            else
                $(elem).hasClass("first-image") ? $(elem).css({"height": $("#image-wrapper").height() - 30}) : $(elem).css({"height": $("#image-wrapper").height() - 30, "width": imageWidth});
        });
	}

    // Image Lazy Load
    document.addEventListener("DOMContentLoaded", function() {
        var lazyloadImages = document.querySelectorAll("img.lazy");    
        var lazyloadThrottleTimeout;
        
        function lazyload () {
            if(lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }    
            
            lazyloadThrottleTimeout = setTimeout(function() {
                var scrollTop = $("#image-wrapper").scrollTop();
                lazyloadImages.forEach(function(img) {
                    if((img.offsetTop - window.innerHeight) < scrollTop) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if(lazyloadImages.length == 0) { 
                    document.getElementById("image-wrapper").removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }
  
        document.getElementById("image-wrapper").addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
    });
	
    // Prevent Right Click
	document.addEventListener("contextmenu", function(e){
	 	e.preventDefault();
	}, false);
</script>

@endsection

@endif

@section('css-extra')

<style type="text/css">
    body {overflow-y: hidden;}
    #image-wrapper {height: calc(100vh - 175px); overflow-y: scroll;}
    #image-wrapper img {background: #f1f1fa;}
    .embedded iframe {width: 100%; height: 600px;}
</style>

@endsection