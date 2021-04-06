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
        if(Auth::user()->is_admin == 1){
            // Data email
            $email = Email::join('users','email.sender','=','users.id_user')->orderBy('sent_at','desc')->get();
			
            // View
            return view('faturcms::admin.email.index', [
                'email' => $email,
            ]);
        }
    }

    /**
     * Menampilkan form tulis pesan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
    		// Get data member
    		$members = User::where('is_admin','=',0)->get();
    		
            // View
            return view('faturcms::admin.email.create', [
    			'members' => $members	
    		]);
        }
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
					// Mail::to($receiver->email)->send(new MessageMail(Auth::user()->email, $receiver, $request->subjek, htmlentities($html)));
				}
			}
			else{
				// Explode
				$names = explode(", ", $request->names);
				$emails = explode(", ", $request->emails);

				// Send Mail
				foreach($emails as $key=>$email){
					// Mail::to($email)->send(new MessageMail(Auth::user()->email, $names[$key], $request->subjek, htmlentities($html)));
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
    	// Menghapus data
        $email = Email::find($request->id);
        $email->delete();

        // Redirect
        return redirect()->route('admin.email.index')->with(['message' => 'Berhasil menghapus pesan.']);
    }

    /**
     * Mencari email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function search(Request $request)
    // {
    //     $users = User::where('is_admin','=',0)->where('email','like','%'.$request->search.'%')->get();
    //     echo json_encode($users);
    // }
 
    // Import excel
    public function import(Request $request) 
    {       
        echo json_encode(Excel::toArray(new EmailImport, $request->file('file')));
    }

}
