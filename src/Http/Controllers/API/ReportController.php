<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\User;
use Ajifatur\FaturCMS\Models\Acara;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Halaman;
use Ajifatur\FaturCMS\Models\Karir;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\Popup;
use Ajifatur\FaturCMS\Models\Program;
use Ajifatur\FaturCMS\Models\Psikolog;
use Ajifatur\FaturCMS\Models\Visitor;

class ReportController extends Controller
{
    /**
     * Report
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        if($request->ajax()){
            // Array
            $array = [];

            // Data Member
            if(has_access('UserController::index', Auth::user()->role, false)){
                $today = User::where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Member', 'today' => $today, 'total' => $total, 'parent' => true]);
            }

            // Data File
            if(has_access('FileController::index', Auth::user()->role, false)){
                $today = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('status_kategori','=',1)->whereDate('file_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('status_kategori','=',1)->whereDate('file_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'File', 'today' => $today, 'total' => $total, 'parent' => true]);

                foreach(array_kategori_folder() as $kategori){
                    $today = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('slug_kategori','=',$kategori->slug_kategori)->whereDate('file_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('slug_kategori','=',$kategori->slug_kategori)->whereDate('file_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $kategori->folder_kategori, 'today' => $today, 'total' => $total, 'parent' => false]); 
                }
            }

            // Data Halaman
            if(has_access('HalamanController::index', Auth::user()->role, false)){
                $today = Halaman::whereDate('halaman_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Halaman::whereDate('halaman_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Halaman', 'today' => $today, 'total' => $total, 'parent' => true]);

                for($i=1; $i<=2; $i++){
                    $today = Halaman::where('halaman_tipe','=',$i)->whereDate('halaman_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Halaman::where('halaman_tipe','=',$i)->whereDate('halaman_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => tipe_halaman($i), 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Artikel
            if(has_access('BlogController::index', Auth::user()->role, false)){
                $today = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->join('kontributor','blog.blog_kontributor','=','kontributor.id_kontributor')->whereDate('blog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->join('kontributor','blog.blog_kontributor','=','kontributor.id_kontributor')->whereDate('blog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Artikel', 'today' => $today, 'total' => $total, 'parent' => true]);
            }

            // Data Acara
            if(has_access('AcaraController::index', Auth::user()->role, false)){
                $today = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->whereDate('acara_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->whereDate('acara_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Acara', 'today' => $today, 'total' => $total, 'parent' => true]);
            }

            // Data Program
            if(has_access('ProgramController::index', Auth::user()->role, false)){
                $today = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->whereDate('program_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->whereDate('program_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Program', 'today' => $today, 'total' => $total, 'parent' => true]);
            }

            // Data Pelatihan
            if(has_access('PelatihanController::index', Auth::user()->role, false)){
                $today = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->whereDate('pelatihan_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->whereDate('pelatihan_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Pelatihan', 'today' => $today, 'total' => $total, 'parent' => true]);

                foreach(array_kategori_pelatihan() as $kategori){
                    $today = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->where('kategori_pelatihan','=',$kategori->id_kp)->whereDate('pelatihan_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->where('kategori_pelatihan','=',$kategori->id_kp)->whereDate('pelatihan_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $kategori->kategori, 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Karir
            if(has_access('KarirController::index', Auth::user()->role, false)){
                $today = Karir::join('users','karir.author','=','users.id_user')->whereDate('karir_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Karir::join('users','karir.author','=','users.id_user')->whereDate('karir_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Karir', 'today' => $today, 'total' => $total, 'parent' => true]);
            }

            // Data Psikolog
            if(has_access('PsikologController::index', Auth::user()->role, false)){
                $today = Psikolog::whereDate('psikolog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Psikolog::whereDate('psikolog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Psikolog', 'today' => $today, 'total' => $total, 'parent' => true]);

                for($i=1; $i<=2; $i++){
                    $today = Psikolog::where('kategori_psikolog','=',$i)->whereDate('psikolog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Psikolog::where('kategori_psikolog','=',$i)->whereDate('psikolog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => psikolog($i), 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Pop-Up
            if(has_access('PopupController::index', Auth::user()->role, false)){
                $today = Popup::whereDate('popup_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Popup::whereDate('popup_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Pop-Up', 'today' => $today, 'total' => $total, 'parent' => true]);

                for($i=1; $i<=2; $i++){
                    $title = $i == 1 ? 'Gambar' : 'Video';
                    $today = Popup::where('popup_tipe','=',$i)->whereDate('popup_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Popup::where('popup_tipe','=',$i)->whereDate('popup_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $title, 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => $array
            ]);
        }
    }
}