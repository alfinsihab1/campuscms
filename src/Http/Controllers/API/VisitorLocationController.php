<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ajifatur\FaturCMS\Models\Visitor;

class VisitorLocationController extends Controller
{
    /**
     * Kota visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorCity(Request $request)
    {
        if($request->ajax()){
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
    }

    /**
     * Region visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorRegion(Request $request)
    {
        if($request->ajax()){
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
    }

    /**
     * Negara visitor
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorCountry(Request $request)
    {
        if($request->ajax()){
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
    }
}