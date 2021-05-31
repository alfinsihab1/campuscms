<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\User;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Kelompok;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;
use Ajifatur\FaturCMS\Models\Withdrawal;

class APIController extends Controller
{
    /**
     * Count visitor last week
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorLastWeek()
    {
        // New Array
        $data = array();

        // Get data last week
        for($i=7; $i>=0; $i--){
            // Get date
            $date = date('Y-m-d', strtotime('-'.$i.' days'));

            // Get visitor admin
            $visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

            // Get visitor member
            $visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

            // Array Push
            array_push($data, array(
                'date' => $date,
                'dateString' => date('d/m/y', strtotime($date)),
                'visitorAll' => count($visitor_admin) + count($visitor_member),
                'visitorAdmin' => count($visitor_admin),
                'visitorMember' => count($visitor_member),
            ));
        }

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => $data
        ]);
    }

    /**
     * Count visitor last month
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorLastMonth()
    {
        // New Array
        $data = array();

        // Get data last month
        for($i=30; $i>=0; $i--){
            // Get date
            $date = date('Y-m-d', strtotime('-'.$i.' days'));

            // Get visitor admin
            $visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

            // Get visitor member
            $visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

            // Array Push
            array_push($data, array(
                'date' => $date,
                'dateString' => date('d/m/y', strtotime($date)),
                'visitorAll' => count($visitor_admin) + count($visitor_member),
                'visitorAdmin' => count($visitor_admin),
                'visitorMember' => count($visitor_member),
            ));
        }

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => $data
        ]);
    }

    /**
     * Status member
     * 
     * @return \Illuminate\Http\Response
     */
    public function memberStatus()
    {
        // Data user
        $userActive = User::where('is_admin','=',0)->where('status','=',1)->count();
        $userNonactive = User::where('is_admin','=',0)->where('status','=',0)->count();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Aktif', 'Belum Aktif'],
                'data' => [$userActive, $userNonactive],
                'total' => number_format($userActive + $userNonactive,0,'.','.')
            ]
        ]);
    }

    /**
     * Jenis Kelamin member
     * 
     * @return \Illuminate\Http\Response
     */
    public function memberGender()
    {
        // Data user
        $userMale = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','L')->count();
        $userFemale = User::where('is_admin','=',0)->where('status','=',1)->where('jenis_kelamin','=','P')->count();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Laki-Laki', 'Perempuan'],
                'data' => [$userMale, $userFemale],
                'total' => number_format($userMale + $userFemale,0,'.','.')
            ]
        ]);
    }

    /**
     * Usia member
     * 
     * @return \Illuminate\Http\Response
     */
    public function memberAge()
    {
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
                'data' => [$userUnder20, $userBetween21_37, $userBetween38_50, $userAfter50],
                'total' => number_format($userUnder20 + $userBetween21_37 + $userBetween38_50 + $userAfter50,0,'.','.')
            ]
        ]);
    }

    /**
     * Perangkat visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorDevice()
    {
        // Data visitor
        $visitorDesktop = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','like','%'.'"type":"Desktop"'.'%')->count();
        $visitorTablet = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','like','%'.'"type":"Tablet"'.'%')->count();
        $visitorMobile = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','like','%'.'"type":"Mobile"'.'%')->count();
        $visitorBot = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','like','%'.'"type":"Bot"'.'%')->count();
        $visitorLainnya = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','=',null)->count();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Desktop', 'Tablet', 'Mobile', 'Bot', 'Lainnya'],
                'data' => [$visitorDesktop, $visitorTablet, $visitorMobile, $visitorBot, $visitorLainnya],
                'total' => number_format($visitorDesktop + $visitorTablet + $visitorMobile + $visitorBot + $visitorLainnya,0,'.','.')
            ]
        ]);
    }

    /**
     * Browser visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorBrowser()
    {
        // Data visitor
        $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
        $visitorChrome = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Chrome"'.'%')->orWhere('browser','like','%'.'"family":"Chrome Mobile"'.'%')->count();
        $visitorFirefox = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Firefox"'.'%')->count();
        $visitorOpera = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Opera"'.'%')->count();
        $visitorLainnya = $visitorAll - ($visitorChrome + $visitorFirefox + $visitorOpera);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Chrome', 'Firefox', 'Opera', 'Lainnya'],
                'data' => [$visitorChrome, $visitorFirefox, $visitorOpera, $visitorLainnya],
                'total' => number_format($visitorChrome + $visitorFirefox + $visitorOpera + $visitorLainnya,0,'.','.')
            ]
        ]);
    }

    /**
     * Platform visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorPlatform()
    {
        // Data visitor
        $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
        $visitorWindows = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Windows"'.'%')->count();
        $visitorLinux = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Linux"'.'%')->count();
        $visitorMac = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Mac"'.'%')->count();
        $visitorAndroid = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Android"'.'%')->count();
        $visitorLainnya = $visitorAll - ($visitorWindows + $visitorLinux + $visitorMac + $visitorAndroid);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Windows', 'Linux', 'Mac', 'Android', 'Lainnya'],
                'data' => [$visitorWindows, $visitorLinux, $visitorMac, $visitorAndroid, $visitorLainnya],
                'total' => number_format($visitorWindows + $visitorLinux + $visitorMac + $visitorAndroid + $visitorLainnya,0,'.','.')
            ]
        ]);
    }

    /**
     * Kota visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorCity()
    {
        // Array lokasi
        $location = [];

        // Data visitor yang diketahui lokasinya
        $visitorKnown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','!=',null)->where('location','!=','')->pluck('location');

        if(count($visitorKnown)){
            foreach($visitorKnown as $data){
                $data = json_decode($data, true);
                if(array_key_exists('cityName', $data)){
                    if($data['cityName'] != null) array_push($location, $data['cityName']);
                }
            }
        }

        // Data visitor yang tidak diketahui lokasinya
        $visitorUnknown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','=',null)->orWhere('location','=','')->count();

        // Array count values
        $array = array_count_values($location);

        // Push
        $array['Tidak Diketahui'] = $visitorUnknown;

        // Sort Array
        arsort($array);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'data' => $array,
                'total' => array_sum($array)
            ]
        ]);
    }

    /**
     * Region visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorRegion()
    {
        // Array lokasi
        $location = [];

        // Data visitor yang diketahui lokasinya
        $visitorKnown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','!=',null)->where('location','!=','')->pluck('location');

        if(count($visitorKnown)){
            foreach($visitorKnown as $data){
                $data = json_decode($data, true);
                if(array_key_exists('regionName', $data)){
                    if($data['regionName'] != null) array_push($location, $data['regionName']);
                }
            }
        }

        // Data visitor yang tidak diketahui lokasinya
        $visitorUnknown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','=',null)->orWhere('location','=','')->count();

        // Array count values
        $array = array_count_values($location);

        // Push
        $array['Tidak Diketahui'] = $visitorUnknown;

        // Sort Array
        arsort($array);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'data' => $array,
                'total' => array_sum($array)
            ]
        ]);
    }

    /**
     * Negara visitor
     * 
     * @return \Illuminate\Http\Response
     */
    public function visitorCountry()
    {
        // Array lokasi
        $location = [];

        // Data visitor yang diketahui lokasinya
        $visitorKnown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','!=',null)->where('location','!=','')->pluck('location');

        if(count($visitorKnown)){
            foreach($visitorKnown as $data){
                $data = json_decode($data, true);
                if(array_key_exists('countryName', $data)){
                    if($data['countryName'] != null) array_push($location, $data['countryName']);
                }
            }
        }

        // Data visitor yang tidak diketahui lokasinya
        $visitorUnknown = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','=',null)->orWhere('location','=','')->count();

        // Array count values
        $array = array_count_values($location);

        // Push
        $array['Tidak Diketahui'] = $visitorUnknown;

        // Sort Array
        arsort($array);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'data' => $array,
                'total' => array_sum($array)
            ]
        ]);
    }

    /**
     * Income
     * 
     * @return \Illuminate\Http\Response
     */
    public function income()
    {
        // Komisi
        $komisi =  Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->sum('komisi_aktivasi');

        // Transaksi pelatihan
        $transaksi_pelatihan = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->sum('fee');

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Membership', 'Pelatihan'],
                'data' => [$komisi, $transaksi_pelatihan],
                'total' => $komisi + $transaksi_pelatihan
            ]
        ]);
    }

    /**
     * Outcome
     * 
     * @return \Illuminate\Http\Response
     */
    public function outcome()
    {
        // Withdrawal
        $withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->sum('nominal');

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Withdrawal'],
                'data' => [$withdrawal],
                'total' => $withdrawal
            ]
        ]);
    }

    /**
     * Revenue
     * 
     * @return \Illuminate\Http\Response
     */
    public function revenue($month, $year)
    {
        // Variables
        $data = array();
        $totalIncome = 0;
        $totalOutcome = 0;
        $totalSaldo = 0;

        // Jika menampilkan revenue per tahun
        if($year == 0){
            // Loop
            for($y=2020; $y<=date('Y'); $y++){
                // Get income
                $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereYear('komisi_at','=',$y)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereYear('pm_at','=',$y)->sum('fee');

                // Get outcome
                $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereYear('withdrawal_at','=',$y)->sum('nominal');

                // Get saldo
                $saldo = $income - $outcome;

                // Increment
                $totalIncome += $income;
                $totalOutcome += $outcome;
                $totalSaldo += $saldo;

                // Array Push
                array_push($data, array(
                    'label' => $y,
                    'income' => $income,
                    'outcome' => $outcome,
                    'saldo' => $saldo,
                ));
            }
        }
        // Jika menampilkan revenue per bulan
        elseif($month == 0 && $year != 0){
            // Loop
            for($m=1; $m<=12; $m++){
                // Array month
                $arrayMonth = substr(array_indo_month()[$m-1],0,3);

                // Get income
                $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereMonth('komisi_at','=',$m)->whereYear('komisi_at','=',$year)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereMonth('pm_at','=',$m)->whereYear('pm_at','=',$year)->sum('fee');

                // Get outcome
                $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereMonth('withdrawal_at','=',$m)->whereYear('withdrawal_at','=',$year)->sum('nominal');

                // Get saldo
                $saldo = $income - $outcome;

                // Increment
                $totalIncome += $income;
                $totalOutcome += $outcome;
                $totalSaldo += $saldo;

                // Array Push
                array_push($data, array(
                    'label' => $arrayMonth,
                    'income' => $income,
                    'outcome' => $outcome,
                    'saldo' => $saldo,
                ));
            }
        }
        // Jika menampilkan revenue per hari
        elseif($month != 0 && $year != 0){
            // Array tanggal
            $arrayTanggal = [31, date('Y') % 4 == 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            // Loop
            for($d=1; $d<=$arrayTanggal[$month-1]; $d++){
                // Get income
                $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereDay('komisi_at','=',$d)->whereMonth('komisi_at','=',$month)->whereYear('komisi_at','=',$year)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereDay('pm_at','=',$d)->whereMonth('pm_at','=',$month)->whereYear('pm_at','=',$year)->sum('fee');

                // Get outcome
                $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereDay('withdrawal_at','=',$d)->whereMonth('withdrawal_at','=',$month)->whereYear('withdrawal_at','=',$year)->sum('nominal');

                // Get saldo
                $saldo = $income - $outcome;

                // Increment
                $totalIncome += $income;
                $totalOutcome += $outcome;
                $totalSaldo += $saldo;

                // Array Push
                array_push($data, array(
                    'label' => $d,
                    'income' => $income,
                    'outcome' => $outcome,
                    'saldo' => $saldo,
                ));
            }
        }

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'data' => $data,
                'total' => [
                    'income' => $totalIncome,
                    'outcome' => $totalOutcome,
                    'saldo' => $totalSaldo,
                ]
            ]
        ]);
    }

    /**
     * Kunjungan berdasarkan tanggal
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byTanggalKunjungan(Request $request)
    {
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
                'data' => [$userLoginA, $userLoginB, $userLoginC, $userLoginD],
                'total' => number_format(count($userTotal),0,'.','.')
            ]
        ]);
    }

    /**
     * Ikut pelatihan berdasarkan tanggal
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byTanggalIkutPelatihan(Request $request)
    {
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
                'labels' => ['Tidak Pernah Ikut', 'Ikut 1 kali', 'Ikut 2 kali', 'Ikut 3 kali', 'Ikut 4 kali', 'Ikut > 4'],
                'data' => [$userPelatihan0, $userPelatihan1, $userPelatihan2, $userPelatihan3, $userPelatihan4, $userPelatihanMore],
                'total' => number_format(count($userTotal),0,'.','.')
            ]
        ]);
    }

    /**
     * Churn Rate
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byTanggalChurnRate(Request $request)
    {
        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Tidak Login 1 bulan terakhir', 'Tidak Login 2 bulan terakhir', 'Tidak Login 3 bulan terakhir'],
                'data' => [count_churn_rate(1), count_churn_rate(2), count_churn_rate(3)],
                'total' => number_format(count_churn_rate(1) + count_churn_rate(2) + count_churn_rate(3),0,'.','.')
            ]
        ]);
    }

    /**
     * Get user by kelompok
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getUserByKelompok(Request $request)
    {
        // Data kelompok
        $kelompok = Kelompok::findOrFail($request->query('id'));

        // Data anggota
        $ids = explode(',', $kelompok->anggota_kelompok);
        $anggota = User::where('is_admin','=',0)->where('status','=',1)->whereIn('id_user',$ids)->orderBy('nama_user','asc')->get();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => $anggota
        ]);
    }

    /**
     * Get pelatihan by user
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getPelatihanByUser(Request $request)
    {
        // Data user
        $user = User::findOrFail($request->query('id'));

        // Data pelatihan
        $pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan.trainer','=','users.id_user')->where('pelatihan_member.id_user','=',$user->id_user)->orderBy('nama_pelatihan','desc')->get();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => $pelatihan
        ]);
    }

    /**
     * Login by kelompok - user - pelatihan
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byKelompokLogin(Request $request)
    {
        ini_set('max_execution_time', '300');

        // Data member pelatihan
        $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$request->query('id'))->first();

        if($member){
            // Array data
            $tanggal = [];
            $visit = [];
            $tanggal_awal = $member->tanggal_pelatihan_from;
            $tanggal_akhir = $member->tanggal_pelatihan_to;
            while(strtotime($tanggal_awal) < strtotime($tanggal_akhir)){
                // Custom data
                $count_visit = Visitor::where('id_user','=',$member->id_user)->whereDate('visit_at','=',$tanggal_awal)->count();

                // Push first
                array_push($tanggal, date('d/m/y', strtotime($tanggal_awal)));
                array_push($visit, $count_visit);

                // Replace then
                $tanggal_awal = date("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'tanggal' => $tanggal,
                    'visit' => $visit,
                ]
            ]);
        }
        else{
            // Response
            return response()->json([
                'status' => 404,
                'message' => 'Not Found!',
                'data' => [],
            ]);
        }
    }

    /**
     * Aktivitas by kelompok - user - pelatihan
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byKelompokAktivitas(Request $request)
    {
        ini_set('max_execution_time', '300');

        // Data member pelatihan
        $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$request->query('pelatihan'))->where('pelatihan_member.id_user','=',$request->query('user'))->first();

        if($member){
            // Logs
            $logs = $this->toObject('logs/user-activities/'.$member->id_user.'.log');

            // Array data
            $tanggal = [];
            $view_ebook = [];
            $view_video = [];

            $tanggal_awal = $member->tanggal_pelatihan_from;
            $tanggal_akhir = $member->tanggal_pelatihan_to;
            while(strtotime($tanggal_awal) < strtotime($tanggal_akhir)){
                // Custom data
                $count_view_ebook = 0;
                $count_view_video = 0;

                // Aktivitas (versi Log)
                if($logs != false){
                    if(count($logs)>0){
                        // Loop logs
                        foreach($logs as $log){
                            if(is_int(strpos($log->url, '/file/detail/')) && date('d/m/y', $log->time) == date('d/m/y', strtotime($tanggal_awal))){
                                // Get last segment
                                $segments = explode('/', $log->url);
                                $id_file = end($segments);

                                // Get file
                                $file = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->find($id_file);
                                if($file){
                                    if($file->tipe_kategori == 'ebook') $count_view_ebook++;
                                    elseif($file->tipe_kategori == 'video') $count_view_video++;
                                }
                            }
                        }
                    }
                }

                // Aktivitas (versi Tabel Aktivitas)
                if(Schema::hasTable('aktivitas')){
                    // Get data aktivitas
                    $aktivitas = DB::table('aktivitas')->where('id_user','=',$member->id_user)->whereDate('aktivitas_at','=',$tanggal_awal)->get();
                    if(count($aktivitas)>0){
                        foreach($aktivitas as $data){
                            $data->aktivitas = json_decode($data->aktivitas, true);
                            foreach($data->aktivitas as $row){
                                // Path format baru
                                if(is_int(strpos($row['path'], '/member/file-manager/view/'))){
                                    $id_file = str_replace('/member/file-manager/view/', '', $row['path']);
                                    $file = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->find($id_file);
                                    if($file){
                                        if($file->tipe_kategori == 'ebook') $count_view_ebook++;
                                        elseif($file->tipe_kategori == 'video') $count_view_video++;
                                    }
                                }
                                // Path course format lama
                                elseif(is_int(strpos($row['path'], '/member/e-course/detail/'))) $count_view_video++;
                                // Path course format lama
                                elseif(is_int(strpos($row['path'], '/member/materi/e-learning/view/')) || is_int(strpos($row['path'], '/member/materi/e-library/view/')) || is_int(strpos($row['path'], '/member/materi/e-competence/view/'))) $count_view_ebook++;
                            }
                        }
                    }
                }

                // Push first
                array_push($tanggal, date('d/m/y', strtotime($tanggal_awal)));
                array_push($view_ebook, $count_view_ebook);
                array_push($view_video, $count_view_video);

                // Replace then
                $tanggal_awal = date("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
            }

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'tanggal' => $tanggal,
                    'view_ebook' => $view_ebook,
                    'view_video' => $view_video,
                ]
            ]);
        }
        else{
            // Response
            return response()->json([
                'status' => 404,
                'message' => 'Not Found!',
                'data' => [],
            ]);
        }
    }

    /**
     * Mengkonversi konten file log ke object
     *
     * string $path
     * @return \Illuminate\Http\Response
     */
    public function toObject($path)
    {
        if(File::exists(storage_path($path))){
            $logs = File::get(storage_path($path));
            $logs = substr($logs, 0, -1);
            $logs = "[".$logs."]";
            $logs = json_decode($logs);
            return $logs;
        }
        else return false;   
    }


    public function getCoordinate(){
        $visitor = Visitor::where('visit_at', '=', Auth::user()->last_visit)->first();
        if ($visitor) {
            echo $visitor->location;
        }
    }
}


