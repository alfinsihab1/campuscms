<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Ajifatur\FaturCMS\Imports\EmailImport;
use Ajifatur\FaturCMS\Mails\MessageMail;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Email;

class EmailController extends Controller
{
    /**
     * Menampilkan data email (JSON)
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
		if($request->ajax()){
			// Data email
			$email = Email::join('users','email.sender','=','users.id_user')->orderBy('scheduled','desc')->orderBy('sent_at','desc')->get();

			// Return
			return DataTables::of($email)
			->addColumn('checkbox', '<input type="checkbox">')
			->addColumn('email', function($data){
				$html = '';
				$html = '<a href="'.route('admin.email.detail', ['id' => $data->id_email]).'">'.$data->subject.'</a>';
				$html .= '<br>';
				if(count_penerima_email($data->receiver_id)>0){
					$html .= '<small class="text-muted"><i class="fa fa-check-circle mr-1"></i>Sudah dikirim kepada '.number_format(count_penerima_email($data->receiver_id),0,'.','.').' dari total '.number_format(count_member_aktif(),0,'.','.').' member.</small>';
				}
				return $html;
			})
			->addColumn('sender', function($data){
				return '
					<td>
						<a href="'.route('admin.user.detail', ['id' => $data->id_user]).'">'.$data->nama_user.'</a>
						<br>
						<small><i class="fa fa-envelope mr-1"></i>'.$data->email.'</small>
						<br>
						<small><i class="fa fa-phone mr-1"></i>'.$data->nomor_hp.'</small>
					</td>
				';
			})
			->addColumn('options', function($data){
				return '
					<div class="btn-group">
						<a href="'.route('admin.email.detail', ['id' => $data->id_email]).'" class="btn btn-info btn-sm" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>
						<a href="#" class="btn btn-warning btn-sm btn-schedule" data-id="'.$data->id_email.'" data-schedule="'.$data->scheduled.'" data-toggle="tooltip" title="Atur Jadwal"><i class="fa fa-clock-o"></i></a>
						<a href="#" class="btn btn-success btn-sm btn-forward" data-id="'.$data->id_email.'" data-r="'.$data->receiver_id.'" data-toggle="tooltip" title="Teruskan"><i class="fa fa-share"></i></a>
						<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="'.$data->id_email.'" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
					</div>
				';
			})
			->addColumn('scheduled', function($data){
				$html = '';
				if($data->scheduled != null){
					$html .= '<span>Harian</span>';
					$html .= '<br>';
					$html .= '<small><i class="fa fa-clock-o mr-1"></i>'.$data->scheduled.' WIB</small>';
				}
				else{
					$html .= '<span class="badge badge-danger">Tidak</span>';
				}
				return $html;
			})
			->addColumn('sent_at', function($data){
				return '
					<span class="d-none">'.$data->sent_at.'</span>
					'.date('d/m/Y', strtotime($data->sent_at)).'
					<br>
					<small><i class="fa fa-clock-o mr-1"></i>'.date('H:i', strtotime($data->sent_at)).' WIB</small>
				';
			})
			->removeColumn(['password', 'tanggal_lahir', 'jenis_kelamin', 'content', 'receiver_email'])
			->rawColumns(['checkbox', 'email', 'sender', 'scheduled', 'sent_at', 'options'])
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
     * Menampilkan data email
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
		
        // View
        return view('faturcms::admin.email.index');
    }

    /**
     * Menampilkan form tulis pesan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
		
        // View
        return view('faturcms::admin.email.create');
    }

    /**
     * Mengirim dan menyimpan pesan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'subjek' => 'required|max:255',
            'terjadwal' => 'required',
            'scheduled' => $request->terjadwal == 1 ? 'required|unique:email' : '',
            'emails' => $request->terjadwal == 0 ? 'required' : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'subjek',
                'ids',
                'names',
                'emails',
                'terjadwal',
                'scheduled'
            ]));
        }
        // Jika tidak ada error
        else{
            // Kirim pesan jika tidak terjadwal
            if($request->terjadwal == 0){
                if($request->ids != ""){
                    // Explode
                    $ids = explode(",", $request->ids);
                    $emails = explode(", ", $request->emails);

                    // Mengirim pesan
                    foreach($ids as $id){
                        $receiver = User::find($id);
                        Mail::to($receiver->email)->send(new MessageMail(Auth::user()->email, $receiver, $request->subjek, htmlentities($request->pesan)));
                    }
                }
                else{
                    // Explode
                    $names = explode(", ", $request->names);
                    $emails = explode(", ", $request->emails);

                    // Mengirim pesan
                    foreach($emails as $key=>$email){
                        Mail::to($email)->send(new MessageMail(Auth::user()->email, $names[$key], $request->subjek, htmlentities($request->pesan)));
                    }
                }
            }
			
			// Simpan pesan
			$mail = new Email;
			$mail->subject = $request->subjek;
			$mail->receiver_id = $request->ids != '' ? $request->terjadwal == 0 ? $request->ids : '' : '';
			$mail->receiver_email = $request->terjadwal == 0 ? $request->emails : '';
			$mail->sender = Auth::user()->id_user;
			$mail->content = htmlentities(upload_quill_image($request->pesan, 'assets/images/konten-email/'));
            $mail->scheduled = $request->terjadwal == 1 ? $request->scheduled : null;
			$mail->sent_at = date('Y-m-d H:i:s');
			$mail->save();
        }

        // Redirect
        if($request->terjadwal == 0)
            return redirect()->route('admin.email.index')->with(['message' => 'Berhasil mengirim pesan.']);
        elseif($request->terjadwal == 1)
            return redirect()->route('admin.email.index')->with(['message' => 'Berhasil menyimpan pesan. Pesan akan dikirim sesuai jadwal.']);
    }
	
    /**
     * Menampilkan email
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data email
        $email = Email::join('users','email.sender','=','users.id_user')->findOrFail($id);

        // View
        return view('faturcms::admin.email.detail', [
            'email' => $email,
        ]);
    }

    /**
     * Menghapus email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Menghapus data
        $email = Email::find($request->id);
        $email->delete();

        // Redirect
        return redirect()->route('admin.email.index')->with(['message' => 'Berhasil menghapus pesan.']);
    }

    /**
     * Memforward pesan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forward(Request $request)
    {
        // Get email
        $mail = Email::join('users','email.sender','=','users.id_user')->findOrFail($request->id);

        // Explode
        $ids = explode(",", $request->receiver);

        // Send Mail
        foreach($ids as $id){
            $receiver = User::find($id);
            Mail::to($receiver->email)->send(new MessageMail(Auth::user()->email, $receiver, $mail->subject, html_entity_decode($mail->content)));
        }

        // Merge Receiver
        $receiver_old = explode(",", $mail->receiver_id);
        $merge = array_merge($receiver_old, $ids);
        $mail->receiver_id = implode(",", $merge);
        $mail->save();

        // Redirect
        return redirect()->route('admin.email.index')->with(['message' => 'Berhasil mem-forward pesan.']);
    }

    /**
     * Mengatur jadwal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function schedule(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'terjadwal' => 'required',
            'scheduled' => $request->terjadwal == 1 ? ['required', Rule::unique('email')->ignore($request->id, 'id_email')] : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate jadwal
            $email = Email::find($request->id);
            $email->scheduled = $request->terjadwal == 1 ? $request->scheduled : null;
            $email->save();
    
            // Redirect
            return redirect()->route('admin.email.index')->with(['message' => 'Berhasil mengatur jadwal.']);
        }
    }
 
    /**
     * Mengimport email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request) 
    {       
        echo json_encode(Excel::toArray(new EmailImport, $request->file('file')));
    }

    /**
     * Mengambil data member JSON
     *
     * @return \Illuminate\Http\Response
     */
    public function memberJson()
    {
        // Data user
        $user = User::select('id_user', 'nama_user', 'email')->where('is_admin','=',0)->where('status','=',1)->get();

        // Response
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => $user
        ]);
    }
}
