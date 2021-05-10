<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
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

        // Get data last week
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
}
