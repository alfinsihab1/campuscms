<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;

class MediaController extends Controller
{
    /**
     * Array data media
     *
     * @var array
     */
    public $directory = [
        'acara' => ['title' => 'Acara', 'dir' => 'images/acara', 'type' => 'content', 'table' => 'acara', 'column' => 'gambar_acara', 'access' => 'AcaraController::index'],
        'blog' => ['title' => 'Artikel', 'dir' => 'images/blog', 'type' => 'content', 'table' => 'blog', 'column' => 'blog_gambar', 'access' => 'BlogController::index'],
        'file' => ['title' => 'File', 'dir' => 'images/file', 'type' => 'content', 'table' => 'file', 'column' => 'file_thumbnail', 'access' => 'FileController::index'],
        // 'file-detail' => ['title' => 'File Detail', 'dir' => 'uploads', 'type' => 'content', 'table' => 'file_detail', 'column' => 'nama_fd', 'access' => 'FileController::index'],
        'fitur' => ['title' => 'Fitur', 'dir' => 'images/fitur', 'type' => 'content', 'table' => 'fitur', 'column' => 'gambar_fitur', 'access' => 'FiturController::index'],
        'folder' => ['title' => 'Folder', 'dir' => 'images/folder', 'type' => 'content', 'table' => 'folder', 'column' => 'folder_icon', 'access' => 'FileController::index'],
        'icon' => ['title' => 'Icon', 'dir' => 'images/icon', 'type' => 'setting'],
        'karir' => ['title' => 'Karir', 'dir' => 'images/karir', 'type' => 'content', 'table' => 'karir', 'column' => 'karir_gambar', 'access' => 'KarirController::index'],
        'komisi' => ['title' => 'Komisi', 'dir' => 'images/komisi', 'type' => 'content', 'table' => 'komisi', 'column' => 'komisi_proof', 'access' => 'KomisiController::index'],
        'logo' => ['title' => 'Logo', 'dir' => 'images/logo', 'type' => 'setting'],
        'mentor' => ['title' => 'Mentor', 'dir' => 'images/mentor', 'type' => 'content', 'table' => 'mentor', 'column' => 'foto_mentor', 'access' => 'MentorController::index'],
        'mitra' => ['title' => 'Mitra', 'dir' => 'images/mitra', 'type' => 'content', 'table' => 'mitra', 'column' => 'logo_mitra', 'access' => 'MitraController::index'],
        'pelatihan' => ['title' => 'Pelatihan', 'dir' => 'images/pelatihan', 'type' => 'content', 'table' => 'pelatihan', 'column' => 'gambar_pelatihan', 'access' => 'PelatihanController::index'],
        'program' => ['title' => 'Program', 'dir' => 'images/program', 'type' => 'content', 'table' => 'program', 'column' => 'program_gambar', 'access' => 'ProgramController::index'],
        'slider' => ['title' => 'Slider', 'dir' => 'images/slider', 'type' => 'content', 'table' => 'slider', 'column' => 'slider', 'access' => 'SliderController::index'],
        'testimoni' => ['title' => 'Testimoni', 'dir' => 'images/testimoni', 'type' => 'content', 'table' => 'testimoni', 'column' => 'foto_klien', 'access' => 'TestimoniController::index'],
        'withdrawal' => ['title' => 'Withdrawal', 'dir' => 'images/withdrawal', 'type' => 'content', 'table' => 'withdrawal', 'column' => 'withdrawal_proof', 'access' => 'WithdrawalController::index'],
    ];

    /**
     * Menampilkan data media
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.media.index', [
          'directory' => $this->directory,
        ]);
    }

    /**
     * Menampilkan detail media
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Check kategori
        if(array_key_exists($request->query('category'), $this->directory)){
            // Get data file
            $files = generate_file(public_path('assets/'.$this->directory[$request->query('category')]['dir']), ['..png']);

            // Count folder size
            $folder_size = 0;
            if(count($files)>0){
                foreach($files as $file){
                    $file_size = File::size('assets/'.$this->directory[$request->query('category')]['dir'].'/'.$file);
                    $folder_size += $file_size;
                }
            }

            // File terpakai
            if($this->directory[$request->query('category')]['type'] == 'setting'){
                $file_used = [setting('site.'.$request->query('category'))];
            }
            elseif($this->directory[$request->query('category')]['type'] == 'content'){
                $file_used = DB::table($this->directory[$request->query('category')]['table'])->where($this->directory[$request->query('category')]['column'],'!=','')->get()->pluck($this->directory[$request->query('category')]['column'])->toArray();
            }
        }
        else{
            // Redirect ke index
            return redirect()->route('admin.media.index');
        }
        
        // View
        return view('faturcms::admin.media.detail', [
            'category' => $request->query('category'),
            'directory' => $this->directory,
            'files' => $files,
            'folder_size' => $folder_size,
            'file_used' => $file_used,
        ]);
    }

    /**
     * Menghapus media
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus file
        File::delete('assets/'.$this->directory[$request->category]['dir'].'/'.$request->file);
        
        // Redirect
        return redirect()->route('admin.media.detail', ['category' => $request->category])->with(['message' => 'Berhasil menghapus file.']);
    }

    /**
     * Menghapus media (batch)
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function deleteBatch(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus file batch
        $i = 0;
        if($this->directory[$request->category]['type'] == 'setting'){
            // Get data file
            $files = generate_file(public_path('assets/'.$this->directory[$request->category]['dir']), [setting('site.'.$request->category), '..png']);

            if(count($files)>0){
                foreach($files as $file){
                    // Menghapus file
                    $delete = File::delete('assets/'.$this->directory[$request->category]['dir'].'/'.$file);
                    if($delete) $i++;
                }
            }
        }
        elseif($this->directory[$request->category]['type'] == 'content'){
            // File used
            $file_used = DB::table($this->directory[$request->category]['table'])->where($this->directory[$request->category]['column'],'!=','')->get()->pluck($this->directory[$request->category]['column'])->toArray();
            // Get data file
            $files = generate_file(public_path('assets/'.$this->directory[$request->category]['dir']), array_merge($file_used, ['..png']));

            if(count($files)>0){
                foreach($files as $file){
                    // Menghapus file
                    $delete = File::delete('assets/'.$this->directory[$request->category]['dir'].'/'.$file);
                    if($delete) $i++;
                }
            }
        }
        
        // Redirect
        if($i > 0)
            return redirect()->route('admin.media.detail', ['category' => $request->category])->with(['message' => 'Berhasil menghapus file.']);
        else
            return redirect()->route('admin.media.detail', ['category' => $request->category])->with(['message' => 'Tidak ada file yang dihapus']);
    }
}
