<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;
use Ajifatur\FaturCMS\Models\Visitor;

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
        $visitorChrome = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Chrome"'.'%')->count();
        $visitorFirefox = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Firefox"'.'%')->count();
        $visitorOpera = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"Opera"'.'%')->count();
        $visitorLainnya = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','=',null)->count();

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
        $visitorWindows = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Windows"'.'%')->count();
        $visitorLinux = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Linux"'.'%')->count();
        $visitorMac = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"Mac"'.'%')->count();
        $visitorLainnya = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','=',null)->count();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'Success!',
            'data' => [
                'labels' => ['Windows', 'Linux', 'Mac', 'Lainnya'],
                'data' => [$visitorWindows, $visitorLinux, $visitorMac, $visitorLainnya],
                'total' => number_format($visitorWindows + $visitorLinux + $visitorMac + $visitorLainnya,0,'.','.')
            ]
        ]);
    }
}
