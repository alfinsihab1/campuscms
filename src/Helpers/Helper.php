<?php

/**
 * Main Helpers:
 * @method has_access(string $permission, int $role, bool $isAbort = true)
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
 * @method package_version()
 * @method browser_info()
 * @method platform_info()
 * @method device_info()
 * @method location_info(string $ip)
 * @method log_activity()
 * @method log_login(object $request)
 *
 * Array Helpers:
 * @method array_kategori_artikel()
 * @method array_kategori_pelatihan()
 * @method array_receivers()
 * @method array_tag()
 *
 * Other Helpers:
 * @method package_path(string $path)
 */

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use hisorange\BrowserDetect\Parser as Browser;
use Stevebauman\Location\Facades\Location;
use App\Models\User;
use Ajifatur\FaturCMS\Models\KategoriArtikel;
use Ajifatur\FaturCMS\Models\KategoriPelatihan;
use Ajifatur\FaturCMS\Models\KategoriSetting;
use Ajifatur\FaturCMS\Models\Permission;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\RolePermission;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\Tag;
use Ajifatur\FaturCMS\Models\UserSetting;

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
            // Mengecek akses yang diizinkan untuk pengecualian
            if(in_array($permission, config('faturcms.allowed_access'))) return true;
            // Jika tidak ada dalam daftar pengecualian
            else{
                if($isAbort) abort(403);
                else return false;
            }
        }
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

// Package Version
if(!function_exists('package_version')){
    function package_version(){
        try {
            $client = new Client(['base_uri' => 'http://faturcms.faturmedia.xyz/api/']);
            $request = $client->request('GET', 'version');
        } catch (ClientException $e) {
            return null;
        }
        $response = json_decode($request->getBody(), true);
        return $response['data'];
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

// Location Info
if(!function_exists('location_info')){
    function location_info($ip){
        // Data location
        $location = Location::get($ip);

        return $location ? json_encode($location) : '';
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

// Array kategori artikel
if(!function_exists('array_kategori_artikel')){
    function array_kategori_artikel(){
        $array = KategoriArtikel::where('id_ka','>',0)->get();
        return $array;
    }
}

// Array kategori pelatihan
if(!function_exists('array_kategori_pelatihan')){
    function array_kategori_pelatihan(){
        $array = KategoriPelatihan::all();
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

// Package path
if(!function_exists('package_path')){
    function package_path($path = ''){
        if(substr($path, 0, 1) != '/') $path = '/'.$path;
        return base_path('vendor/'.config('faturcms.name').$path);
    }
}

// theme
if(!function_exists('get_theme')){
    function get_theme(){
        $theme='light';
        
            $user_setting=UserSetting::where('id_user','=',Auth::user()->id_user)->first();
            if ($user_setting) {
                $json=($user_setting->user_setting != '' || $user_setting->user_setting != null) ? json_decode($user_setting->user_setting, true) : [];
                if (array_key_exists('theme',$json)) {
                    $theme = $json['theme'];
                }
            }
        
        return $theme;
    }
}

// Check auth
if(!function_exists('check_auth')){
    function check_auth(){
        try {
            $client = new Client(['base_uri' => 'https://fpm.faturmedia.xyz/api/']);
            $faturcms_request = $client->request('PUT', 'subscriber/auth', [
                'query' => [
                    'url' => url()->to('/'),
                    'key' => env('FATURCMS_APP_KEY'),
                ]
            ]);
        } catch (ClientException $e) {
            echo Psr7\Message::toString($e->getResponse());
            return;
        }
        $response = json_decode($faturcms_request->getBody(), true);
        return $response['status'];
    }
}