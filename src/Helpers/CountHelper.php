<?php

use App\User;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Withdrawal;

/**
 *
 * Count Data
 * 
 */

// Menghitung jumlah data duplikat
if(!function_exists('count_existing_data')){
    function count_existing_data($table, $field, $keyword, $primaryKey, $id = null){
        if($id == null) $data = DB::table($table)->where($field,'=',$keyword)->get();
        else $data = DB::table($table)->where($field,'=',$keyword)->where($primaryKey,'!=',$id)->get();
        return count($data);
    }
}

/**
 *
 * Count Notifikasi
 * 
 */

// Menghitung semua notifikasi
if(!function_exists('count_notif_all')){
    function count_notif_all(){
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
        $data = PelatihanMember::where('fee_status','=',0)->count();
        return $data;
    }
}

/**
 *
 * Count by User
 * 
 */

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

/**
 *
 * Count by Pelatihan
 * 
 */

// Menghitung peserta pelatihan
if(!function_exists('count_peserta_pelatihan')){
    function count_peserta_pelatihan($pelatihan){
        $data = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan)->count();
        return $data;
    }
}