<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\KategoriSetting;
use Ajifatur\FaturCMS\Models\UserSetting;

class SettingController extends Controller
{
    /**
     * Menampilkan setting list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Pengaturan
        $setting = [
            ['title' => 'Umum', 'description' => 'Pengaturan Nama Website, Email, Alamat, dll', 'url' => route('admin.setting.edit', ['category' => 'general'])],
            ['title' => 'Logo', 'description' => 'Pengaturan Logo', 'url' => route('admin.setting.edit', ['category' => 'logo'])],
            ['title' => 'Icon', 'description' => 'Pengaturan Icon', 'url' => route('admin.setting.edit', ['category' => 'icon'])],
            ['title' => 'Harga', 'description' => 'Pengaturan Komisi, Biaya Aktivasi, Withdrawal, dll', 'url' => route('admin.setting.edit', ['category' => 'price'])],
            ['title' => 'Warna', 'description' => 'Pengaturan Warna Primer, Sekunder, Tersier', 'url' => route('admin.setting.edit', ['category' => 'color'])],
            ['title' => 'Sertifikat', 'description' => 'Pengaturan Kode, Background Sertifikat', 'url' => route('admin.setting.edit', ['category' => 'certificate'])],
            ['title' => 'Halaman', 'description' => 'Pengaturan Halaman Login, Register, Sertifikat, dll', 'url' => route('admin.setting.edit', ['category' => 'view'])],
            ['title' => 'Penerima Notifikasi', 'description' => 'Pengaturan Penerima Notifikasi Email', 'url' => route('admin.setting.edit', ['category' => 'receivers'])],
            ['title' => 'Referral', 'description' => 'Pengaturan Default Referral', 'url' => route('admin.setting.edit', ['category' => 'referral'])],
            ['title' => 'Server', 'description' => 'Pengaturan PHP Binary, Composer Binary', 'url' => route('admin.setting.edit', ['category' => 'server'])],
        ];

        // View
        return view('faturcms::admin.setting.index', [
            'setting' => $setting
        ]);
    }

    /**
     * Menampilkan form edit setting
     *
     * string $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get prefix
        $kategori = KategoriSetting::where('slug','=',$category)->firstOrFail();

        // Setting
        $setting = Setting::where('setting_category','=',$kategori->id_ks)->orderBy('setting_order','asc')->get();

        // User
        $users = $category == 'referral' ? User::where('is_admin','=',0)->where('status','=',1)->where('email_verified','=',1)->orderBy('role','asc')->get() : null;

        $theme='light';
        if ($category=='color') {
            $user_setting=UserSetting::where('id_user','=',Auth::user()->id_user)->first();
            if ($user_setting) {
                $json=($user_setting->user_setting != '' || $user_setting->user_setting != null) ? json_decode($user_setting->user_setting, true) : [];
                if (array_key_exists('theme',$json)) {
                    $theme = $json['theme'];
                }
            }
        }

        // View
        return view('faturcms::admin.setting.edit-'.$category, [
            'kategori' => $kategori,
            'setting' => $setting,
            'users' => $users,
            'theme' => $theme,
        ]);
    }

    /**
     * Mengupdate setting
     *
     * string $category
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category)
    {
        // Get prefix
        $kategori = KategoriSetting::where('slug','=',$category)->firstOrFail();

        // Set rule setting
        $key_rules = array();
        $settings = $request->get('setting') != null ? $request->get('setting') : [];
        if(count($settings)>0){
            foreach($settings as $key=>$value){
                $key_rules['setting.'.$key] = setting_rules($kategori->prefix.$key);
            }
        }

        // Validasi
        $validator = Validator::make($request->all(), $key_rules, array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Jika kategori logo
            if($category == 'logo'){
                // Get data
                $setting = Setting::where('setting_key','=',$kategori->prefix.$category)->first();

                // Update logo
                $setting->setting_value = generate_image_name("assets/images/logo/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/logo/", $request->gambar, $request->gambar_url) : $setting->setting_value;
                $setting->save();
            }
            // Jika kategori icon
            elseif($category == 'icon'){
                // Get data
                $setting = Setting::where('setting_key','=',$kategori->prefix.$category)->first();

                // Update icon
                $setting->setting_value = generate_image_name("assets/images/icon/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/icon/", $request->gambar, $request->gambar_url) : $setting->setting_value;
                $setting->save();
            }
            else{
                // Mengupdate data
                if(count($settings)>0){
                    foreach($settings as $key=>$value){
                        // Get data
                        $setting = Setting::where('setting_key','=',$kategori->prefix.$key)->first();

                        // Update
                        if($key == 'google_maps' || $key == 'google_analytics') $setting->setting_value = htmlentities($value);
                    	else $setting->setting_value = $category == 'price'? str_replace('.', '', $value) : $value;
                    	$setting->save();
                    }
                }
            }
        }

        // Redirect
        return redirect()->route('admin.setting.edit', ['category' => $category])->with(['message' => 'Berhasil mengupdate data.']);
    }
      
    /**
     * Menampilkan file logo
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showLogos(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/logo')));
    }
      
    /**
     * Menampilkan file icon
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showIcons(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/icon')));
    }
}
