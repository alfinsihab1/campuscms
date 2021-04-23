<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\Setting;

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
     * Menampilkan setting umum
     *
     * @return \Illuminate\Http\Response
     */
    public function general()
    {
        // Setting
        $setting = Setting::where('setting_category','=',1)->get();

        // View
        return view('faturcms::admin.setting.general', [
            'setting' => $setting
        ]);
    }
    
    /**
     * Menampilkan setting logo
     *
     * @return \Illuminate\Http\Response
     */
    public function logo()
    {
        // View
        return view('faturcms::admin.setting.index');
    }
    
    /**
     * Menampilkan setting icon
     *
     * @return \Illuminate\Http\Response
     */
    public function icon()
    {
        // View
        return view('faturcms::admin.setting.index');
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
        // Set rule setting
        $key_rules = array();
        $settings = $request->get('setting');
        foreach($settings as $key=>$value){
            $key_rules['setting.'.$key] = setting_rules('site.'.$key);
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
            // Mengupdate data
            foreach($settings as $key=>$value){
                // Get data
                $setting = Setting::where('setting_key','=','site.'.$key)->first();

                // Update
            	$setting->setting_value = $value;
            	$setting->save();
            }
        }

        // Redirect
        return redirect()->route('admin.setting.'.$category)->with(['message' => 'Berhasil mengupdate data.']);

        /*
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mentor' => 'required',
            'profesi_mentor' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_mentor',
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Mentor::latest('order_mentor')->first();

            // Menambah data
            $mentor = new Mentor;
            $mentor->nama_mentor = $request->nama_mentor;
            $mentor->profesi_mentor = $request->profesi_mentor;
            $mentor->foto_mentor = generate_image_name("assets/images/mentor/", $request->gambar, $request->gambar_url);
            $mentor->order_mentor = $latest ? $latest->order_mentor + 1 : 1;
            $mentor->save();
        }

        // Redirect
        return redirect()->route('admin.mentor.index')->with(['message' => 'Berhasil menambah data.']);
        */
    }
}
