<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Menampilkan statistik member
     *
     * @return \Illuminate\Http\Response
     */
    public function member()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // View
        return view('faturcms::admin.statistik.member');
    }

    /**
     * Menampilkan statistik perangkat
     *
     * @return \Illuminate\Http\Response
     */
    public function device()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // View
        return view('faturcms::admin.statistik.device');
    }
}
