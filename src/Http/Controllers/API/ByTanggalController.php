<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;

class ByTanggalController extends Controller
{
    /**
     * Kunjungan berdasarkan tanggal
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function kunjungan(Request $request)
    {
        if($request->ajax()){
            // User total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->get();

            $userLoginA = $userLoginB = $userLoginC = $userLoginD = 0;
            if(count($userTotal)>0){
                foreach($userTotal as $user){
                    if(count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 0) $userLoginA++;
                    elseif(count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) >= 1 && count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) <= 5) $userLoginB++;
                    elseif(count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) >= 6 && count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) <= 10) $userLoginC++;
                    elseif(count_kunjungan($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) > 10) $userLoginD++;
                }
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Tidak Login', 'Login 1-5 kali', 'Login 6-10 kali', 'Login >10 kali'],
                    'colors' => ['#dc3545', '#fd7e14', '#ffc107', '#28a745'],
                    'data' => [$userLoginA, $userLoginB, $userLoginC, $userLoginD],
                    'total' => number_format(count($userTotal),0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Ikut pelatihan berdasarkan tanggal
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function ikutPelatihan(Request $request)
    {
        if($request->ajax()){
            // Data total
            $userTotal = User::where('is_admin','=',0)->where('status','=',1)->get();

            $userPelatihan0 = $userPelatihan1 = $userPelatihan2 = $userPelatihan3 = $userPelatihan4 = $userPelatihanMore = 0;
            if(count($userTotal)>0){
                foreach($userTotal as $user){
                    if(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 0) $userPelatihan0++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 1) $userPelatihan1++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 2) $userPelatihan2++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 3) $userPelatihan3++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) == 4) $userPelatihan4++;
                    elseif(count_pelatihan_member($user->id_user, [generate_date_format($request->query('tanggal1'), 'y-m-d'), generate_date_format($request->query('tanggal2'), 'y-m-d')]) > 4) $userPelatihanMore++;
                }
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Tidak Pernah Ikut', 'Ikut 1 kali', 'Ikut 2 kali', 'Ikut 3 kali', 'Ikut 4 kali', 'Ikut > 4 kali'],
                    'colors' => ['#ff6384', '#63ff84', '#84ff63', '#8463ff', '#fdd100', '#f8b312'],
                    'data' => [$userPelatihan0, $userPelatihan1, $userPelatihan2, $userPelatihan3, $userPelatihan4, $userPelatihanMore],
                    'total' => number_format(count($userTotal),0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Churn Rate
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function churnRate(Request $request)
    {
        if($request->ajax()){
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Tidak Login 1 bulan terakhir', 'Tidak Login 2 bulan terakhir', 'Tidak Login 3 bulan terakhir'],
                    'colors' => ['#007bff', '#28a745', '#ffc107'],
                    'data' => [count_churn_rate(1), count_churn_rate(2), count_churn_rate(3)],
                    'total' => number_format(count_churn_rate(1) + count_churn_rate(2) + count_churn_rate(3),0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Kunjungan berdasarkan hari
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function kunjunganHari(Request $request)
    {
        if($request->ajax()){
            // Visitor
            $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','>=',generate_date_format($request->query('tanggal1'), 'y-m-d'))->whereDate('visit_at','<=',generate_date_format($request->query('tanggal2'), 'y-m-d'))->get();

            // Get by day
            $visitorDay = [];
            if(count($visitor)>0){
                foreach($visitor as $data){
                    array_push($visitorDay, date('w', strtotime($data->visit_at)));
                }
            }
            $array = array_count_values($visitorDay);

            // Fill array if index is empty
            for($i=0; $i<7; $i++){
                $array[$i] = array_key_exists($i, $array) ? $array[$i] : 0;
            }
            ksort($array); // Sort by key asc

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum`at', 'Sabtu'],
                    'colors' => ['#ff6384', '#63ff84', '#84ff63', '#8463ff', '#fdd100', '#f8b312', '#d4d4d4'],
                    'data' => $array,
                    'total' => number_format(array_sum($array),0,'.','.')
                ]
            ]);
        }
    }

    /**
     * Kunjungan berdasarkan jam
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function kunjunganJam(Request $request)
    {
        if($request->ajax()){
            // Visitor
            $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','>=',generate_date_format($request->query('tanggal1'), 'y-m-d'))->whereDate('visit_at','<=',generate_date_format($request->query('tanggal2'), 'y-m-d'))->get();

            // Get by day
            $visitorHour1 = $visitorHour2 = $visitorHour3 = $visitorHour4 = 0;
            if(count($visitor)>0){
                foreach($visitor as $data){
                    $hour = date('G', strtotime($data->visit_at));
                    if($hour >= 0 && $hour < 6) $visitorHour1++; // 00:00 - 05:59
                    elseif($hour >= 6 && $hour < 12) $visitorHour2++; // 06:00 - 11:59
                    elseif($hour >= 12 && $hour < 18) $visitorHour3++; // 12:00 - 17:59
                    elseif($hour >= 18 && $hour <= 23) $visitorHour4++; // 18:00 - 23:59
                }
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['00:00 - 05:59', '06:00 - 11:59', '12:00 - 17:59', '18:00 - 23:59'],
                    'colors' => ['#ff6384', '#63ff84', '#f8b312', '#d4d4d4'],
                    'data' => [$visitorHour1, $visitorHour2, $visitorHour3, $visitorHour4],
                    'total' => number_format(count($visitor),0,'.','.')
                ]
            ]);
        }
    }
}