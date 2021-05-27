@extends('faturcms::template.admin.main')

@php $prefix = $kategori->tipe_kategori == 'ebook' || $kategori->tipe_kategori == 'video'  ? 'Materi' : 'Kumpulan'; @endphp

@section('title', $prefix.' '.$kategori->folder_kategori)

@section('content')

<!-- Main -->
<main class="app-content">

    <!-- Breadcrumb -->
    @include('faturcms::template.admin._breadcrumb', ['breadcrumb' => [
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
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <a class="{{ $data->folder_voucher != '' ? session()->get('id_folder') != $data->id_folder ? 'btn-voucher' : '' : '' }}"  data-id="{{ $data->id_folder }}" href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">
                                                <img src="{{ image('assets/images/folder/'.$data->folder_icon, 'folder') }}" height="100" style="max-width: 100%;">
                                            </a>
                                            <p class="h6 mt-3 mb-0"><a class="{{ $data->folder_voucher != '' ? session()->get('id_folder') != $data->id_folder ? 'btn-voucher' : '' : '' }}" data-id="{{ $data->id_folder }}" href="{{ route('member.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $data->folder_dir]) }}">{{ $data->folder_nama }}</a></p>
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
                                <div class="col-lg-3 col-md-6 mb-3">
                                    <div class="card">
                                        <a href="{{ $data->tipe_kategori == 'tools' ? asset('assets/tools/'.$data->file_konten) : route('member.file.detail', ['kategori' => $kategori->slug_kategori, 'id' => $data->id_file]) }}">
                                            <img class="card-img-top" src="{{ image('assets/images/file/'.$data->file_thumbnail, $data->tipe_kategori) }}" height="{{ image('assets/images/file/'.$data->file_thumbnail, $data->tipe_kategori) == asset('assets/images/default/'.config('faturcms.images.'.$data->tipe_kategori)) ? 100 : 'auto' }}">
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

<script>
    @if(Session::get('message'))
        $("#modal-voucher").modal("show");
	@endif
	
	// Button voucher
	$(document).on("click", ".btn-voucher", function(e){
		e.preventDefault();
		var id = $(this).data("id");
		$("#form-voucher input[name=id]").val(id);
		$("#modal-voucher").modal("show");
	});
</script>

@endsection
