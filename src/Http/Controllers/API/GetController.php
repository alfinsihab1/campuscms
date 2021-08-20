<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Kelompok;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;

class GetController extends Controller
{
    /**
     * Get user by kelompok
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getUserByKelompok(Request $request)
    {
        if($request->ajax()){
            // Data kelompok
            $kelompok = Kelompok::findOrFail($request->query('id'));

            // Data anggota
            $ids = explode(',', $kelompok->anggota_kelompok);
            $anggota = User::where('is_admin','=',0)->where('status','=',1)->whereIn('id_user',$ids)->orderBy('nama_user','asc')->get();

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => $anggota
            ]);
        }
    }

    /**
     * Get pelatihan by user
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getPelatihanByUser(Request $request)
    {
        if($request->ajax()){
            // Data user
            $user = User::findOrFail($request->query('id'));

            // Data pelatihan
            $pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan.trainer','=','users.id_user')->where('pelatihan_member.id_user','=',$user->id_user)->orderBy('nama_pelatihan','desc')->get();

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => $pelatihan
            ]);
        }
    }

    /**
     * Mengambil koordinat
     *
     * @return \Illuminate\Http\Response
     */
    public function getCoordinate(){
        $visitor = Visitor::where('visit_at', '=', Auth::user()->last_visit)->first();
        if ($visitor) {
            echo $visitor->location;
        }
    }
}