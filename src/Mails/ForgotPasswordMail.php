<?php

namespace Ajifatur\FaturCMS\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($id)
    {
        $this->id_user = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // CS
        $cs = User::where('role','=',role('cs'))->first();

		// Get data user
		$user = User::find($this->id_user);
		
		// Change password
		$new_password = Str::random(8);
		$user->password = bcrypt($new_password);
		$user->save();
		
        return $this->from($cs->email, setting('site.name'))->markdown('faturcms::email.forgot-password')->subject('Recovery Password '.setting('site.name'))->with([
            'user' => $user,
			'new_password' => $new_password
        ]);
    }
}
