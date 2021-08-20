<?php

/**
 * Count Helpers:
 * @method int count_member_aktif()
 * @method int count_notif_admin()
 * @method int count_notif_komisi()
 * @method int count_notif_withdrawal()
 * @method int count_notif_pelatihan()
 * @method int count_notif_member()
 * @method int count_notif_file(string $kategori)
 * @method int count_notif_pelatihan_member()
 * @method int count_refer(string $username)
 * @method int count_refer_aktif(string $username)
 * @method int count_peserta_pelatihan(int $pelatihan)
 * @method int count_artikel_by_kategori(int $kategori)
 * @method int count_komentar(int $artikel)
 * @method int count_kunjungan(int $user, string|array $jenis)
 * @method int count_churn_rate(int $month)
 * @method int count_pelatihan_member(int $user, array $tanggal)
 * @method int count_anggota_kelompok(int $id)
 * @method int count_user_by_kategori(int $id)
 * @method int count_penerima_email(array $receivers)
 */

use App\Models\User;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Kelompok;
use Ajifatur\FaturCMS\Models\Komentar;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Package;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;
use Ajifatur\FaturCMS\Models\Withdrawal;

// Menghitung semua member aktif
if(!function_exists('count_member_aktif')){
    function count_member_aktif(){
        $data = User::where('is_admin','=',0)->where('status','=',1)->count();
        return $data;
    }
}

// Menghitung semua notifikasi (admin)
if(!function_exists('count_notif_admin')){
    function count_notif_admin(){
        $data = count_notif_komisi() + count_notif_withdrawal() + count_notif_pelatihan();
        return $data;
    }
}

// Menghitung notifikasi komisi
if(!function_exists('count_notif_komisi')){
    function count_notif_komisi(){
        $data = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',0)->where('komisi_proof','!=','')->count();
        return $data;
    }
}

// Menghitung notifikasi withdrawal
if(!function_exists('count_notif_withdrawal')){
    function count_notif_withdrawal(){
        $data = Withdrawal::where('withdrawal_status','=',0)->count();
        return $data;
    }
}

// Menghitung notifikasi pelatihan
if(!function_exists('count_notif_pelatihan')){
    function count_notif_pelatihan(){
        $data = PelatihanMember::where('fee_status','=',0)->where('fee_bukti','!=','')->count();
        return $data;
    }
}

// Menghitung semua notifikasi (member)
if(!function_exists('count_notif_member')){
    function count_notif_member(){
        $data = count_notif_file('e-learning') + count_notif_file('e-library') + count_notif_file('e-competence') + count_notif_file('e-course') + count_notif_pelatihan_member();
        return $data;
    }
}

// Menghitung notifikasi file
if(!function_exists('count_notif_file')){
    function count_notif_file($kategori){
        $data = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->where('slug_kategori','=',$kategori)->whereDate('file_at','=',date('Y-m-d'))->count();
        return $data;
    }
}

// Menghitung notifikasi pelatihan member
if(!function_exists('count_notif_pelatihan_member')){
    function count_notif_pelatihan_member(){
        $data = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->whereDate('pelatihan_at','=',date('Y-m-d'))->count();
        return $data;
    }
}

// Menghitung refer
if(!function_exists('count_refer')){
    function count_refer($username){
        $data = User::where('reference','=',$username)->where('is_admin','=',0)->where('username','!=',$username)->count();
        return $data;
    }
}

// Menghitung refer aktif
if(!function_exists('count_refer_aktif')){
    function count_refer_aktif($username){
        $data = User::where('reference','=',$username)->where('is_admin','=',0)->where('username','!=',$username)->where('status','=',1)->count();
        return $data;
    }
}

// Menghitung peserta pelatihan
if(!function_exists('count_peserta_pelatihan')){
    function count_peserta_pelatihan($pelatihan){
        $data = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan)->where('fee_status','=',1)->count();
        return $data;
    }
}

// Menghitung jumlah artikel berdasarkan kategori
if(!function_exists('count_artikel_by_kategori')){
    function count_artikel_by_kategori($kategori){
        $data = Blog::join('users','blog.author','=','users.id_user')->join('kategori_artikel','blog.blog_kategori','=','kategori_artikel.id_ka')->where('blog_kategori','=',$kategori)->count();
        return $data;
    }
}

// Menghitung jumlah komentar dalam artikel
if(!function_exists('count_komentar')){
    function count_komentar($artikel){
        $data = Komentar::join('users','komentar.id_user','=','users.id_user')->join('blog','komentar.id_artikel','=','blog.id_blog')->where('komentar.id_artikel','=',$artikel)->count();
        return $data;
    }
}

// Menghitung jumlah kunjungan visitor
if(!function_exists('count_kunjungan')){
    function count_kunjungan($user, $jenis){
        if($jenis == 'all'){
            $data = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$user)->count();
            return $data;
        }
        elseif($jenis == 'today'){
            $data = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$user)->whereDate('visit_at','=',date('Y-m-d'))->count();
            return $data;
        }
        elseif(is_array($jenis)){
            if(count($jenis) == 2){
                $data = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$user)->whereDate('visit_at','>=',$jenis[0])->whereDate('visit_at','<=',$jenis[1])->count();
                return $data;
            }
            else return 0;
        }
        else{
            $data = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$user)->whereDate('visit_at','=',generate_date_format($jenis, 'y-m-d'))->count();
            return $data;
        }
    }
}

// Menghitung churn rate
if(!function_exists('count_churn_rate')){
    function count_churn_rate($month){
        if($month == 1 || $month == 2)
            $data = User::where('is_admin','=',0)->where('status','=',1)->whereDate('last_visit','<=',date('Y-m-d', strtotime('-'.$month.' month')))->whereDate('last_visit','>=',date('Y-m-d', strtotime('-'.($month + 1).' month')))->count();
        elseif($month == 3)
            $data = User::where('is_admin','=',0)->where('status','=',1)->whereDate('last_visit','<=',date('Y-m-d', strtotime('-'.$month.' month')))->count();
        return $data;
    }
}

// Menghitung jumlah pelatihan member
if(!function_exists('count_pelatihan_member')){
    function count_pelatihan_member($user, $tanggal = []){
        if($tanggal == [])
            $data = PelatihanMember::where('id_user','=',$user)->count();
        else{
            if(count($tanggal) == 2)
                $data = PelatihanMember::where('id_user','=',$user)->whereDate('pm_at','>=',$tanggal[0])->whereDate('pm_at','<=',$tanggal[1])->count();
            else
                $data = PelatihanMember::where('id_user','=',$user)->count();
        }
        return $data;
    }
}

// Menghitung jumlah anggota dalam kelompok
if(!function_exists('count_anggota_kelompok')){
    function count_anggota_kelompok($id){
        // Kelompok
        $kelompok = Kelompok::find($id);

        // Check kelompok
        if(!$kelompok) return 0;
        else{
            // Explode if exists
            $ids = explode(',', $kelompok->anggota_kelompok);

            if(count($ids)>0){
                $anggota = User::where('is_admin','=',0)->where('status','=',1)->whereIn('id_user',$ids)->count();
                return $anggota;
            }
            else return 0;
        }
    }
}

// Menghitung jumlah user berdasarkan kategori
if(!function_exists('count_user_by_kategori')){
    function count_user_by_kategori($id){
        $user = User::where('is_admin','=',0)->where('status','=',1)->where('user_kategori','=',$id)->count();
        return $user;
    }
}

// Menghitung jumlah penerima email
if(!function_exists('count_penerima_email')){
    function count_penerima_email($receivers){
        $explode = explode(",", $receivers);
        return $receivers != '' ? count($explode) : 0;
    }
}
