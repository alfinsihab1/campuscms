@extends('faturcms::template.admin.main')

@section('title', $kategori->prefix_kategori.' '.$kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
        'title' => $kategori->prefix_kategori.' '.$kategori->folder_kategori,
        'items' => [
            ['text' => 'File Manager', 'url' => '#'],
            ['text' => $kategori->prefix_kategori.' '.$kategori->folder_kategori, 'url' => '#'],
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
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card">
                                        <a class="text-center {{ $data->folder_voucher != '' ? session()->get('id_folder') != $data->id_folder ? 'btn-voucher' : '' : '' }}"  data-id="{{ $data->id_folder }}" href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">
                                            <img class="lazy" data-src="{{ image('assets/images/folder/'.$data->folder_icon, 'folder') }}" height="100" style="max-width: 100%;">
                                        </a>
                                        <div class="card-body p-2">
                                            <p class="card-title mb-0">
                                                <a class="{{ $data->folder_voucher != '' ? session()->get('id_folder') != $data->id_folder ? 'btn-voucher' : '' : '' }}" data-id="{{ $data->id_folder }}" href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}" data-toggle="tooltip" title="{{ $data->folder_nama }}">{{ $data->folder_nama }}</a>
                                            </p>
                                        </div>
                                        <div class="card-footer d-flex justify-content-between p-2">
                                            <span data-toggle="tooltip" title="{{ count_folders($data->id_folder, $data->folder_kategori) }} Folder"><i class="fa fa-folder-open mr-1"></i>{{ count_folders($data->id_folder, $data->folder_kategori) }}</span>
                                            <span data-toggle="tooltip" title="{{ count_files($data->id_folder, $data->folder_kategori) }} File"><i class="fa {{ $kategori->icon_kategori != 'fa-folder-open' ? $kategori->icon_kategori : 'fa-file' }} mr-1"></i>{{ count_files($data->id_folder, $data->folder_kategori) }}</span>
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
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="card">
                                        <a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('member.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">
                                            <img class="card-img-top lazy" data-src="{{ image('assets/images/file/'.$data->file_thumbnail, $data->tipe_kategori) }}" height="{{ image('assets/images/file/'.$data->file_thumbnail, $data->tipe_kategori) == asset('assets/images/default/'.config('faturcms.images.'.$data->tipe_kategori)) ? 100 : 'auto' }}">
                                        </a>
                                        <div class="card-body p-2">
                                            <p class="card-title my-0">
                                                <a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('member.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}" data-toggle="tooltip" title="{{ $data->file_nama }}">{{ $data->file_nama }}</a>
                                            </p>
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

<!-- Modal Voucher -->
<div class="modal fade" id="modal-voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				@if(Session::get('message'))
				<div class="alert alert-danger text-center">
					{{ Session::get('message') }}
				</div>
				@endif
				<div class="alert alert-warning text-center">
					Masukkan kode voucher yang Anda miliki untuk mengakses konten ini.
				</div>
				<form id="form-voucher" method="post" action="{{ route('member.file.voucher', ['kategori' => $kategori->slug_kategori]) }}">
					{{ csrf_field() }}
					<input type="hidden" name="id" value="{{ Session::get('id_folder') }}">
					<input type="hidden" name="dir" value="{{ $_GET['dir'] }}">
					<div class="form-group">
						<label>Kode Voucher</label>
						<input type="text" name="voucher" class="form-control" required>
					</div>
					<div class="form-group">
                		<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<!-- /Modal Voucher -->

@endsection

@section('js-extra')

@include('faturcms::template.admin._js-lazy')

@if(Session::get('message'))
<script type="text/javascript">
    // Display modal voucher
    $("#modal-voucher").modal("show");
</script>
@endif

<script type="text/javascript">	
	// Button voucher
	$(document).on("click", ".btn-voucher", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		$("#form-voucher input[name=id]").val(id);
		$("#modal-voucher").modal("show");
	});
</script>

@endsection

@section('css-extra')

<style type="text/css">
    .card-title {font-weight: bold; height: 42px; display: -webkit-box !important; -webkit-line-clamp: 2; -moz-line-clamp: 2; -ms-line-clamp: 2; -o-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
</style>

@endsection