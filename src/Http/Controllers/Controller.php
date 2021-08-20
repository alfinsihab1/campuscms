<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // curl_lms([
        //     'key' => get_lms_key(),
        //     'username' => get_lms_username(),
        //     'host' => url()->to('/')
        // ]);
    }
}
