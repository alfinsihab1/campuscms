<?php

use App\User;
use Ajifatur\FaturCMS\Models\PelatihanMember;

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

// Menghitung peserta pelatihan
if(!function_exists('count_peserta_pelatihan')){
    function count_peserta_pelatihan($pelatihan){
        $data = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('id_pelatihan','=',$pelatihan)->count();
        return $data;
    }
}