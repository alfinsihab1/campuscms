@extends('faturcms::template.member.main')

@section('title', 'Detail File')

@section('content')

<!-- Main -->
<main class="app-content">

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
                    if((img.offsetTop - 600) < scrollTop) {
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

@section('css-extra')

<style type="text/css">
    body {overflow-y: hidden;}
    #image-wrapper {height: calc(100vh - 175px); overflow-y: scroll;}
    #image-wrapper img {background: #f1f1fa;}
</style>

@endsection