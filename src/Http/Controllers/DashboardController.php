<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
use Ajifatur\FaturCMS\Models\Acara;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Deskripsi;
use Ajifatur\FaturCMS\Models\DefaultRekening;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Fitur;
use Ajifatur\FaturCMS\Models\FolderKategori;
use Ajifatur\FaturCMS\Models\Halaman;
use Ajifatur\FaturCMS\Models\Karir;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\Popup;
use Ajifatur\FaturCMS\Models\Program;
use Ajifatur\FaturCMS\Models\Psikolog;
use Ajifatur\FaturCMS\Models\Signature;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     * 
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Array
        $array = [];

        // Data User
        if(has_access('UserController::index', Auth::user()->role, false)){
            // Data Member Aktif
            $data_student_aktif = User::where('is_admin','=',0)->where('status','=',1)->count();
            // Data Member Belum Aktif
            $data_student_belum_aktif = User::where('is_admin','=',0)->where('status','=',0)->count();
            // Array Push
            array_push($array, ['title' => 'Member Aktif', 'total' => $data_student_aktif, 'url' => route('admin.user.index', ['filter' => 'aktif'])]);
            array_push($array, ['title' => 'Member Belum Aktif', 'total' => $data_student_belum_aktif, 'url' => route('admin.user.index', ['filter' => 'belum-aktif'])]);
        }

        // Data Halaman
        if(has_access('HalamanController::index', Auth::user()->role, false)){
            // Data Halaman
            $data_halaman = Halaman::count();
            // Array Push
            array_push($array, ['title' => 'Halaman', 'total' => $data_halaman, 'url' => route('admin.halaman.index')]);
        }

        // Data Artikel
        if(has_access('BlogController::index', Auth::user()->role, false)){
            // Data Artikel
            $data_artikel = Blog::join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->count();
            // Array Push
            array_push($array, ['title' => 'Artikel', 'total' => $data_artikel, 'url' => route('admin.blog.index')]);
        }

        // Data Acara
        if(has_access('AcaraController::index', Auth::user()->role, false)){
            // Data Acara
            $data_acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->count();
            // Array Push
            array_push($array, ['title' => 'Acara', 'total' => $data_acara, 'url' => route('admin.acara.index')]);
        }

        // Data Program
        if(has_access('ProgramController::index', Auth::user()->role, false)){
            // Data Program
            $data_program = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->count();
            // Array Push
            array_push($array, ['title' => 'Program', 'total' => $data_program, 'url' => route('admin.program.index')]);
        }

        // Data Pelatihan
        if(has_access('PelatihanController::index', Auth::user()->role, false)){
            // Data Pelatihan
            $data_pelatihan = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Pelatihan', 'total' => $data_pelatihan, 'url' => route('admin.pelatihan.index')]);
        }

        // Data Karir
        if(has_access('KarirController::index', Auth::user()->role, false)){
            // Data Karir
            $data_karir = Karir::join('users','karir.author','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Karir', 'total' => $data_karir, 'url' => route('admin.karir.index')]);
        }

        // Data Psikolog
        if(has_access('PsikologController::index', Auth::user()->role, false)){
            // Data Psikolog
            $data_psikolog = Psikolog::count();
            // Array Push
            array_push($array, ['title' => 'Psikolog', 'total' => $data_psikolog, 'url' => route('admin.psikolog.index')]);
        }
        
        // Array Push Data File
        $array_card = [];
        $folder_kategori = FolderKategori::where('tipe_kategori','=','ebook')->orWhere('tipe_kategori','=','video')->get();
        foreach($folder_kategori as $data){
            $file = Files::join('folder','file.id_folder','=','folder.id_folder')->where('file_kategori','=',$data->id_fk)->count();
            array_push($array_card, ['title' => $data->folder_kategori, 'total' => $file, 'url' => route('admin.filemanager.index', ['kategori' => $data->slug_kategori])]);
        }
        
        // View
        return view('faturcms::admin.dashboard.index', [
            'array' => $array,
            'array_card' => $array_card,
        ]);
    }
    
    /**
     * Menampilkan dashboard member
     * 
     * @return \Illuminate\Http\Response
     */
    public function member()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // Get deskripsi
        $deskripsi = Deskripsi::first();

        // Get data fitur
        $fitur = Fitur::orderBy('order_fitur','asc')->get();

        // Get data default rekening
        $default_rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('tipe_platform','asc')->get();

        // Get data komisi
        $komisi = Komisi::where('id_user','=',Auth::user()->id_user)->first();
        
        // Get data pop-up
        $popup = Popup::whereDate('popup_from','<=',date('Y-m-d'))->whereDate('popup_to','>=',date('Y-m-d'))->orderBy('popup_to','asc')->get();

        // Get data signature
        $signature = Signature::where('id_user','=',Auth::user()->id_user)->first();
        
        if(Auth::user()->role == role('trainer')){
            // Data pelatihan (kecuali yang dia traineri)
            $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','!=',Auth::user()->id_user)->whereDate('tanggal_pelatihan_from','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
        }
        elseif(Auth::user()->role == role('student')){
            // Data pelatihan
            $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_from','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
        }

        // View
        return view('faturcms::member.dashboard.index', [
            'default_rekening' => $default_rekening,
            'deskripsi' => $deskripsi,
            'fitur' => $fitur,
            'komisi' => $komisi,
            'pelatihan' => $pelatihan,
            'popup' => $popup,
            'signature' => $signature,
        ]);
    }
}
