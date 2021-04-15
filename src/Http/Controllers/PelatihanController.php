<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
// use App\Mail\TrainingPaymentMail;
use App\User;
use Ajifatur\FaturCMS\Models\DefaultRekening;
use Ajifatur\FaturCMS\Models\KategoriPelatihan;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\PelatihanMember;

class PelatihanController extends Controller
{
    /**
     * Menampilkan data pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // Data pelatihan
            $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->orderBy('tanggal_pelatihan_from','desc')->get();
            
            // View
            return view('faturcms::admin.pelatihan.index', [
                'pelatihan' => $pelatihan,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
			if(Auth::user()->role == role('trainer')){				
				// Data pelatihan (kecuali yang dia traineri)
				$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','!=',Auth::user()->id_user)->whereDate('tanggal_pelatihan_to','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
			}
			elseif(Auth::user()->role == role('student')){
				// Data pelatihan
				$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->whereDate('tanggal_pelatihan_to','>=',date('Y-m-d'))->orderBy('tanggal_pelatihan_from','desc')->get();
			}
			
            // View
            return view('faturcms::member.pelatihan.index', [
                'pelatihan' => $pelatihan,
            ]);
        }
    }

    /**
     * Menampilkan form tambah pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = KategoriPelatihan::all();

        // Mentor
        $trainer = User::where('role','=',role('trainer'))->orderBy('nama_user','asc')->get();

        // View
        return view('faturcms::admin.pelatihan.create', [
            'kategori' => $kategori,
            'trainer' => $trainer,
        ]);
    }

    /**
     * Menambah pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|max:255',
            'kategori' => 'required',
            'trainer' => 'required',
            'tanggal_pelatihan' => 'required',
            'tanggal_sertifikat' => 'required',
            'fee' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_pelatihan',
                'kategori',
                'trainer',
                'tempat_pelatihan',
                'tanggal_pelatihan',
                'tanggal_sertifikat',
                'fee',
            ]));
        }
        // Jika tidak ada error
        else{			
            // Menambah data
            $pelatihan = new Pelatihan;
            $pelatihan->nama_pelatihan = $request->nama_pelatihan;
            $pelatihan->kategori_pelatihan = $request->kategori;
            $pelatihan->tempat_pelatihan = $request->tempat_pelatihan != '' ? $request->tempat_pelatihan : '';
            $pelatihan->tanggal_pelatihan_from = generate_date_range('explode', $request->tanggal_pelatihan)['from'];
            $pelatihan->tanggal_pelatihan_to = generate_date_range('explode', $request->tanggal_pelatihan)['to'];
            $pelatihan->tanggal_sertifikat_from = generate_date_range('explode', $request->tanggal_sertifikat)['from'];
            $pelatihan->tanggal_sertifikat_to = generate_date_range('explode', $request->tanggal_sertifikat)['to'];
            $pelatihan->gambar_pelatihan = generate_image_name("assets/images/pelatihan/", $request->gambar, $request->gambar_url);
            $pelatihan->nomor_pelatihan = generate_nomor_pelatihan($request->kategori, $request->tanggal_pelatihan);
            $pelatihan->deskripsi_pelatihan = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-pelatihan/'));
            $pelatihan->trainer = $request->trainer;
            $pelatihan->kode_trainer = str_replace('/', '.', $pelatihan->nomor_pelatihan).'.T';
            $pelatihan->fee_member = str_replace('.', '', $request->fee);
            $pelatihan->fee_non_member = 0;
			$pelatihan->materi_pelatihan = generate_materi_pelatihan($request->get('kode_unit'), $request->get('judul_unit'), $request->get('durasi'));
			$pelatihan->total_jam_pelatihan = array_sum($request->get('durasi'));
            $pelatihan->pelatihan_at = date('Y-m-d H:i:s');
            $pelatihan->save();
        }

        // Redirect
        return redirect()->route('admin.pelatihan.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form detail pelatihan
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data pelatihan
    	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->findOrFail($id);
        $pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
        
        // Get data default rekening
        $default_rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('tipe_platform','asc')->get();
		
		if(Auth::user()->is_admin == 1){
            // View
            return view('faturcms::admin.pelatihan.detail', [
                'pelatihan' => $pelatihan,
            ]);
		}
		elseif(Auth::user()->is_admin == 0){
			// Cek pelatihan member
			$cek_pelatihan = PelatihanMember::where('id_pelatihan','=',$pelatihan->id_pelatihan)->where('id_user','=',Auth::user()->id_user)->first();
			
			// Cek total pelatihan member
			$cek_total = PelatihanMember::where('id_user','=',Auth::user()->id_user)->get();
			
			// Generate invoice
			$invoice = generate_invoice(Auth::user()->id_user, 'PEM').'.'.(count($cek_total)+1);
			
			// View
			return view('faturcms::member.pelatihan.detail', [
				'default_rekening' => $default_rekening,
				'pelatihan' => $pelatihan,
				'cek_pelatihan' => $cek_pelatihan,
				'cek_total' => $cek_total,
				'invoice' => $invoice,
			]);
		}
    }

    /**
     * Menampilkan form edit pelatihan
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data pelatihan
        $pelatihan = Pelatihan::findOrFail($id);
        $pelatihan->materi_pelatihan = json_decode($pelatihan->materi_pelatihan, true);
        
        // Mentor
        $trainer = User::where('role','=',role('trainer'))->orderBy('nama_user','asc')->get();

        // View
        return view('faturcms::admin.pelatihan.edit', [
            'pelatihan' => $pelatihan,
            'trainer' => $trainer,
        ]);
    }

    /**
     * Mengupdate pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|max:255',
            'trainer' => 'required|max:255',
            'tanggal_pelatihan' => 'required',
            'tanggal_sertifikat' => 'required',
            'fee' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{             
            // Mengupdate data
            $pelatihan = Pelatihan::find($request->id);
            $pelatihan->nama_pelatihan = $request->nama_pelatihan;
            $pelatihan->tempat_pelatihan = $request->tempat_pelatihan != '' ? $request->tempat_pelatihan : '';
            $pelatihan->tanggal_pelatihan_from = generate_date_range('explode', $request->tanggal_pelatihan)['from'];
            $pelatihan->tanggal_pelatihan_to = generate_date_range('explode', $request->tanggal_pelatihan)['to'];
            $pelatihan->tanggal_sertifikat_from = generate_date_range('explode', $request->tanggal_sertifikat)['from'];
            $pelatihan->tanggal_sertifikat_to = generate_date_range('explode', $request->tanggal_sertifikat)['to'];
            $pelatihan->gambar_pelatihan = generate_image_name("assets/images/pelatihan/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/pelatihan/", $request->gambar, $request->gambar_url) : $pelatihan->gambar_pelatihan;
            $pelatihan->deskripsi_pelatihan = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-pelatihan/'));
            $pelatihan->trainer = $request->trainer;
            $pelatihan->fee_member = str_replace('.', '', $request->fee);
            $pelatihan->materi_pelatihan = generate_materi_pelatihan($request->get('kode_unit'), $request->get('judul_unit'), $request->get('durasi'));
            $pelatihan->total_jam_pelatihan = array_sum($request->get('durasi'));
            $pelatihan->save();
        }

        // Redirect
        return redirect()->route('admin.pelatihan.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $pelatihan = Pelatihan::find($request->id);
        $pelatihan->delete();

        // Redirect
        return redirect()->route('admin.pelatihan.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Menampilkan daftar peserta
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function participant($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data pelatihan
    	$pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->findOrFail($id);
		
		if(Auth::user()->is_admin == 1){
            // Data pelatihan member
            $pelatihan_member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('pelatihan_member.id_pelatihan','=',$pelatihan->id_pelatihan)->orderBy('pm_at','desc')->get();
            
            // View
            return view('faturcms::admin.pelatihan.participant', [
                'pelatihan' => $pelatihan,
                'pelatihan_member' => $pelatihan_member,
            ]);
		}
		elseif(Auth::user()->is_admin == 0){
			// Data pelatihan member
			$pelatihan_member = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('pelatihan_member.id_pelatihan','=',$pelatihan->id_pelatihan)->where('trainer','=',Auth::user()->id_user)->orderBy('pm_at','desc')->get();
			
			// View
			return view('faturcms::member.pelatihan.participant', [
				'pelatihan' => $pelatihan,
				'pelatihan_member' => $pelatihan_member,
			]);
		}
    }

    /**
     * Update status peserta
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        // Update status peserta
        $pelatihan_member = PelatihanMember::find($request->id);
        $pelatihan_member->status_pelatihan = $request->status;
        $pelatihan_member->save();
        
        echo 'Berhasil mengupdate status peserta!';
    }

    /**
     * Daftar Pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Data pelatihan
        $pelatihan = Pelatihan::find($request->id);
        
        // Mengupload file
        $file = $request->file('foto');
        if($file != null){
            $filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
            $file->move('assets/images/fee-pelatihan', $filename);
        }
        else{
            $filename = '';
        }
        
        // Menghitung member yang sudah ada
        $members = PelatihanMember::where('id_pelatihan','=',$request->id)->count();
        
        // Menambah data
        $pelatihan_member = new PelatihanMember;
        $pelatihan_member->id_user = Auth::user()->id_user;
        $pelatihan_member->id_pelatihan = $request->id;
        $pelatihan_member->kode_sertifikat = generate_nomor_sertifikat($members, $pelatihan);
        $pelatihan_member->status_pelatihan = 0;
        $pelatihan_member->fee = $request->fee;
        $pelatihan_member->fee_bukti = $filename;
        $pelatihan_member->fee_status = $request->fee > 0 ? 0 : 1;
        $pelatihan_member->inv_pelatihan = $request->inv_pelatihan;
        $pelatihan_member->pm_at = date('Y-m-d H:i:s');
        $pelatihan_member->save();
        
        $pm = PelatihanMember::where('pm_at','=',$pelatihan_member->pm_at)->first();
        
        // Send Mail Notification
        // if($request->fee > 0){
        //     // $receivers = ["ajifatur2@gmail.com", "dwinurkholisoh1@gmail.com", "randyrahmanhussen@gmail.com", "farisfanani.id@gmail.com"];
        //     $receivers = get_penerima_notifikasi();
        //     foreach($receivers as $receiver){
        //         Mail::to($receiver)->send(new TrainingPaymentMail($pm->id_pm, Auth::user()->id_user));
        //     }
        // }

        // Redirect
        return redirect()->route('member.pelatihan.detail', ['id' => $request->id]);
    }
    
    /**
     * Menampilkan data pelatihan berdasarkan trainer
     *
     * @return \Illuminate\Http\Response
     */
    public function trainer()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data pelatihan yang dia traineri
        $pelatihan = Pelatihan::join('users','pelatihan.trainer','=','users.id_user')->where('trainer','=',Auth::user()->id_user)->where('role','=',role('trainer'))->orderBy('tanggal_pelatihan_from','desc')->get();

        // View
        return view('faturcms::member.pelatihan.trainer', [
            'pelatihan' => $pelatihan
        ]);
    }
	
    /**
     * Menampilkan data transaksi pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function transaction()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
        if(Auth::user()->is_admin == 1){
            // Data pelatihan member
            $pelatihan_member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->orderBy('pm_at','desc')->get();
            
            // View
            return view('faturcms::admin.pelatihan.transaction', [
                'pelatihan_member' => $pelatihan_member,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
            // Data pelatihan member
            $pelatihan_member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_user','=',Auth::user()->id_user)->orderBy('pm_at','desc')->get();
            
            // View
            return view('faturcms::member.pelatihan.transaction', [
                'pelatihan_member' => $pelatihan_member,
            ]);
        }
    }

    /**
     * Verifikasi pembayaran aktivasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // Mengupdate data pelatihan
        $pelatihan_member = PelatihanMember::find($request->id);
        $pelatihan_member->fee_status = 1;
        $pelatihan_member->save();

        // Redirect
        return redirect()->route('admin.pelatihan.transaction')->with(['message' => 'Berhasil memverifikasi pembayaran.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/pelatihan')));
    }
}
