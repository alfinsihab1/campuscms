<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\User;

class LogController extends Controller
{
    /**
    * Menampilkan log list
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Logs
        $logs = [
            ['title' => 'Log Aktivitas', 'description' => 'Menampilkan Log Aktivitas', 'url' => route('admin.visitor.index')],
            ['title' => 'Log Login Error', 'description' => 'Menampilkan Log Login Error', 'url' => route('admin.log.login')],
        ];

        // View
        return view('faturcms::admin.log.index', [
          'logs' => $logs,
        ]);
    }

    /**
     * Menampilkan log aktivitas
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function activity($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Get data user
        $user = User::findOrFail($id);

        // Get data aktivitas
        $logs = $this->toObject('logs/user-activities/'.$id.'.log');
        
        // View
        return view('faturcms::admin.log.activity', [
            'user' => $user,
            'logs' => $logs,
        ]);
    }

    /**
     * Menampilkan log login
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data login
        $logs = $this->toObject('logs/login/login.log');
        
        // View
        return view('faturcms::admin.log.login', [
            'logs' => $logs,
        ]);
    }

    /**
     * Mengkonversi konten file log ke object
     *
     * string $path
     * @return \Illuminate\Http\Response
     */
    public function toObject($path)
    {
        if(File::exists(storage_path($path))){
            $logs = File::get(storage_path($path));
            $logs = substr($logs, 0, -1);
            $logs = "[".$logs."]";
            $logs = json_decode($logs);
            return $logs;
        }
        else return false;            
    }
}
