<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ajifatur\FaturCMS\Models\Visitor;

class VisitorDeviceController extends Controller
{
    /**
     * Perangkat visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorDevice(Request $request)
    {
        if($request->ajax()){
            // Array
            $arrayLabel = ['Desktop', 'Tablet', 'Mobile', 'Bot'];
            $arrayColor = ['#007bff', '#e83e8c', '#28a745', '#dc3545', '#a3acb3'];
            $arrayData = [];

            // Data visitor
            foreach($arrayLabel as $data){
                $count = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','like','%'.'"type":"'.$data.'"'.'%')->count();
                array_push($arrayData, $count);
            }

            // Push data other visitor
            $otherVisitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('device','=',null)->count();
            array_push($arrayLabel, 'Lainnya');
            array_push($arrayData, $otherVisitor);

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => $arrayLabel,
                    'colors' => $arrayColor,
                    'data' => $arrayData,
                    'total' => number_format(array_sum($arrayData),0,'.','.'),
                ]
            ]);
        }
    }

    /**
     * Browser visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorBrowser(Request $request)
    {
        if($request->ajax()){
            // Array
            $arrayLabel = ['Chrome', 'Chrome Mobile', 'Firefox', 'Opera', 'Microsoft Edge', 'Safari', 'Mobile Safari', 'MIUI Browser', 'Samsung Browser', 'Oppo Browser', 'Vivo Browser', 'HeyTapBrowser'];
            $arrayColor = ['#4a8af5', '#189f5d', '#fb9d35', '#f7192d', '#0680d7', '#02e6f6', '#1995ee', '#f76400', '#13279b', '#006831', '#3f5cf7', '#56d085', '#a3acb3'];
            $arrayData = [];

            // Data visitor
            foreach($arrayLabel as $data){
                $count = Visitor::join('users','visitor.id_user','=','users.id_user')->where('browser','like','%'.'"family":"'.$data.'"'.'%')->count();
                array_push($arrayData, $count);
            }

            // Push data other visitor
            $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
            $otherVisitor = $visitorAll - array_sum($arrayData);
            array_push($arrayLabel, 'Lainnya');
            array_push($arrayData, $otherVisitor);

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => $arrayLabel,
                    'colors' => $arrayColor,
                    'data' => $arrayData,
                    'total' => number_format(array_sum($arrayData),0,'.','.'),
                ]
            ]);
        }
    }

    /**
     * Platform visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorPlatform(Request $request)
    {
        if($request->ajax()){
            // Array
            $arrayLabel = ['Windows', 'Linux', 'Mac', 'Android'];
            $arrayColor = ['#00a8e8', '#f7c700', '#444', '#a4c639', '#a3acb3'];
            $arrayData = [];

            // Data visitor
            foreach($arrayLabel as $data){
                if($data == 'Linux') $data = "GNU\\\\/Linux"; // Exception
                $count = Visitor::join('users','visitor.id_user','=','users.id_user')->where('platform','like','%'.'"family":"'.$data.'"'.'%')->count();
                array_push($arrayData, $count);
            }

            // Push data other visitor
            $visitorAll = Visitor::join('users','visitor.id_user','=','users.id_user')->count();
            $otherVisitor = $visitorAll - array_sum($arrayData);
            array_push($arrayLabel, 'Lainnya');
            array_push($arrayData, $otherVisitor);

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => $arrayLabel,
                    'colors' => $arrayColor,
                    'data' => $arrayData,
                    'total' => number_format(array_sum($arrayData),0,'.','.'),
                ]
            ]);
        }
    }
}