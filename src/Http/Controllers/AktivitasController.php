<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;

class AktivitasController extends Controller
{
    /**
     * Menampilkan detail aktivitas
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Get data user
        $user = User::findOrFail($id);

        // Get data aktivitas
        // Jika ada file tercatat
        if(File::exists(storage_path('logs/user-activities/'.$id.".log"))){
            // Mengkonversi ke object
            $logs = File::get(storage_path('logs/user-activities/'.$id.".log"));
            $logs = substr($logs, 0, -1);
            $logs = "[".$logs."]";
            $logs = json_decode($logs);
        }
        // Jika file tidak tercatat
        else{
            $logs = false;
        }
        
        // View
        return view('faturcms::admin.aktivitas.detail', [
            'user' => $user,
            'logs' => $logs,
        ]);
    }
}
