<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
}
