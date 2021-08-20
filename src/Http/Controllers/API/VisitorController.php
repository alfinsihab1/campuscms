<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Visitor;

class VisitorController extends Controller
{
    /**
     * Count visitor last week
     * 
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Request
     */
    public function visitorLastWeek(Request $request)
    {
        if($request->ajax()){
            // Array
            $labels = array();
            $visitorAll = array();
            $visitorAdmin = array();
            $visitorMember = array();

            // Get data last week
            for($i=7; $i>=0; $i--){
                // Get date
                $date = date('Y-m-d', strtotime('-'.$i.' days'));

                // Get visitor admin
                $visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

                // Get visitor member
                $visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

                // Array push
                array_push($labels, date('d/m/y', strtotime($date)));
                array_push($visitorAll, count($visitor_admin) + count($visitor_member));
                array_push($visitorAdmin, count($visitor_admin));
                array_push($visitorMember, count($visitor_member));
            }

            // Datasets
            $datasets = [
                ['label' => 'Semua', 'data' => $visitorAll, 'color' => '#28b779'],
                ['label' => 'Admin', 'data' => $visitorAdmin, 'color' => '#da542e'],
                ['label' => 'Member', 'data' => $visitorMember, 'color' => '#27a9e3'],
            ];

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => $labels,
                    'datasets' => $datasets
                ]
            ]);
        }
    }

    /**
     * Count visitor last month
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function visitorLastMonth(Request $request)
    {
        if($request->ajax()){
            // Array
            $labels = array();
            $visitorAll = array();
            $visitorAdmin = array();
            $visitorMember = array();

            // Get data last month
            for($i=30; $i>=0; $i--){
                // Get date
                $date = date('Y-m-d', strtotime('-'.$i.' days'));

                // Get visitor admin
                $visitor_admin = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',1)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

                // Get visitor member
                $visitor_member = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','=',$date)->groupBy('visitor.id_user')->get();

                // Array push
                array_push($labels, date('d/m/y', strtotime($date)));
                array_push($visitorAll, count($visitor_admin) + count($visitor_member));
                array_push($visitorAdmin, count($visitor_admin));
                array_push($visitorMember, count($visitor_member));
            }

            // Datasets
            $datasets = [
                ['label' => 'Semua', 'data' => $visitorAll, 'color' => '#28b779'],
                ['label' => 'Admin', 'data' => $visitorAdmin, 'color' => '#da542e'],
                ['label' => 'Member', 'data' => $visitorMember, 'color' => '#27a9e3'],
            ];

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => $labels,
                    'datasets' => $datasets
                ]
            ]);
        }
    }
    
    /**
     * Top visitor last week
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function topVisitorLastWeek(Request $request)
    {
        if($request->ajax()){
            // Get visitor
            $last_week = date('Y-m-d', strtotime('-7 days'));
            $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','>=',$last_week)->pluck('users.id_user')->toArray();
            $count_visitor = array_count_values($visitor);
            arsort($count_visitor); // Sort
            
            // Pick 10
            $array = [];
            if(count($count_visitor)>0){
                foreach($count_visitor as $key=>$value){
                    $user = User::select('id_user', 'nama_user')->find($key);
                    array_push($array, ['user' => $user, 'url' => route('admin.user.detail', ['id' => $key]), 'visits' => $value]);
                }
            }
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => array_slice($array,0,10)
            ]);
        }
    }
    
    /**
     * Top visitor last month
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function topVisitorLastMonth(Request $request)
    {
        if($request->ajax()){
            // Get visitor
            $last_month = date('Y-m-d', strtotime('-1 month'));
            $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('is_admin','=',0)->whereDate('visit_at','>=',$last_month)->pluck('users.id_user')->toArray();
            $count_visitor = array_count_values($visitor);
            arsort($count_visitor); // Sort
            
            // Pick 10
            $array = [];
            if(count($count_visitor)>0){
                foreach($count_visitor as $key=>$value){
                    $user = User::select('id_user', 'nama_user')->find($key);
                    array_push($array, ['user' => $user, 'url' => route('admin.user.detail', ['id' => $key]), 'visits' => $value]);
                }
            }
            
            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => array_slice($array,0,10)
            ]);
        }
    }
}