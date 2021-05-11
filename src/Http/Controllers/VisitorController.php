<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stevebauman\Location\Facades\Location;
use App\User;
use Ajifatur\FaturCMS\Models\Visitor;

class VisitorController extends Controller
{
    /**
     * Menampilkan data visitor
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Get tanggal
		$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
		
        // Get data visitor
        $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->whereDate('visit_at','=',generate_date_format($tanggal,'y-m-d'))->groupBy('visitor.id_user')->orderBy('visit_at','desc')->get();
        
        // View
        return view('faturcms::admin.visitor.index', [
            'visitor' => $visitor,
            'tanggal' => $tanggal,
        ]);
    }

    /**
     * Menampilkan data top visitor
     *
     * @return \Illuminate\Http\Response
     */
    public function topVisitor()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->where('status','=',1)->get();
        
        // View
        return view('faturcms::admin.visitor.top-visitor', [
            'user' => $user,
        ]);
    }

    /**
     * Menampilkan info visitor
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function info(Request $request)
    {
        // Get data visitor
        $visitor = Visitor::join('users','visitor.id_user','=','users.id_user')->where('visitor.id_user','=',$request->user)->whereDate('visit_at','=',generate_date_format($request->date,'y-m-d'))->get();

        $array = [];
        if(count($visitor)>0){
            foreach($visitor as $data){
                array_push($array, [
                    'time' => generate_date_time($data->visit_at),
                    'device' => json_decode($data->device, true),
                    'browser' => json_decode($data->browser, true),
                    'platform' => json_decode($data->platform, true),
                    'location' => json_decode($data->location, true),
                ]);
            }
        }
        echo json_encode($array);
    }

    /**
     * Mengupdate lokasi berdasarkan IP Address
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocation()
    {
        ini_set('max_execution_time', -1);

        // Get data visitor
        $visitor = Visitor::whereNotIn('ip_address',['','127.0.0.1'])->get();

        // Update lokasi
        if(count($visitor)>0){
            foreach($visitor as $row){
                $data = Visitor::find($row->id_visitor);
                if($data){
                    $data->location = location_info($data->ip_address);
                    $data->save();
                }
            }
        }

        // Redirect
        return redirect()->route('admin.visitor.index')->with(['message' => 'Berhasil mengupdate data.']);
    }
}
