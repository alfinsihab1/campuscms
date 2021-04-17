<?php

use App\User;
use Ajifatur\FaturCMS\Models\KategoriMateri;
use Ajifatur\FaturCMS\Models\KategoriPelatihan;
use Ajifatur\FaturCMS\Models\Permission;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\RolePermission;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\Tag;

/**
 *
 * Main Helpers
 * 
 */

// Get has access
if(!function_exists('has_access')){
    function has_access($permission, $role, $isAbort = true){
        // Get permission
        $data_permission = Permission::where('key_permission','=',$permission)->first();

        // Jika tidak ada data permission
        if(!$data_permission){
            if($isAbort) abort(403);
            else return false;
        }

        // Get role permission
        $role_permission = RolePermission::where('id_permission','=',$data_permission->id_permission)->where('id_role','=',$role)->first();

        // Return
        if($role_permission){
            if($role_permission->access == 1) return true;
            else{
                if($isAbort) abort(403);
                else return false;
            }
        }
        else{
            if($isAbort) abort(403);
            else return false;
        }
    }
}

// Get role
if(!function_exists('role')){
    function role($key){
        if(is_int($key)){
            // Get nama role
            $role = Role::find($key);
            return $role ? $role->nama_role : null;
        }
        elseif(is_string($key)){
            // Get id role
            $role = Role::where('key_role','=',$key)->first();
            return $role ? $role->id_role : null;
        }
        else{
            return '';
        }
    }
}

// Get setting
if(!function_exists('setting')){
    function setting($key){
        $setting = Setting::where('setting_key','=',$key)->first();
        return $setting ? $setting->setting_value : '';
    }
}

// Get image
if(!function_exists('image')){
    function image($file, $category = ''){
        if(config()->has('faturcms.images.'.$category))
            return file_exists(public_path($file)) && !is_dir(public_path($file)) ? asset($file) : asset('assets/images/default/'.config('faturcms.images.'.$category));
        else
            return '';
    }
}

// Get status
if(!function_exists('status')){
    function status($status){
        if($status == 1) return 'Aktif';
        elseif($status == 0) return 'Tidak Aktif';
        else return '';
    }
}

// Get gender
if(!function_exists('gender')){
    function gender($gender){
        if($gender == 'L') return 'Laki-Laki';
        elseif($gender == 'P') return 'Perempuan';
        else return '';
    }
}

// Get kategori pelatihan
if(!function_exists('kategori_pelatihan')){
    function kategori_pelatihan($id){
        $data = KategoriPelatihan::find($id);
        return $data ? $data->kategori : '';
    }
}

// Get psikolog
if(!function_exists('psikolog')){
    function psikolog($psikolog){
        if($psikolog == 1) return 'Psikolog';
        elseif($psikolog == 2) return 'Konsultan';
        else return '';
    }
}

// Get tipe halaman
if(!function_exists('tipe_halaman')){
    function tipe_halaman($tipe){
        if($tipe == 1) return 'Auto';
        elseif($tipe == 2) return 'Manual';
        else return '';
    }
}

// Get referral
if(!function_exists('referral')){
    function referral($ref = ''){
        $user = User::where('username','=',$ref)->first();

        if(!$user){
            // Jika user tidak ditemukan
            $setting = Setting::where('setting_key','=','site.referral')->first();
            $user = User::find($setting->setting_value);
        }

        return $user->username;
    }
}

// Get message
if(!function_exists('message')){
    function message($key){
        if($key == 'unpaid') return 'Anda belum melakukan pembayaran';
        else return '';
    }
}

/**
 *
 * Arrays
 * 
 */

// Array pesan validasi form
if(!function_exists('array_validation_messages')){
    function array_validation_messages(){
        $array = [
            'alpha' => 'Hanya bisa diisi dengan huruf!',
            'alpha_dash' => 'Hanya bisa diisi dengan huruf, angka, strip dan underscore!',
            'confirmed' => 'Tidak cocok!',
            'email' => 'Format penulisan email salah!',
            'max' => 'Harus diisi maksimal :max karakter!',
            'min' => 'Harus diisi minimal :min karakter!',
            'numeric' => 'Harus diisi dengan nomor atau angka!',
            'regex' => 'Format penulisan tidak valid!',
            'required' => 'Harus diisi!',
            'same' => 'Harus sama!',
            'unique' => 'Sudah terdaftar!',
        ];
        return $array;
    }
}

// Array nama bulan dalam Bahasa Indonesia
if(!function_exists('array_indo_month')){
    function array_indo_month(){
        $array = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        return $array;
    }
}

// Array kategori materi
if(!function_exists('array_kategori_materi')){
    function array_kategori_materi(){
        $array = KategoriMateri::all();
        return $array;
    }
}

// Array penerima notifikasi
if(!function_exists('array_receivers')){
    function array_receivers(){  
        $data = Setting::where('setting_key','=','site.receivers')->first();
        $array = $data ? explode(',', $data->setting_value) : [];
        return $array; 
    }
}

// Array tag
if(!function_exists('array_tag')){
    function array_tag(){
        $tag = Tag::orderBy('tag','asc')->get()->pluck('tag');
        return $tag;
    }
}

/**
 *
 * Slugify and Generate file name
 * 
 */

// Slugify
if(!function_exists('slugify')){
    function slugify($text, $table, $field, $primaryKey, $id = null){
        $permalink = generate_permalink($text);
        $i = 1;
        while(count_existing_data($table, $field, $permalink, $primaryKey, $id) > 0){
            $permalink = rename_permalink(generate_permalink($text), $i);
            $i++;
        }
        return $permalink;
    }
}

/**
 *
 * Upload File
 * 
 */

// Mengupload file
if(!function_exists('upload_file')){
    function upload_file($code, $path){
        // Decode base 64
        list($type, $code) = explode(';', $code);
        list(, $code)      = explode(',', $code);
        $code = base64_decode($code);
        $mime = str_replace('data:', '', $type);

        // Membuat nama file
        $file_name = date('Y-m-d-H-i-s');
        $file_name = $file_name.'.'.mime_to_ext($mime)[0];
        file_put_contents($path.$file_name, $code);

        // Return
        return $file_name;
    }
}

// Mengupload gambar dari Quill Editor
if(!function_exists('upload_quill_image')){
    function upload_quill_image($html, $path){
        // Mengambil gambar dari tag "img"
        $dom = new \DOMDocument;
        @$dom->loadHTML($html);
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key=>$image){
            // Mengambil isi atribut "src"
            $code = $image->getAttribute('src');

			// Mencari gambar yang bukan URL
            if(filter_var($code, FILTER_VALIDATE_URL) == false){
                // Upload foto
                list($type, $code) = explode(';', $code);
                list(, $code)      = explode(',', $code);
                $code = base64_decode($code);
                $mime = str_replace('data:', '', $type);
                $image_name = date('Y-m-d-H-i-s').' ('.($key+1).')';
                $image_name = $image_name.'.'.mime_to_ext($mime)[0];
                file_put_contents($path.$image_name, $code);

                // Mengganti atribut "src"
                $image->setAttribute('src', URL::to('/').'/'.$path.$image_name);
            }
        }
        
        // Return
        return $dom->saveHTML();
    }
}

/**
 *
 * Other Helpers
 * 
 */

// Mengganti nama permalink jika ada yang sama
if(!function_exists('rename_permalink')){
    function rename_permalink($permalink, $count = 0){
        return $permalink."-".($count+1);
    }
}