<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ArtisanController extends Controller
{
  /**
   * Menampilkan artisan command list
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);

    // Artisan Commands
    $commands = [
        ['title' => 'Clear Compiled', 'description' => 'php artisan clear-compiled', 'command' => 'clear-compiled'],
        ['title' => 'Clear Cache', 'description' => 'php artisan cache:clear', 'command' => 'cache:clear'],
        ['title' => 'Clear Config', 'description' => 'php artisan config:clear', 'command' => 'config:clear'],
        ['title' => 'Clear View', 'description' => 'php artisan view:clear', 'command' => 'view:clear'],
        ['title' => 'Inspiring Quote', 'description' => 'php artisan inspire', 'command' => 'inspire'],
    ];

    // View
    return view('faturcms::admin.artisan.index', [
      'commands' => $commands,
    ]);
  }

  /**
   * Call Artisan Command
   *
   * @return \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function call(Request $request)
  {
    Artisan::call($request->command);
    dd(Artisan::output());
  }
}
