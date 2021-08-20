<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    /**
     * Status member
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function memberStatus(Request $request)
    {
        if($request->ajax()){
            // Data user
            $userActive = User::where('is_admin','=',0)->where('status','=',1)->count();
            $userNonactive = User::where('is_admin','=',0)->where('status','=',0)->count();

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Aktif', 'Belum Aktif'],
                    'colors' => ['#28a745', '#dc3545'],
                    'data' => [$userActive, $userNonactive],
                    'total' => number_format($userActive + $userNonactive,0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Jenis kelamin member
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function memberGender(Request $request)
    {
        if($request->ajax()){
            // Data user
            $userMale = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','L')->count();
            $userFemale = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','P')->count();

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Laki-Laki', 'Perempuan'],
                    'colors' => ['#007bff', '#e83e8c'],
                    'data' => [$userMale, $userFemale],
                    'total' => number_format($userMale + $userFemale,0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Usia member
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function memberAge(Request $request)
    {
        if($request->ajax()){
            // Data user
            $userUnder20 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','>=',(date('Y')-20))->count();
            $userBetween21_37 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<=',(date('Y')-21))->whereYear('tanggal_lahir','>=',(date('Y')-37))->count();
            $userBetween38_50 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<=',(date('Y')-38))->whereYear('tanggal_lahir','>=',(date('Y')-50))->count();
            $userAfter50 = User::where('is_admin','=',0)->where('status','=',1)->whereYear('tanggal_lahir','<',(date('Y')-50))->count();

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['< 20 Tahun', '21 - 37 Tahun', '38 - 50 Tahun', '> 50 Tahun'],
                    'colors' => ['#20c997', '#28a745', '#ffc107', '#dc3545'],
                    'data' => [$userUnder20, $userBetween21_37, $userBetween38_50, $userAfter50],
                    'total' => number_format($userUnder20 + $userBetween21_37 + $userBetween38_50 + $userAfter50,0,'.','.')
                ]
            ]);
        }
    }
}