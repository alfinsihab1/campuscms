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

// use Ajifatur\FaturCMS\Models\FilePath;
// use Ajifatur\FaturCMS\Models\FileDetail;
// use Ajifatur\FaturCMS\Models\FileReader;
// use Ajifatur\FaturCMS\Models\FileThumbnail;
// use Ajifatur\FaturCMS\Models\FolderIcon;
// use Ajifatur\FaturCMS\Models\KategoriMateri;

// use Ajifatur\FaturCMS\Models\Files2;
// use Ajifatur\FaturCMS\Models\Folder2;

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
            $file->file_nama = $request->nama_file;
            $file->file_kategori = $request->file_kategori;
            $file->file_deskripsi = $request->file_deskripsi != '' ? $request->file_deskripsi : '';
            $file->file_konten = $request->file_konten;
            $file->file_keterangan = $request->file_kategori == 1 ? htmlentities($request->file_keterangan) : '';
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
		// return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir='.$directory->folder_dir)->with(['message' => 'Berhasil menambah file.']);
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
	 * int $id
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function availableFolders($id)
    {
		return Folder::where('folder_kategori','=',$id)->orWhere('folder_kategori','=',0)->orderBy('folder_parent','asc')->orderBy('folder_nama','asc')->get();
    }
}
