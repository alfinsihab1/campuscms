<?php

namespace Ajifatur\FaturCMS\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Withdrawal;

class WithdrawalMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($user, $withdrawal)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
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
		$withdrawal = Withdrawal::find($this->withdrawal);
		
        return $this->from($cs->email, setting('site.name'))->markdown('faturcms::email.withdrawal')->subject('Pengambilan Komisi Member '.setting('site.name'))->with([
            'user' => $user,
            'withdrawal' => $withdrawal,
        ]);
    }
}
