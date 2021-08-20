<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Acara;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Deskripsi;
use Ajifatur\FaturCMS\Models\DefaultRekening;
use Ajifatur\FaturCMS\Models\Email;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Fitur;
use Ajifatur\FaturCMS\Models\FolderKategori;
use Ajifatur\FaturCMS\Models\Halaman;
use Ajifatur\FaturCMS\Models\Karir;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Popup;
use Ajifatur\FaturCMS\Models\Program;
use Ajifatur\FaturCMS\Models\Psikolog;
use Ajifatur\FaturCMS\Models\Signature;
use Ajifatur\FaturCMS\Models\Withdrawal;

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

        // Data Halaman
        if(has_access('HalamanController::index', Auth::user()->role, false)){
            // Data Halaman
            $data_halaman = Halaman::count();
            // Array Push
            array_push($array, ['title' => 'Halaman', 'icon' => 'fa-newspaper-o', 'total' => $data_halaman, 'url' => route('admin.halaman.index')]);
        }

        // Data Artikel
        if(has_access('BlogController::index', Auth::user()->role, false)){
            // Data Artikel
            $data_artikel = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->join('kontributor','blog.blog_kontributor','=','kontributor.id_kontributor')->count();
            // Array Push
            array_push($array, ['title' => 'Artikel', 'icon' => 'fa-pencil', 'total' => $data_artikel, 'url' => route('admin.blog.index')]);
        }

        // Data Acara
        if(has_access('AcaraController::index', Auth::user()->role, false)){
            // Data Acara
            $data_acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->count();
            // Array Push
            array_push($array, ['title' => 'Acara', 'icon' => 'fa-calendar', 'total' => $data_acara, 'url' => route('admin.acara.index')]);
        }

        // Data Program
        if(has_access('ProgramController::index', Auth::user()->role, false)){
            // Data Program
            $data_program = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->count();
            // Array Push
            array_push($array, ['title' => 'Program', 'icon' => 'fa-paper-plane', 'total' => $data_program, 'url' => route('admin.program.index')]);
        }

        // Data Pelatihan
        if(has_access('PelatihanController::index', Auth::user()->role, false)){
            // Data Pelatihan
            $data_pelatihan = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Pelatihan', 'icon' => 'fa-graduation-cap', 'total' => $data_pelatihan, 'url' => route('admin.pelatihan.index')]);
        }

        // Data Karir
        if(has_access('KarirController::index', Auth::user()->role, false)){
            // Data Karir
            $data_karir = Karir::join('users','karir.author','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Karir', 'icon' => 'fa-handshake-o', 'total' => $data_karir, 'url' => route('admin.karir.index')]);
        }

        // Data Psikolog
        if(has_access('PsikologController::index', Auth::user()->role, false)){
            // Data Psikolog
            $data_psikolog = Psikolog::count();
            // Array Push
            array_push($array, ['title' => 'Psikolog', 'icon' => 'fa-skyatlas', 'total' => $data_psikolog, 'url' => route('admin.psikolog.index')]);
        }

        // Data Email
        if(has_access('EmailController::index', Auth::user()->role, false)){
            // Data Email
            $data_email = Email::join('users','email.sender','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Email', 'icon' => 'fa-envelope', 'total' => $data_email, 'url' => route('admin.email.index')]);
        }

        // Data Transaksi Withdrawal
        if(has_access('WithdrawalController::index', Auth::user()->role, false)){
            // Data Withdrawal
            $data_withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->count();
            // Array Push
            array_push($array, ['title' => 'Tran. Withdrawal', 'icon' => 'fa-credit-card', 'total' => $data_withdrawal, 'url' => route('admin.withdrawal.index')]);
        }

        // Data Transaksi Pelatihan
        if(has_access('PelatihanController::transaction', Auth::user()->role, false)){
            // Data Pelatihan
            $data_transaksi_pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->count();
            // Array Push
            array_push($array, ['title' => 'Tran. Pelatihan', 'icon' => 'fa-credit-card', 'total' => $data_transaksi_pelatihan, 'url' => route('admin.pelatihan.transaction')]);
        }
        
        // Array Push Data File
        $array_card = [];
        $folder_kategori = FolderKategori::whereIn('slug_kategori',['e-learning','e-library','e-competence','e-course'])->get();
        foreach($folder_kategori as $data){
            $file = Files::join('folder','file.id_folder','=','folder.id_folder')->where('file_kategori','=',$data->id_fk)->count();
            array_push($array_card, ['title' => $data->folder_kategori, 'total' => $file, 'url' => route('admin.filemanager.index', ['kategori' => $data->slug_kategori])]);
        }

        // Data User
        $array_card_user = [];
        if(has_access('UserController::index', Auth::user()->role, false)){
            // Data Member Aktif
            $data_student_aktif = User::where('is_admin','=',0)->where('status','=',1)->count();
            // Data Member Belum Aktif
            $data_student_belum_aktif = User::where('is_admin','=',0)->where('status','=',0)->count();
            // Array Push
            array_push($array_card_user, ['title' => 'Aktif', 'total' => $data_student_aktif, 'url' => route('admin.user.index', ['filter' => 'aktif'])]);
            array_push($array_card_user, ['title' => 'Belum Aktif','total' => $data_student_belum_aktif, 'url' => route('admin.user.index', ['filter' => 'belum-aktif'])]);
        }
        
        // View
        return view('faturcms::admin.dashboard.index', [
            'array' => $array,
            'array_card' => $array_card,
            'array_card_user' => $array_card_user,
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
