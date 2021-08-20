<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Ajifatur\FaturCMS\Models\Setting;
use Ajifatur\FaturCMS\Models\UserSetting;

class UserSettingController extends Controller
{
    /**
     * Set theme
     * 
     * @return \Illuminate\Http\Response
     */
    public function setTheme(Request $request)
    {
        // Get theme
        $theme = $request->query('theme');

        // Get user setting
        $user_setting = UserSetting::where('id_user','=',Auth::user()->id_user)->first();

        if(!$user_setting){
            $setting['theme'] = $theme;

            $user_setting = new UserSetting;
            $user_setting->id_user = Auth::user()->id_user;
            $user_setting->user_setting = json_encode($setting);
            $user_setting->save();
        }
        else{
            $setting = ($user_setting->user_setting != '' || $user_setting->user_setting != null) ? json_decode($user_setting->user_setting, true) : [];
            $setting['theme'] = $theme;

            $user_setting->user_setting = json_encode($setting);
            $user_setting->save();
        }

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            // 'data' => $data
        ]);
    }
}