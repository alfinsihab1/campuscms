<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Folder;
use Ajifatur\FaturCMS\Models\FolderKategori;
use Ajifatur\FaturCMS\Models\FileDetail;

class FileController extends Controller
{
    /**
     * Menampilkan data folder dan file
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->firstOrFail();

        // Jika role admin
        if(Auth::user()->is_admin == 1){
			// Get direktori
        	$directory = ($request->query('dir') == '/') ? Folder::find(1) : Folder::where('folder_dir','=',$request->query('dir'))->where('folder_kategori','=',$kategori->id_fk)->first();

        	// Jika direktori tidak ditemukan
        	if(!$directory){
				// Redirect to '/'
				return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => '/']);
        	}

			// Get folder dalam direktori
			$folders = Folder::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_nama','asc')->get();

			// Get file dalam direktori
			$files = Files::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();
			
            return view('faturcms::admin.file.index', [
				'kategori' => $kategori,
				'directory' => $directory,
                'folders' => $folders,
				'files' => $files,
				'available_folders' => $this->availableFolders($kategori->id_fk),
            ]);
        }
	}

    /**
     * Menampilkan form tambah file
     *
	 * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $category)
    {
		// Kategori
		$kategori = FolderKategori::where('slug_kategori','=',$category)->firstOrFail();

        // Jika role admin
        if(Auth::user()->is_admin == 1){
			// Get direktori
        	$directory = ($request->query('dir') == '/') ? Folder::find(1) : Folder::where('folder_dir','=',$request->query('dir'))->where('folder_kategori','=',$kategori->id_fk)->first();

        	// Jika direktori tidak ditemukan
        	if(!$directory){
				// Redirect to '/'
				return redirect()->route('admin.file.create', ['kategori' => $kategori->slug_kategori, 'dir' => '/']);
        	}
			
            return view('faturcms::admin.file.create-'.$kategori->tipe_kategori, [
				'kategori' => $kategori,
				'directory' => $directory,
            ]);
        }
	}
	
    /**
     * Menyimpan file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		// Kategori
		$kategori = FolderKategori::find($request->file_kategori);

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required|max:255',
            'file_konten' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
            	'nama_file'
            ]));
        }
        // Jika tidak ada error
        else{            
            // Menambah data
            $file = new Files;
            $file->id_folder = $request->id_folder;
            $file->id_user = Auth::user()->id_user;
            $file->file_nama = generate_file_name($request->nama_file, 'file2', 'file_nama', 'id_folder', $request->id_folder, 'id_file', null);
            $file->file_kategori = $request->file_kategori;
            $file->file_deskripsi = $request->file_deskripsi != '' ? $request->file_deskripsi : '';
            $file->file_konten = $request->file_konten;
            $file->file_keterangan = $request->file_kategori == tipe_file(1) ? htmlentities($request->file_keterangan) : '';
            $file->file_thumbnail = generate_image_name("assets/images/file/", $request->gambar, $request->gambar_url);
            $file->file_at = date('Y-m-d H:i:s');
            $file->file_up = date('Y-m-d H:i:s');
            $file->save();
			
			// Get data folder
            $current_folder = Folder::find($request->id_folder);
            
            // Kategori folder
            $kategori = FolderKategori::find($file->file_kategori);
        }

		// Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil menambah file.']);
	}

    /**
     * Menampilkan form edit file
     *
     * string $category
     * int $id
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $category, $id)
    {
        // Kategori
        $kategori = FolderKategori::where('slug_kategori','=',$category)->firstOrFail();

        // Jika role admin
        if(Auth::user()->is_admin == 1){
            // Get direktori
            $directory = ($request->query('dir') == '/') ? Folder::find(1) : Folder::where('folder_dir','=',$request->query('dir'))->where('folder_kategori','=',$kategori->id_fk)->first();

            // Jika direktori tidak ditemukan
            if(!$directory){
                // Redirect to '/'
                return redirect()->route('admin.file.edit', ['kategori' => $kategori->slug_kategori, 'dir' => '/']);
            }

            // Get file
            $file = Files::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->findOrFail($id);
            
            return view('faturcms::admin.file.edit-'.$kategori->tipe_kategori, [
                'kategori' => $kategori,
                'directory' => $directory,
                'file' => $file,
            ]);
        }
    }
    
    /**
     * Mengupdate file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Kategori
        $kategori = FolderKategori::find($request->file_kategori);

        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_file' => 'required|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_file'
            ]));
        }
        // Jika tidak ada error
        else{            
            // Mengupdate data
            $file = Files::find($request->id);
            $file->id_folder = $request->id_folder;
            $file->file_nama = generate_file_name($request->nama_file, 'file2', 'file_nama', 'id_folder', $request->id_folder, 'id_file', $request->id);
            $file->file_deskripsi = $request->file_deskripsi != '' ? $request->file_deskripsi : '';
            $file->file_konten = $request->file_kategori == tipe_file(1) ? $request->file_konten : $file->file_konten;
            $file->file_keterangan = $request->file_kategori == tipe_file(1) ? htmlentities($request->file_keterangan) : '';
            $file->file_thumbnail = generate_image_name("assets/images/file/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/file/", $request->gambar, $request->gambar_url) : $file->file_thumbnail;
            $file->save();
            
            // Get data folder
            $current_folder = Folder::find($request->id_folder);
            
            // Kategori folder
            $kategori = FolderKategori::find($file->file_kategori);
        }

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil mengupdate file.']);
    }

    /**
     * Menghapus file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Get file
        $file = Files::findOrFail($request->id);

        // Menghapus file ebook
        if($file->file_kategori > 3){
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
        elseif($file->file_kategori == 3){
            File::delete('assets/tools/'.$file->file_konten);
        }
        $file->delete();
            
        // Get data current folder
        $current_folder = Folder::find($file->id_folder);

        // Kategori folder
        $kategori = FolderKategori::find($file->file_kategori);

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil menghapus file.']);
    }

    /**
     * Memindahkan file
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        // Move file
        $file = Files::findOrFail($request->id);
        $file->id_folder = $request->destination;
        $file->save();
            
        // Get data current folder
        $current_folder = Folder::find($file->id_folder);

        // Kategori folder
        $kategori = FolderKategori::find($file->file_kategori);

        // Redirect
        return redirect()->route('admin.filemanager.index', ['kategori' => $kategori->slug_kategori, 'dir' => $current_folder->folder_dir])->with(['message' => 'Berhasil memindahkan file.']);
    }
    
    /**
     * Mengupload file PDF
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadPDF(Request $request)
    {
        // Get data
        $file_name = $request->name;

        // Save files
        $data = $request->code;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        
        $number = $request->key + 1;
        $number = add_zero($number);
        $file_detail_name = $file_name.'-'.$number.'.jpg';
        if(file_put_contents('assets/uploads/'.$file_detail_name, $data)){
            $file_detail = new FileDetail;
            $file_detail->id_file = $file_name;
            $file_detail->nama_fd = $file_detail_name;
            $file_detail->save();
        }
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/file')));
    }

    /**
     * Folder tersedia
     *
     * int $category
	 * int $i
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function availableFolders($category)
    {
        // Define id
        $id = 1;

        // Define folders
        $folders = [];

        // Get home folder and push to folders
        $home_folder = Folder::find($id);
        array_push($folders, [
            'id' => $home_folder->id_folder,
            'nama' => $home_folder->folder_nama,
            'parent' => $home_folder->folder_parent,
            'children' => []
        ]);

        // Return
        return $this->loopChildren($folders, $category);
    }

    /**
     * Folder children
     *
     * int $category
     * int $id
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getChildren($category, $id)
    {
        $array = [];
        $children = Folder::where('folder_kategori','=',$category)->where('folder_parent','=',$id)->get();
        if(count($children) > 0){
            foreach($children as $child){
                array_push($array, [
                    'id' => $child->id_folder,
                    'nama' => $child->folder_nama,
                    'parent' => $child->folder_parent,
                    'children' => []
                ]);
            }
        }
        return $array;
    }

    /**
     * Loop children
     *
     * array $parent
     * int $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function loopChildren($parent, $category)
    {
        $folders = $parent;

        if(count($folders)>0){
            foreach($folders as $key=>$folder){
                $children = $this->getChildren($category, $folder['id']);
                $folders[$key]['children'] = $this->loopChildren($children, $category);
            }
        }

        return $folders;
    }
}
