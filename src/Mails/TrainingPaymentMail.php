<?php

namespace Ajifatur\FaturCMS\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Ajifatur\FaturCMS\Models\PelatihanMember;

class TrainingPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($pelatihan, $user)
    {
        $this->pelatihan = $pelatihan;
        $this->user = $user;
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
		
		// Get data pelatihan
		$pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->find($this->pelatihan);
		
		// Get data user
		$user = is_int($this->user) ? User::find($this->user) : $this->user;
		
        return $this->from($cs->email, setting('site.name'))->markdown('faturcms::email.training-payment')->subject('Verifikasi Pembayaran Pelatihan')->with([
            'pelatihan' => $pelatihan,
            'user' => $user,
        ]);
    }
}
