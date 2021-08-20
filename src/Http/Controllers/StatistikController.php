<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Kelompok;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;

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

    /**
     * Menampilkan statistik lokasi
     *
     * @return \Illuminate\Http\Response
     */
    public function location()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // View
        return view('faturcms::admin.statistik.location');
    }

    /**
     * Menampilkan statistik keuangan
     *
     * @return \Illuminate\Http\Response
     */
    public function finance()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        // View
        return view('faturcms::admin.statistik.finance');
    }

    /**
     * Menampilkan statistik berdasarkan tanggal
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byTanggal(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        $tanggal1 = $request->query('tanggal1') ?: date('d/m/Y', strtotime('-1 month'));
        $tanggal2 = $request->query('tanggal2') ?: date('d/m/Y');
        
        // View
        return view('faturcms::admin.statistik.by-tanggal', [
            'tanggal1' => $tanggal1,
            'tanggal2' => $tanggal2,
        ]);
    }

    /**
     * Menampilkan statistik berdasarkan kelompok
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byKelompok(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kelompok
        $kelompok = Kelompok::orderBy('nama_kelompok','asc')->get();

        // Data hasil filter
        $data_kelompok = Kelompok::find($request->query('kelompok'));
        $data_user = User::find($request->query('user'));
        $data_pelatihan = Pelatihan::find($request->query('pelatihan'));

        // Check apakah anggota atau tidak
        $check = false;
        if($data_kelompok && $data_user && $data_pelatihan){
            // Check user dalam kelompok
            $ids = explode(',', $data_kelompok->anggota_kelompok);
            if(in_array($data_user->id_user, $ids)){
                // Check pelatihan dalam user
                $pelatihan_member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('pelatihan_member.id_user','=',$data_user->id_user)->where('pelatihan_member.id_pelatihan','=',$data_pelatihan->id_pelatihan)->first();
                if($pelatihan_member) $check = true;
            }
        }
        
        // View
        return view('faturcms::admin.statistik.by-kelompok', [
            'kelompok' => $kelompok,
            'check' => $check,
        ]);
    }
}
