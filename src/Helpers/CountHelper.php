<?php

/**
 * Count Helpers:
 * @method count_existing_data(string $table, string $field, string $keyword, string $primaryKey, int $id = null)
 * @method count_notif_all()
 * @method count_notif_komisi()
 * @method count_notif_withdrawal()
 * @method count_notif_pelatihan()
 * @method count_refer(string $username)
 * @method count_refer_aktif(string $username)
 * @method count_peserta_pelatihan(int $pelatihan)
 * @method count_artikel_by_kategori(int $kategori)
 * @method count_komentar(int $artikel)
 * @method count_kunjungan(int $user, string $jenis)
 */

use App\User;
use Ajifatur\FaturCMS\Models\Blog;
use Ajifatur\FaturCMS\Models\Komentar;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Package;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;
use Ajifatur\FaturCMS\Models\Withdrawal;

// Menghitung jumlah data duplikat
if(!function_exists('count_existing_data')){
    function count_existing_data($table, $field, $keyword, $primaryKey, $id = null){
        if($id == null) $data = DB::table($table)->where($field,'=',$keyword)->count();
        else $data = DB::table($table)->where($field,'=',$keyword)->where($primaryKey,'!=',$id)->count();
        return $data;
    }
}

// Menghitung semua notifikasi
if(!function_exists('count_notif_all')){
    function count_notif_all(){
        $data = count_notif_komisi() + count_notif_withdrawal() + count_notif_pelatihan() + count_notif_package();
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
        $data = PelatihanMember::where('fee_status','=',0)->count();
        return $data;
    }
}

// Menghitung notifikasi package
if(!function_exists('count_notif_package')){
    function count_notif_package(){
        $package = Package::where('package_name','=',config('faturcms.name'))->first();
        if($package){
            return $package->package_version == package_version() ? 0 : 1;
        }
        return 1;
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
        $data = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan)->count();
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
        else{
            $data = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$user)->whereDate('visit_at','=',generate_date_format($jenis, 'y-m-d'))->count();
            return $data;
        }
    }
}
