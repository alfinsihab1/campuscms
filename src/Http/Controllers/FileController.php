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
			// Get direktori value
        	$dir = $request->query('dir');

			// Jika direktori == null
			if($dir == null){
				// Get direktori default
				$directory = Folder::find(1);
				// Get folder dalam direktori
				$folders = Folder::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
				// Get file dalam direktori
				$files = Files::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();
				// Redirect
				return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
			}
			// Jika direktori != null
			else{
				// Jika direktori == '/'
				if($dir == '/')
					$directory = Folder::where('folder_dir','=',$dir)->first();
				// Jika direktori != '/'
				else
					$directory = Folder::where('folder_dir','=',$dir)->where('folder_kategori','=',$kategori->id_fk)->first();
				
				// Jika direktori tidak ditemukan, akan redirect ke direktori default
				if(!$directory){
					// Get direktori default
					$directory = Folder::find(1);
					// Get folder dalam direktori
					$folders = Folder::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();
					// Redirect
					return redirect('/admin/file-manager/'.generate_permalink($kategori->folder_kategori).'?dir=/');
				}
				// Jika direktori ditemukan
				else{
					// Get folder dalam direktori
					$folders = Folder::where('folder_parent','=',$directory->id_folder)->where('folder_kategori','=',$kategori->id_fk)->orderBy('folder_up','desc')->get();
					// Get file dalam direktori
					$files = Files::where('id_folder','=',$directory->id_folder)->where('file_kategori','=',$kategori->id_fk)->orderBy('file_nama','asc')->get();

				}
			}

			// Breadcrumb
			$breadcrumb = [$directory];
			$d = $directory;
			while($d->folder_parent != 0){
				$d = Folder::find($d->folder_parent);
				array_push($breadcrumb, $d);
			}
			
			// Folder icon
			// $folder_icon = FolderIcon::all();
			
			// File Thumbnail
			// $file_thumbnail = FileThumbnail::all();
			
			// Folder tersedia
			$available_folders = Folder::where('folder_kategori','=',$kategori->id_fk)->orWhere('folder_kategori','=',0)->orderBy('folder_parent','asc')->orderBy('folder_nama','asc')->get();
			
            return view('faturcms::admin.file.index', [
				'available_folders' => $available_folders,
				'directory' => $directory,
				// 'file_thumbnail' => $file_thumbnail,
				// 'folder_icon' => $folder_icon,
                'folders' => $folders,
				'files' => $files,
				'kategori' => $kategori,
				'breadcrumb' => array_reverse($breadcrumb),
            ]);
        }
	}
}
