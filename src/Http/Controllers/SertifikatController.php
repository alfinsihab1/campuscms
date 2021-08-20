<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Signature;

class SertifikatController extends Controller
{
    /**
     * Menampilkan data sertifikat trainer
     *
     * @return \Illuminate\Http\Response
     */
    public function indexTrainer()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		if(Auth::user()->is_admin == 1){
            // Data Sertifikat
            $sertifikat = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->orderBy('tanggal_pelatihan_from','desc')->get();
			
            // View
            return view('faturcms::admin.sertifikat.trainer', [
                'sertifikat' => $sertifikat,
            ]);
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Sertifikat
			$sertifikat = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('users.id_user','=',Auth::user()->id_user)->orderBy('tanggal_pelatihan_from','desc')->get();
			
			// View
			return view('faturcms::member.sertifikat.trainer', [
				'sertifikat' => $sertifikat,
			]);
		}
    }

    /**
     * Menampilkan data sertifikat peserta (JSON)
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function dataParticipant(Request $request)
    {
        if($request->ajax()){
            // Data Sertifikat
            $sertifikat = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->orderBy('tanggal_pelatihan_from','desc')->get();

            foreach($sertifikat as $key=>$data){
            	// Get pelatihan
            	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($data->id_pelatihan);

            	if(!$pelatihan) $sertifikat->forget($key);
            }

            // Return
            return DataTables::of($sertifikat)
            ->addColumn('checkbox', '<input type="checkbox">')
            ->addColumn('user_identity', function($data){
                return '
                    <a href="'.route('admin.user.detail', ['id' => $data->id_user ]).'">'.$data->nama_user.'</a>
                    <br>
                    <small><i class="fa fa-envelope mr-1"></i>'.$data->email.'</small>
                    <br>
                    <small><i class="fa fa-phone mr-1"></i>'.$data->nomor_hp.'</small>
                ';
            })
            ->addColumn('pelatihan', function($data){
                return '
                    <a href="'.route('admin.pelatihan.detail', ['id' => $data->id_pelatihan]).'">'.$data->nama_pelatihan.'</a>
                    <br>
                    <small><i class="fa fa-tag mr-2"></i>'.$data->nomor_pelatihan.'</small>
                ';
            })
            ->addColumn('tanggal_pelatihan_from', function($data){
                return '
                    <span class="d-none">'.$data->tanggal_pelatihan_from.'</span>
                    '.date('d/m/Y', strtotime($data->tanggal_pelatihan_from)).'
                    <br>
                    <small><i class="fa fa-clock-o mr-1"></i>'.date('H:i', strtotime($data->tanggal_pelatihan_from)).' WIB</small>
                ';
            })
            ->addColumn('options', function($data){
                return '
                    <div class="btn-group">
                    <a href="'.route('admin.sertifikat.peserta.detail', ['id' => $data->id_pm]).'" target="_blank" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>
                    <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="'.$data->id_pm.'" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                    </div>
                ';
            })
            ->removeColumn(['password', 'tanggal_lahir', 'jenis_kelamin', 'reference', 'tempat_pelatihan', 'tanggal_pelatihan_to', 'tanggal_sertifikat_from', 'tanggal_sertifikat_to', 'fee_non_member', 'gambar_pelatihan', 'deskripsi_pelatihan', 'materi_pelatihan', 'total_jam_pelatihan'])
            ->rawColumns(['checkbox', 'user_identity', 'pelatihan', 'tanggal_pelatihan_from', 'options'])
            ->make(true);
        }
        else{
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden!'
            ]);
        }
    }
	
    /**
     * Menampilkan data sertifikat peserta
     *
     * @return \Illuminate\Http\Response
     */
    public function indexParticipant()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		if(Auth::user()->is_admin == 1){            
            // View
            return view('faturcms::admin.sertifikat.participant');
	}
		elseif(Auth::user()->is_admin == 0){
			// Data Sertifikat
			$sertifikat = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->where('status_pelatihan','!=',0)->orderBy('tanggal_pelatihan_from','desc')->get();

            foreach($sertifikat as $key=>$data){
            	// Get pelatihan
            	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->find($data->id_pelatihan);

            	if(!$pelatihan) $sertifikat->forget($key);
            }
			
			// View
			return view('faturcms::member.sertifikat.participant', [
				'sertifikat' => $sertifikat,
			]);
		}
    }
	
    /**
     * Menampilkan PDF Sertifikat Trainer
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detailTrainer(Request $request, $id)
    {
        ini_set('max_execution_time', 300);

        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // Data Member
            $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->findOrFail($id);
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Member
			$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->where('users.id_user','=',Auth::user()->id_user)->findOrFail($id);
		}
		
		// Direktur
		$direktur = User::where('role','=',role('manager'))->first();
		
		// Dosen
		$dosen = User::where('role','=',role('mentor'))->first();
		
		// Data signature direktur
		$signature_direktur = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role('manager'))->first();
		
		// Data signature dosen
		$signature_dosen = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role('mentor'))->first();
		
		// Data signature trainer
		$signature_trainer = Signature::where('id_user','=',$pelatihan->trainer)->first();

		// View PDF
		$pdf = PDF::loadview('pdf.'.setting('site.view.sertifikat_trainer'), [
			// 'member' => $member,
			'direktur' => $direktur,
			'dosen' => $dosen,
			'pelatihan' => $pelatihan,
			'signature_direktur' => $signature_direktur,
			'signature_dosen' => $signature_dosen,
			'signature_trainer' => $signature_trainer,
		]);
		$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("Sertifikat Trainer Pelatihan.pdf");
    }
	
    /**
     * Menampilkan PDF Sertifikat Peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detailParticipant(Request $request, $id)
    {
        ini_set('max_execution_time', 300);

        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // Data Member
            $member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->findOrFail($id);
		}
		elseif(Auth::user()->is_admin == 0){
			// Data Member
			$member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->where('status_pelatihan','!=',0)->findOrFail($id);
		}
		
		$qrcode = base64_encode(QrCode::format('png')->size(200)->backgroundColor(0,0,0,0)->errorCorrection('H')->generate(url()->to('/check-certificate/'.$member->id_pm)));

		// Data pelatihan
		$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->join('kategori_pelatihan','pelatihan.kategori_pelatihan','=','kategori_pelatihan.id_kp')->find($member->id_pelatihan);
		$pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
		
		// Direktur
		$direktur = User::where('role','=',role('manager'))->first();
		
		// Dosen
		$dosen = User::where('role','=',role('mentor'))->first();
		
		// Data signature direktur
		$signature_direktur = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role('manager'))->first();
		
		// Data signature dosen
		$signature_dosen = Signature::join('users','signature.id_user','=','users.id_user')->where('users.role','=',role('mentor'))->first();
		
		// Data signature trainer
		$signature_trainer = Signature::where('id_user','=',$pelatihan->trainer)->first();

		// View PDF
		$pdf = PDF::loadview('pdf.'.setting('site.view.sertifikat_peserta'), [
			'member' => $member,
			'direktur' => $direktur,
			'dosen' => $dosen,
			'pelatihan' => $pelatihan,
			'signature_direktur' => $signature_direktur,
			'signature_dosen' => $signature_dosen,
			'signature_trainer' => $signature_trainer,
			'qrcode' => $qrcode,
		]);
		$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("Sertifikat Peserta Pelatihan.pdf");
    }
    
    /**
     * Menghapus sertifikat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $pelatihan_member = PelatihanMember::find($request->id);
        $pelatihan_member->delete();

        // Redirect
        return redirect()->route('admin.sertifikat.peserta.index')->with(['message' => 'Berhasil menghapus data.']);
    }
	
    /**
     * Cek Sertifikat Peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function check($id)
    {
		// Data Member
		$member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->find($id);
		
		// View
		return view('auth.'.setting('site.view.check_certificate'), [
			'member' => $member
		]);
    }
}