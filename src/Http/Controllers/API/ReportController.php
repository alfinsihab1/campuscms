<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Acara;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Cabang;
use Ajifatur\FaturCMS\Models\Email;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Fitur;
use Ajifatur\FaturCMS\Models\Halaman;
use Ajifatur\FaturCMS\Models\Karir;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Mentor;
use Ajifatur\FaturCMS\Models\Mitra;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Platform;
use Ajifatur\FaturCMS\Models\Popup;
use Ajifatur\FaturCMS\Models\Program;
use Ajifatur\FaturCMS\Models\Psikolog;
use Ajifatur\FaturCMS\Models\Rekening;
use Ajifatur\FaturCMS\Models\Signature;
use Ajifatur\FaturCMS\Models\Slider;
use Ajifatur\FaturCMS\Models\Testimoni;
use Ajifatur\FaturCMS\Models\Visitor;
use Ajifatur\FaturCMS\Models\Withdrawal;

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
            // Variables
            $array = [];
            $sumToday = 0;
            $sumTotal = 0;

            // Data Member
            if(has_access('UserController::index', Auth::user()->role, false)){
                // Data Member
                $today = User::where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Member', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Trainer
                $today = User::where('role','=',role('trainer'))->where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('role','=',role('trainer'))->where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => role(role('trainer')), 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Student
                $today = User::where('role','=',role('student'))->where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('role','=',role('student'))->where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => role(role('student')), 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Aktif
                $today = User::where('status','=',1)->where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('status','=',1)->where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Aktif', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Belum Aktif
                $today = User::where('status','=',0)->where('email_verified','=',1)->where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('status','=',0)->where('email_verified','=',1)->where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Belum Aktif', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Tidak Aktif
                $today = User::where('status','=',0)->where('email_verified','=',0)->where('is_admin','=',0)->whereDate('register_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = User::where('status','=',0)->where('email_verified','=',0)->where('is_admin','=',0)->whereDate('register_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Tidak Aktif', 'today' => $today, 'total' => $total, 'parent' => false]);
            }

            // Data Transaksi Komisi
            if(has_access('KomisiController::index', Auth::user()->role, false)){
                // Data Transaksi Komisi
                $today = Komisi::join('users','komisi.id_user','=','users.id_user')->whereDate('komisi_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Komisi::join('users','komisi.id_user','=','users.id_user')->whereDate('komisi_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Transaksi Komisi', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Komisi Diterima
                $today = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereDate('komisi_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereDate('komisi_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Diterima', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Komisi Belum Diverifikasi
                $today = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','!=','')->whereDate('komisi_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','!=','')->whereDate('komisi_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Belum Diverifikasi', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Komisi Belum Dibayar
                $today = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','=','')->whereDate('komisi_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','=','')->whereDate('komisi_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Belum Dibayar', 'today' => $today, 'total' => $total, 'parent' => false]);
            }

            // Data Transaksi Withdrawal
            if(has_access('WithdrawalController::index', Auth::user()->role, false)){
                // Data Transaksi Withdrawal
                $today = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->whereDate('withdrawal_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->whereDate('withdrawal_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Transaksi Withdrawal', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Withdrawal Diterima
                $today = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal_status','=',1)->whereDate('withdrawal_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal_status','=',1)->whereDate('withdrawal_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Diterima', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Withdrawal Sedang Diproses
                $today = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal_status','=',0)->whereDate('withdrawal_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal_status','=',0)->whereDate('withdrawal_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Sedang Diproses', 'today' => $today, 'total' => $total, 'parent' => false]);
            }

            // Data Transaksi Pelatihan
            if(has_access('PelatihanController::transaction', Auth::user()->role, false)){
                // Data Transaksi Pelatihan
                $today = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->whereDate('pm_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->whereDate('pm_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Transaksi Pelatihan', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Transaksi Pelatihan Diterima
                $today = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',1)->whereDate('pm_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',1)->whereDate('pm_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Diterima', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Transaksi Pelatihan Belum Diverifikasi
                $today = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',0)->where('fee_bukti','!=','')->whereDate('pm_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',0)->where('fee_bukti','!=','')->whereDate('pm_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Belum Diverifikasi', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Transaksi Pelatihan Belum Dibayar
                $today = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',0)->where('fee_bukti','=','')->whereDate('pm_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('fee_status','=',0)->where('fee_bukti','=','')->whereDate('pm_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Belum Dibayar', 'today' => $today, 'total' => $total, 'parent' => false]);
            }

            // Data File
            if(has_access('FileController::index', Auth::user()->role, false)){
                // Data File
                $today = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('status_kategori','=',1)->whereDate('file_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('status_kategori','=',1)->whereDate('file_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'File', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data File by Kategori
                foreach(array_kategori_folder() as $kategori){
                    $today = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('slug_kategori','=',$kategori->slug_kategori)->whereDate('file_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('slug_kategori','=',$kategori->slug_kategori)->whereDate('file_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $kategori->folder_kategori, 'today' => $today, 'total' => $total, 'parent' => false]); 
                }
            }

            // Data Halaman
            if(has_access('HalamanController::index', Auth::user()->role, false)){
                // Data Halaman
                $today = Halaman::whereDate('halaman_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Halaman::whereDate('halaman_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Halaman', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Halaman by Tipe
                for($i=1; $i<=2; $i++){
                    $today = Halaman::where('halaman_tipe','=',$i)->whereDate('halaman_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Halaman::where('halaman_tipe','=',$i)->whereDate('halaman_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => tipe_halaman($i), 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Artikel
            if(has_access('BlogController::index', Auth::user()->role, false)){
                // Data Artikel
                $today = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->join('kontributor','blog.blog_kontributor','=','kontributor.id_kontributor')->whereDate('blog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->join('kontributor','blog.blog_kontributor','=','kontributor.id_kontributor')->whereDate('blog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Artikel', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;
            }

            // Data Acara
            if(has_access('AcaraController::index', Auth::user()->role, false)){
                // Data Acara
                $today = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->whereDate('acara_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->whereDate('acara_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Acara', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;
            }

            // Data Program
            if(has_access('ProgramController::index', Auth::user()->role, false)){
                // Data Program
                $today = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->whereDate('program_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Program::join('users','program.author','=','users.id_user')->join('kategori_program','program.program_kategori','=','kategori_program.id_kp')->whereDate('program_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Program', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;
            }

            // Data Pelatihan
            if(has_access('PelatihanController::index', Auth::user()->role, false)){
                // Data Pelatihan
                $today = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_from','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_from','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Pelatihan', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Pelatihan by Kategori
                foreach(array_kategori_pelatihan() as $kategori){
                    $today = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->where('kategori_pelatihan','=',$kategori->id_kp)->whereDate('tanggal_pelatihan_from','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Pelatihan::join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->join('users','pelatihan.trainer','=','users.id_user')->where('kategori_pelatihan','=',$kategori->id_kp)->whereDate('tanggal_pelatihan_from','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $kategori->kategori, 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Karir
            if(has_access('KarirController::index', Auth::user()->role, false)){
                // Data Karir
                $today = Karir::join('users','karir.author','=','users.id_user')->whereDate('karir_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Karir::join('users','karir.author','=','users.id_user')->whereDate('karir_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Karir', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;
            }

            // Data Psikolog
            if(has_access('PsikologController::index', Auth::user()->role, false)){
                // Data Psikolog
                $today = Psikolog::whereDate('psikolog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Psikolog::whereDate('psikolog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Psikolog', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Psikolog by Kategori
                for($i=1; $i<=2; $i++){
                    $today = Psikolog::where('kategori_psikolog','=',$i)->whereDate('psikolog_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Psikolog::where('kategori_psikolog','=',$i)->whereDate('psikolog_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => psikolog($i), 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Pop-Up
            if(has_access('PopupController::index', Auth::user()->role, false)){
                // Data Pop-Up
                $today = Popup::whereDate('popup_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Popup::whereDate('popup_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Pop-Up', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Pop-Up by Tipe
                for($i=1; $i<=2; $i++){
                    $title = $i == 1 ? 'Gambar' : 'Video';
                    $today = Popup::where('popup_tipe','=',$i)->whereDate('popup_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    $total = Popup::where('popup_tipe','=',$i)->whereDate('popup_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                    array_push($array, ['title' => $title, 'today' => $today, 'total' => $total, 'parent' => false]);
                }
            }

            // Data Email
            if(has_access('EmailController::index', Auth::user()->role, false)){
                // Data Email
                $today = Email::join('users','email.sender','=','users.id_user')->whereDate('sent_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Email::join('users','email.sender','=','users.id_user')->whereDate('sent_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Email', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;

                // Data Email Terjadwal
                $today = Email::join('users','email.sender','=','users.id_user')->where('scheduled','!=',null)->whereDate('sent_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Email::join('users','email.sender','=','users.id_user')->where('scheduled','!=',null)->whereDate('sent_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Terjadwal', 'today' => $today, 'total' => $total, 'parent' => false]);

                // Data Email Tidak Terjadwal
                $today = Email::join('users','email.sender','=','users.id_user')->where('scheduled','=',null)->whereDate('sent_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Email::join('users','email.sender','=','users.id_user')->where('scheduled','=',null)->whereDate('sent_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Tidak Terjadwal', 'today' => $today, 'total' => $total, 'parent' => false]);
            }

            // Data Package
            if(has_access('PackageController::index', Auth::user()->role, false)){
                // Data Package
                $total = count(composer_lock()['packages']);
                array_push($array, ['title' => 'Package', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Platform
            if(has_access('PlatformController::index', Auth::user()->role, false)){
                // Data Platform
                $total = Platform::count();
                array_push($array, ['title' => 'Platform', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;

                // Data Platform Bank
                $total = Platform::where('tipe_platform','=',1)->count();
                array_push($array, ['title' => 'Bank', 'today' => '-', 'total' => $total, 'parent' => false]);

                // Data Platform Fintech
                $total = Platform::where('tipe_platform','=',2)->count();
                array_push($array, ['title' => 'Fintech', 'today' => '-', 'total' => $total, 'parent' => false]);
            }

            // Data Rekening
            if(has_access('RekeningController::index', Auth::user()->role, false)){
                // Data Rekening
                $total = Rekening::join('users','rekening.id_user','=','users.id_user')->join('platform','rekening.id_platform','=','platform.id_platform')->count();
                array_push($array, ['title' => 'Rekening', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Slider
            if(has_access('SliderController::index', Auth::user()->role, false)){
                // Data Slider
                $total = Slider::count();
                array_push($array, ['title' => 'Slider', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Fitur
            if(has_access('FiturController::index', Auth::user()->role, false)){
                // Data Fitur
                $total = Fitur::count();
                array_push($array, ['title' => 'Fitur', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Cabang
            if(has_access('CabangController::index', Auth::user()->role, false)){
                // Data Cabang
                $total = Cabang::count();
                array_push($array, ['title' => 'Cabang', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Mitra
            if(has_access('MitraController::index', Auth::user()->role, false)){
                // Data Mitra
                $total = Mitra::count();
                array_push($array, ['title' => 'Mitra', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Mentor
            if(has_access('MentorController::index', Auth::user()->role, false)){
                // Data Mentor
                $total = Mentor::count();
                array_push($array, ['title' => 'Mentor', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Testimoni
            if(has_access('TestimoniController::index', Auth::user()->role, false)){
                // Data Testimoni
                $total = Testimoni::count();
                array_push($array, ['title' => 'Testimoni', 'today' => '-', 'total' => $total, 'parent' => true]);
                $sumTotal += $total;
            }

            // Data Tandatangan Digital
            if(has_access('SignatureController::index', Auth::user()->role, false)){
                // Data Tandatangan Digital
                $today = Signature::join('users','signature.id_user','=','users.id_user')->whereDate('signature_at','=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                $total = Signature::join('users','signature.id_user','=','users.id_user')->whereDate('signature_at','<=',generate_date_format($request->query('tanggal'), 'y-m-d'))->count();
                array_push($array, ['title' => 'Tandatangan Digital', 'today' => $today, 'total' => $total, 'parent' => true]);
                $sumToday += $today;
                $sumTotal += $total;
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'data' => $array,
                    'today' => $sumToday,
                    'total' => $sumTotal
                ]
            ]);
        }
    }
}