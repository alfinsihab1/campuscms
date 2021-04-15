<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Ajifatur\FaturCMS\Exports\AbsensiExport;
use Ajifatur\FaturCMS\Models\Absensi;

class AbsensiController extends Controller
{
    /**
     * Menampilkan data absensi
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
		
        // Get data absensi
        $absensi = Absensi::join('users','absensi.id_user','=','users.id_user')->whereDate('absensi_at','=',generate_date_format($tanggal,'y-m-d'))->groupBy('absensi.id_user')->orderBy('absensi_at','desc')->get();
        
        // View
        return view('faturcms::admin.absensi.index', [
            'absensi' => $absensi,
            'tanggal' => $tanggal,
        ]);
    }
    
    /**
     * Menghapus absensi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus absensi
        $absensi = Absensi::find($request->id);
        $absensi->delete();

        // Redirect
        return redirect()->route('admin.absensi.index')->with(['message' => 'Berhasil menghapus data.']);
    }
    
    /**
     * Export ke Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
		// Get tanggal
		$tanggal = $request->query('tanggal') != null ? $request->query('tanggal') : date('d/m/Y');
		
        // Get data absensi
        $absensi = Absensi::join('users','absensi.id_user','=','users.id_user')->whereDate('absensi_at','=',generate_date_format($tanggal,'y-m-d'))->groupBy('absensi.id_user')->orderBy('absensi_at','asc')->get();
        
 		return Excel::download(new AbsensiExport($absensi), 'Rekap Absensi '.generate_date_format($tanggal,'y-m-d').'.xlsx');
    }
}
