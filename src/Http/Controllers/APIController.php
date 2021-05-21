<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
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
        // Data visitor
        $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
        $visitorJakarta = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"cityName":"Jakarta"'.'%')->count();
        $visitorSemarang = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"cityName":"Semarang"'.'%')->count();
        $visitorYogyakarta = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"cityName":"Yogyakarta"'.'%')->count();
        $visitorLainnya = $visitorAll - ($visitorJakarta + $visitorSemarang + $visitorYogyakarta);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Jakarta', 'Semarang', 'Yogyakarta', 'Lainnya'],
                'data' => [$visitorJakarta, $visitorSemarang, $visitorYogyakarta, $visitorLainnya],
                'total' => number_format($visitorJakarta + $visitorSemarang + $visitorYogyakarta + $visitorLainnya,0,'.','.')
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
        // Data visitor
        $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
        $visitorJakarta = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"regionName":"Jakarta"'.'%')->count();
        $visitorWestJava = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"regionName":"West Java"'.'%')->count();
        $visitorCentralJava = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"regionName":"Central Java"'.'%')->count();
        $visitorEastJava = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"regionName":"East Java"'.'%')->count();
        $visitorLainnya = $visitorAll - ($visitorJakarta + $visitorWestJava + $visitorCentralJava + $visitorEastJava);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Jakarta', 'Jabar', 'Jateng', 'Jatim', 'Lainnya'],
                'data' => [$visitorJakarta, $visitorWestJava, $visitorCentralJava, $visitorEastJava, $visitorLainnya],
                'total' => number_format($visitorJakarta + $visitorWestJava + $visitorCentralJava + $visitorEastJava + $visitorLainnya,0,'.','.')
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
        // Data visitor
        $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
        $visitorIndonesia = Visitor::join('users','visitor.id_user','=','users.id_user')->where('location','like','%'.'"countryName":"Indonesia"'.'%')->count();
        $visitorLainnya = $visitorAll - ($visitorIndonesia);

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Indonesia', 'Lainnya'],
                'data' => [$visitorIndonesia, $visitorLainnya],
                'total' => number_format($visitorIndonesia + $visitorLainnya,0,'.','.')
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
}
