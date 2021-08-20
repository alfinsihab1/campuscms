<?php

namespace Ajifatur\FaturCMS\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Komisi;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($user, $komisi)
    {
        $this->user = $user;
        $this->komisi = $komisi;
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
		$user = User::find($this->user);
		$komisi = Komisi::find($this->komisi);
		
        return $this->from($cs->email, setting('site.name'))->markdown('faturcms::email.confirmation')->subject('Verifikasi Komisi Member '.setting('site.name'))->with([
            'user' => $user,
            'komisi' => $komisi,
        ]);
    }
}
