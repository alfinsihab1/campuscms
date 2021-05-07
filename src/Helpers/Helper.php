<?php

/**
 * Main Helpers:
 * @method has_access(string $permission, int $role, bool $isAbort = true)
 * @method role(int|string $key)
 * @method setting(string $key)
 * @method image(string $file, string $category = '')
 * @method status(int $status)
 * @method gender(string $gender)
 * @method kategori_pelatihan(int $id)
 * @method kategori_setting(string $slug)
 * @method psikolog(int $id)
 * @method tipe_halaman(int $id)
 * @method referral(string $ref, string $route, array $routeParams = [])
 * @method sponsor(string $username)
 * @method message(string $key)
 * @method setting_rules(string $key)
 * @method package(string $package)
 * @method browser_info()
 * @method platform_info()
 * @method device_info()
 * @method log_activity()
 * @method log_login(object $request)
 *
 * Array Helpers:
 * @method array_validation_messages()
 * @method array_indo_month()
 * @method array_kategori_artikel()
 * @method array_kategori_materi()
 * @method array_receivers()
 * @method array_tag()
 *
 * Other Helpers:
 * @method slugify(string $text, string $table, string $field, string $primaryKey, int $id = null)
 * @method rename_permalink(string $permalink, int $count = 0)
 * @method upload_file(string $code, string $path)
 * @method upload_quill_image(string $code, string $path)
 * @method package_path(string $path)
 * @method file_replace_contents(string $source_file, string $destination_file, string $contents1 = '', string $contents2 = '', bool $replace = false)
 * @method composer_lock()
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use hisorange\BrowserDetect\Parser as Browser;
use App\User;
use Ajifatur\FaturCMS\Models\KategoriArtikel;
use Ajifatur\FaturCMS\Models\KategoriMateri;
use Ajifatur\FaturCMS\Models\KategoriPelatihan;
use Ajifatur\FaturCMS\Models\KategoriSetting;
use Ajifatur\FaturCMS\Models\Permission;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\RolePermission;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\Tag;

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

        // Jika ada akses
        if($role_permission){
            // Jika mempunyai hak akses
            if($role_permission->access == 1){
                // Jika status user aktif
                if(Auth::user()->status == 1) return true;
                // Jika status user belum aktif, tapi akses diizinkan
                elseif(Auth::user()->status == 0 && in_array($permission, config('faturcms.allowed_access'))) return true;
                // Jika status user belum aktif
                else{
                    if($isAbort) abort(403);
                    else return false;
                }
            }
            // Jika tidak mempunyai hak akses
            else{
                if($isAbort) abort(403);
                else return false;
            }
        }
        // Jika tidak ada akses
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

// Get kategori setting
if(!function_exists('kategori_setting')){
    function kategori_setting($slug){
        $data = KategoriSetting::where('slug','=',$slug)->first();
        return $data ? $data->id_ks : null;
    }
}

// Get psikolog
if(!function_exists('psikolog')){
    function psikolog($id){
        if($id == 1) return 'Psikolog';
        elseif($id == 2) return 'Konsultan';
        else return '';
    }
}

// Get tipe halaman
if(!function_exists('tipe_halaman')){
    function tipe_halaman($id){
        if($id == 1) return 'Auto';
        elseif($id == 2) return 'Manual';
        else return '';
    }
}

// Get referral
if(!function_exists('referral')){
    function referral($ref, $route, $routeParams = []){
        // Data user
        $user = User::where('status','=',1)->where('username','=',$ref)->first();

        if(!$user){
            // Jika user tidak ditemukan
            $setting = Setting::where('setting_key','=','site.referral')->first();
            $user = User::where('status','=',1)->find($setting->setting_value);

            // Push to route params
            $routeParams['ref'] = $user->username;

            // Return
            return redirect()->route($route, $routeParams)->send();
        }
    }
}

// Get sponsor
if(!function_exists('sponsor')){
    function sponsor($username){
        $user = User::where('username','=',$username)->first();
        return $user ? $user->nama_user : '';
    }
}

// Get message
if(!function_exists('message')){
    function message($key){
        if($key == 'unpaid') return 'Anda belum melakukan pembayaran';
        else return '';
    }
}

// Get setting rules
if(!function_exists('setting_rules')){
    function setting_rules($key){
        $data = DB::table('settings')->where('setting_key',$key)->first();
        return $data ? $data->setting_rules : '';  
    }
}

// Package
if(!function_exists('package')){
    function package($package){
        $array = composer_lock()['packages'];
        $index = '';
        if(count($array)>0){
            foreach($array as $key=>$data){
                if($data['name'] == $package) $index = $key;
            }
        }
        return array_key_exists($index, $array) ? $array[$index] : null;
    }
}

// Browser Info
if(!function_exists('browser_info')){
    function browser_info(){
        $browser = [
            'name' => Browser::browserName(),
            'family' => Browser::browserFamily(),
            'version' => Browser::browserVersion(),
            'engine' => Browser::browserEngine(),
        ];

        return json_encode($browser);
    }
}

// Platform Info
if(!function_exists('platform_info')){
    function platform_info(){
        $platform = [
            'name' => Browser::platformName(),
            'family' => Browser::platformFamily(),
            'version' => Browser::platformVersion(),
        ];

        return json_encode($platform);
    }
}

// Device Info
if(!function_exists('device_info')){
    function device_info(){
        // Device type
        $device_type = '';
        if(Browser::isMobile()) $device_type = 'Mobile';
        if(Browser::isTablet()) $device_type = 'Tablet';
        if(Browser::isDesktop()) $device_type = 'Desktop';
        if(Browser::isBot()) $device_type = 'Bot';

        $device = [
            'type' => $device_type,
            'family' => Browser::deviceFamily(),
            'model' => Browser::deviceModel(),
            'grade' => Browser::mobileGrade(),
        ];

        return json_encode($device);
    }
}

// Log Activity
if(!function_exists('log_activity')){
    function log_activity(){
        // Add directory if not exist
        if(!File::exists(storage_path('logs/user-activities'))) File::makeDirectory(storage_path('logs/user-activities'));

        // Put log
        if(Auth::check()){
            $activity['user'] = Auth::user()->id_user;
            $activity['url'] = str_replace(url()->to('/'), "", url()->full());
            $activity['time'] = time();
            $activity_json = json_encode($activity);
            File::append(storage_path('logs/user-activities/'.Auth::user()->id_user.'.log'), $activity_json.",");
        }
    }
}

// Log Login
if(!function_exists('log_login')){
    function log_login(Request $request){
        // Add directory if not exist
        if(!File::exists(storage_path('logs/login'))) File::makeDirectory(storage_path('logs/login'));

        // Put log
        $data['username'] = $request->username;
        $data['ip'] = $request->ip();
        $data['time'] = time();
        $data_json = json_encode($data);
        File::append(storage_path('logs/login/login.log'), $data_json.",");
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

// Array kategori artikel
if(!function_exists('array_kategori_artikel')){
    function array_kategori_artikel(){
        $array = KategoriArtikel::where('id_ka','>',0)->get();
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
 * Others
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

// Mengganti nama permalink jika ada yang sama
if(!function_exists('rename_permalink')){
    function rename_permalink($permalink, $count = 0){
        return $permalink."-".($count+1);
    }
}

// Package path
if(!function_exists('package_path')){
    function package_path($path = ''){
        if(substr($path, 0, 1) != '/') $path = '/'.$path;
        return base_path('vendor/'.config('faturcms.name').$path);
    }
}

// Mengganti konten file
if(!function_exists('file_replace_contents')){
    function file_replace_contents($source_file, $destination_file, $contents1 = '', $contents2 = '', $replace = false){
        // Jika konten kosong, berarti mengganti "semua" isi file
        if($contents1 == ''){
            if(File::exists($source_file) && File::exists($destination_file)){
                File::put($destination_file, File::get($source_file));
            }
        }
        // Jika konten tidak kosong, berarti mengganti isi file berdasarkan konten yang dicari
        else{
            // Jika belum pernah diupdate
            if(strpos(File::get($destination_file), $contents1) === false){
                // Jika false, tidak mereplace
                if($replace === false)
                    File::append($destination_file, $contents2);
                // Jika true, berarti mereplace
                else{
                    $get_contents = File::get($destination_file);
                    File::put($destination_file, str_replace($contents2, $contents1, $get_contents));
                }
            }
        }
    }
}

// Composer lock
if(!function_exists('composer_lock')){
    function composer_lock(){
        $content = File::get(base_path('composer.lock'));
        return json_decode($content, true);
    }
}
