<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\User;
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
     * Menampilkan data sertifikat peserta
     *
     * @return \Illuminate\Http\Response
     */
    public function indexParticipant()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		if(Auth::user()->is_admin == 1){
            // Data Sertifikat
            $sertifikat = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->orderBy('tanggal_pelatihan_from','desc')->get();
            
            // View
            return view('faturcms::admin.sertifikat.participant', [
                'sertifikat' => $sertifikat,
            ]);
	}
		elseif(Auth::user()->is_admin == 0){
			// Data Sertifikat
			$sertifikat = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->where('status_pelatihan','!=',0)->orderBy('tanggal_pelatihan_from','desc')->get();
			
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
		
		$qrcode = base64_encode(QrCode::format('png')->size(200)->backgroundColor(0,0,0,0)->errorCorrection('H')->generate(url()->to('/cek-sertifikat/'.$member->id_pm)));

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
     * Menampilkan ID Card Member
     *
     * @return \Illuminate\Http\Response
     */
    public function idcard()
    {
        ini_set('max_execution_time', 300);
		
		if(Auth::user()->is_admin == 0){
			// Data Member
			$member = User::join('role','users.role','=','role.id_role')->find(Auth::user()->id_user);

			// Jika tidak ada
			if(!$member){
				abort(404);
			}
		}

		// View PDF
		$pdf = PDF::loadview('id-card', [
			'member' => $member,
		]);
		//$pdf->setPaper('A4', 'landscape');
		
        return $pdf->stream("ID Card.pdf");
    }
	
    /**
     * Cek Sertifikat Peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function checkParticipant($id)
    {
		// Data Member
		$member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->where('status_pelatihan','!=',0)->find($id);
		
		// View
		return view('front/cek-sertifikat', ['member' => $member]);
    }
}