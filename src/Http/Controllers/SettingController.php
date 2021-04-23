<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\KategoriSetting;

class SettingController extends Controller
{
    /**
     * Menampilkan setting list
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // View
        return view('faturcms::admin.setting.index');
    }

    /**
     * Menampilkan form edit setting
     *
     * string $category
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        // Get prefix
        $kategori = KategoriSetting::where('slug','=',$category)->firstOrFail();

        // Setting
        $setting = Setting::where('setting_category','=',$kategori->id_ks)->get();

        // View
        return view('faturcms::admin.setting.edit-'.$category, [
            'kategori' => $kategori,
            'setting' => $setting,
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
            // Jika kategori icon
            if($category == 'icon'){
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
                    	$setting->setting_value = $category == 'price'? str_replace('.', '', $value) : $value;
                    	$setting->save();
                    }
                }
            }
        }

        // Redirect
        return redirect()->route('admin.setting.edit', ['category' => $category])->with(['message' => 'Berhasil mengupdate data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showIcons(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/icon')));
    }
}
