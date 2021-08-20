<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\FileDetail;
use Ajifatur\FaturCMS\Models\Folder;
use Ajifatur\FaturCMS\Models\FolderKategori;

class FolderController extends Controller
{
    /**
     * Menampilkan form tambah folder
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $category)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->firstOrFail();

        // Jika role admin
        if(Auth::user()->is_admin == 1){
			// Get direktori
        	$directory = ($request->query('dir') == '/') ? Folder::find(1) : Folder::where('folder_dir','=',$request->query('dir'))->where('folder_kategori','=',$kategori->id_fk)->first();

        	// Jika direktori tidak ditemukan
        	if(!$directory){
				// Redirect to '/'
				return redirect()->route('admin.folder.create', ['kategori' => $kategori->slug_kategori, 'dir' => '/']);
        	}
			
            return view('faturcms::admin.folder.create', [
				'kategori' => $kategori,
				'directory' => $directory,
            ]);
        }
	}

	/**
     * Menyimpan folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_folder' => 'required|max:255|regex:/^[0-9A-Za-z. -()]+$/',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
            	'nama_folder',
            	'voucher'
            ]));
        }
        // Jika tidak ada error
        else{
        	// Nama folder
        	$nama_folder = generate_file_name($request->nama_folder, 'folder', 'folder_nama', 'folder_kategori', $request->folder_kategori, 'folder_parent', $request->folder_parent, 'id_folder', null);

			// Generate dir folder
			if($request->folder_parent == 1){
				$dir = "/".$nama_folder;
			}
			else{
				$folder_parent = Folder::find($request->folder_parent);
				$dir = $folder_parent->folder_dir."/".$nama_folder;
			}
			
            // Menambah data
            $folder = new Folder;
            $folder->id_user = Auth::user()->id_user;
            $folder->folder_nama = $nama_folder;
			$folder->folder_kategori = $request->folder_kategori;
			$folder->folder_dir = $dir;
			$folder->folder_parent = $request->folder_parent;
			$folder->folder_icon = generate_image_name("assets/images/folder/", $request->gambar, $request->gambar_url);
			$folder->folder_voucher = $request->voucher != '' ? $request->voucher : '';
			$folder->folder_at = date('Y-m-d H:i:s');
			$folder->folder_up = date('Y-m-d H:i:s');
            $folder->save();
			
			// Get data folder
            $current_folder = Folder::find($request->folder_parent);
            
            // Kategori folder
            $kategori = FolderKategori::find($folder->folder_kategori);
        }

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil menambah folder.']);
    }

    /**
     * Menampilkan form edit folder
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $category, $id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->firstOrFail();

        // Jika role admin
        if(Auth::user()->is_admin == 1){
			// Get direktori
        	$directory = ($request->query('dir') == '/') ? Folder::find(1) : Folder::where('folder_dir','=',$request->query('dir'))->where('folder_kategori','=',$kategori->id_fk)->first();

        	// Jika direktori tidak ditemukan
        	if(!$directory){
				// Redirect to '/'
				return redirect()->route('admin.folder.edit', ['kategori' => $kategori->slug_kategori, 'id' => $id, 'dir' => '/']);
        	}

	    	// Folder
	    	$folder = Folder::where('folder_kategori','=',$kategori->id_fk)->where('folder_parent','=',$directory->id_folder)->findOrFail($id);
			
            return view('faturcms::admin.folder.edit', [
				'kategori' => $kategori,
				'directory' => $directory,
				'folder' => $folder,
            ]);
        }
	}

	/**
     * Mengupdate folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_folder' => 'required|max:255|regex:/^[0-9A-Za-z. -()]+$/',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
            	'nama_folder',
            	'voucher'
            ]));
        }
        // Jika tidak ada error
        else{
        	// Nama folder
        	$nama_folder = generate_file_name($request->nama_folder, 'folder', 'folder_nama', 'folder_kategori', $request->folder_kategori, 'folder_parent', $request->folder_parent, 'id_folder', $request->id);

			// Generate dir folder
			if($request->folder_parent == 1){
				$dir = "/".$nama_folder;
			}
			else{
				$folder_parent = Folder::find($request->folder_parent);
				$dir = $folder_parent->folder_dir."/".$nama_folder;
			}
			
            // Mengupdate data
            $folder = Folder::find($request->id);
            $folder->folder_nama = $nama_folder;
			$folder->folder_dir = $dir;
			$folder->folder_parent = $request->folder_parent;
			$folder->folder_icon = generate_image_name("assets/images/folder/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/folder/", $request->gambar, $request->gambar_url) : $folder->folder_icon;
			$folder->folder_voucher = $request->voucher != '' ? $request->voucher : '';
			$folder->folder_up = date('Y-m-d H:i:s');
            $folder->save();
			
			// Get data folder
            $current_folder = Folder::find($request->folder_parent);
            
            // Kategori folder
            $kategori = FolderKategori::find($folder->folder_kategori);
        }

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil mengupdate folder.']);
    }

    /**
     * Menghapus folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // Get folder
        $folder = Folder::findOrFail($request->id);

        // Get children folder
        $children = [];
        $child = Folder::where('folder_parent','=',$folder->id_folder)->get();
        while(count($child) > 0){
            $ids = [];
            foreach($child as $c){
                $data = Folder::find($c->id_folder);
                array_push($ids, $data->id_folder);
                array_push($children, $data);
            }
            $child = Folder::whereIn('folder_parent',$ids)->get();
        }

        // Menghapus folder yang terpilih
        $folder->delete();

        // Menghapus children folder
        if(count($children) > 0){
            foreach($children as $child){
                $data = Folder::find($child->id_folder);
                $data->delete();

                // Menghapus file
		        $files = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('id_folder','=',$child->id_folder)->get();
                if(count($files)>0){
                    foreach($files as $file){
                        if($file->tipe_kategori == 'ebook'){
                            $file_detail = FileDetail::where('id_file','=',$file->file_konten)->get();
                            if(count($file_detail) > 0){
                                foreach($file_detail as $data){
                                    $fd = FileDetail::find($data->id_fd);
                                    File::delete('assets/uploads/'.$fd->nama_fd);
                                    $fd->delete();
                                }
                            }
                            else{
                                File::delete('assets/uploads/'.$file->file_konten);
                            }
                        }
                        // Menghapus file tools
                        elseif($file->tipe_kategori == 'tools'){
                            File::delete('assets/tools/'.$file->file_konten);
                        }
                        $file->delete();
                    }
                }
            }
        }
			
		// Get data current folder
		$current_folder = Folder::find($folder->folder_parent);

		// Kategori folder
		$kategori = FolderKategori::find($folder->folder_kategori);

		// Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil menghapus folder beserta isinya.']);
    }

    /**
     * Memindahkan folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        // Get data current folder
        $current_folder = Folder::find($request->destination);

        // Move file
        $folder = Folder::findOrFail($request->id);
        $folder->folder_parent = $request->destination;
        $folder->folder_dir = $current_folder->folder_dir."/".$folder->folder_nama;
        $folder->save();

        // Kategori folder
        $kategori = FolderKategori::find($folder->folder_kategori);

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil memindahkan folder.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/folder'), ['..png']));
    }
}
