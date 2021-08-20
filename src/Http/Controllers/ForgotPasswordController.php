<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ajifatur\FaturCMS\Mails\ForgotPasswordMail;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(Request $request)
    {
        // Referal
        referral($request->query('ref'), 'auth.forgotpassword', ['email' => $request->query('email')]);

        // View
        return view('auth.'.setting('site.view.forgot_password'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], array_validation_messages());
        
        // Get data user
        $user = User::where('email','=',$request->email)->first();
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            if(!$user){
                // Redirect
                return redirect()->route('auth.forgotpassword', ['ref' => $request->referral])->with(['message' => 'Email yang Anda masukkan tidak tersedia!']);
            }
            else{
                // Send Mail
                Mail::to($request->email)->send(new ForgotPasswordMail($user->id_user));
                
                // Redirect
                return redirect()->route('auth.forgotpassword', ['ref' => $request->referral])->with(['message' => 'Permintaan berhasil. Periksa inbox atau spam dan ikuti instruksi recovery password. Jika email masih belum muncul, hubungi Kami.']);
            }
        }
    }
}
