<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Ajifatur\FaturCMS\Imports\EmailImport;
use Ajifatur\FaturCMS\Mails\MessageMail;
use App\User;
use Ajifatur\FaturCMS\Models\Email;

class EmailController extends Controller
{
    /**
     * Menampilkan data email
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data email
        $email = Email::join('users','email.sender','=','users.id_user')->orderBy('sent_at','desc')->get();
		
        // View
        return view('faturcms::admin.email.index', [
            'email' => $email,
        ]);
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
            'emails' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'subjek',
                'ids',
                'names',
                'emails',
            ]));
        }
        // Jika tidak ada error
        else{
			if($request->ids != ""){
				// Explode
				$ids = explode(",", $request->ids);
				$emails = explode(", ", $request->emails);

				// Send Mail
				foreach($ids as $id){
					$receiver = User::find($id);
					Mail::to($receiver->email)->send(new MessageMail(Auth::user()->email, $receiver, $request->subjek, htmlentities($request->pesan)));
				}
			}
			else{
				// Explode
				$names = explode(", ", $request->names);
				$emails = explode(", ", $request->emails);

				// Send Mail
				foreach($emails as $key=>$email){
					Mail::to($email)->send(new MessageMail(Auth::user()->email, $names[$key], $request->subjek, htmlentities($request->pesan)));
				}
			}
			
			// Simpan Mail
			$mail = new Email;
			$mail->subject = $request->subjek;
			$mail->receiver_id = $request->ids != '' ? $request->ids : '';
			$mail->receiver_email = $request->emails;
			$mail->sender = Auth::user()->id_user;
			$mail->content = htmlentities(upload_quill_image($request->pesan, 'assets/images/konten-email/'));
			$mail->sent_at = date('Y-m-d H:i:s');
			$mail->save();
        }

        // Redirect
        return redirect()->route('admin.email.index')->with(['message' => 'Berhasil mengirim pesan.']);
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
		
		// Get data member
		$members = User::where('is_admin','=',0)->get();

        // View
        return view('faturcms::admin.email.detail', [
            'email' => $email,
            'members' => $members,
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
