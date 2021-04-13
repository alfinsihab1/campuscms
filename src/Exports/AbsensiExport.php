<?php

namespace Ajifatur\FaturCMS\Exports;

use Ajifatur\FaturCMS\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class AbsensiExport implements FromView
{
	use Exportable;

    /**
     * Create a new message instance.
     *
     * int id pelamar
     * @return void
     */
    public function __construct($absensi)
    {
        $this->absensi = $absensi;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	// View
    	return view('faturcms::admin.absensi.excel', [
    		'absensi' => $this->absensi
    	]);
    }
}
