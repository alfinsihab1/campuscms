<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Mails\RegisterMail;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Komisi;

class VerificationController extends Controller
{
    /**
     * Verifikasi Email
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {		
		// Get user
		$user = User::where('email','=',$request->query('email'))->first();

        // Jika user tidak ditemukan
        if(!$user){
            // View
            return view('auth.'.setting('site.view.email_verification'), [
                'user' => $user,
                'status' => 0,
            ]);
        }
        // Jika user ditemukan
        else{
            // Jika user belum terverifikasi
            if($user->email_verified == 0){
                // Update status verifikasi email
                $user->email_verified = 1;
                $user->save();
                
                // Get komisi
                $komisi = Komisi::where('id_user','=',$user->id_user)->first();
                
                // Send Mail
                Mail::to($user->email)->send(new RegisterMail($user->id_user, $komisi->id_komisi));
                
                // Redirect
                return redirect()->route('member.dashboard');
            }
            // Jika user sudah terverifikasi
            else{
                // View
                return view('auth.'.setting('site.view.email_verification'), [
                    'user' => $user,
                    'status' => 1,
                ]);
            }
        }
    }	
}
