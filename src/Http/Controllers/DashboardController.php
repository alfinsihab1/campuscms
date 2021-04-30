<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Deskripsi;
use Ajifatur\FaturCMS\Models\DefaultRekening;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Fitur;
use Ajifatur\FaturCMS\Models\FolderKategori;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\Popup;
use Ajifatur\FaturCMS\Models\Signature;
use Ajifatur\FaturCMS\Models\Visitor;

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

        // Data Member Aktif
        $data_student_aktif = User::where('is_admin','=',0)->where('status','=',1)->count();
        // Data Member Belum Aktif
        $data_student_belum_aktif = User::where('is_admin','=',0)->where('status','=',0)->count();
        
        // New Array
        $array = [
            ['data' => 'Member Aktif', 'total' => $data_student_aktif, 'url' => route('admin.user.index', ['filter' => 'aktif'])],
            ['data' => 'Member Belum Aktif', 'total' => $data_student_belum_aktif, 'url' => route('admin.user.index', ['filter' => 'belum-aktif'])],
        ];

        // New Array Card
        $array_card = [];
        
        // Array Push Data Materi
        $kategori_materi = FolderKategori::where('tipe_kategori','=','ebook')->get();
        foreach($kategori_materi as $data){
            $file = Files::where('file_kategori','=',$data->id_fk)->count();
            // array_push($array, ['data' => 'Materi '.$data->folder_kategori, 'total' => $file, 'url' => route('admin.filemanager.index', ['kategori' => $data->slug_kategori])]);
            array_push($array_card, ['data' => $data->folder_kategori, 'total' => $file, 'url' => route('admin.filemanager.index', ['kategori' => $data->slug_kategori])]);
        }
        
        // Array Push Data Course, Data Artikel, Data Pelatihan
        $data_course = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('tipe_kategori','=','video')->count();
        $data_artikel = Blog::join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->count();
        $data_pelatihan = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->count();
        array_push($array, 
            // ['data' => 'Materi E-Course', 'total' => $data_course, 'url' => route('admin.filemanager.index', ['kategori' => 'e-course'])],
            ['data' => 'Artikel', 'total' => $data_artikel, 'url' => route('admin.blog.index')],
            ['data' => 'Pelatihan', 'total' => $data_pelatihan, 'url' => route('admin.pelatihan.index')],
        );
        array_push($array_card, ['data' => 'E-Course', 'total' => $data_course, 'url' => route('admin.filemanager.index', ['kategori' => 'e-course'])]);
        
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
    
    /**
     * Count visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function countVisitor()
    {
        // Get data last 7 days
        $array = array();
        for($i=7; $i>=0; $i--){
            $date = date('Y-m-d', strtotime('-'.$i.' days'));
            $visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();
            $visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();
            array_push($array, array(
                'date' => $date,
                'date_str' => date('d/m/y', strtotime($date)),
                'visitor_all' => count($visitor_admin) + count($visitor_member),
                'visitor_admin' => count($visitor_admin),
                'visitor_member' => count($visitor_member),
            ));
        }
        echo json_encode($array);
    }
}
