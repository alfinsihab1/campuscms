<?php

namespace Ajifatur\FaturCMS\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromView
{
	use Exportable;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	// View
    	return view('faturcms::admin.user.excel', [
    		'user' => $this->user
    	]);
    }
}
