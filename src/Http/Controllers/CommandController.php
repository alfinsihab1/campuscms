<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CommandController extends Controller
{
  /**
   * Menampilkan command list
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);

    // Composer Commands
    $composerCommands = [
        ['title' => 'Update Package', 'description' => 'composer update ajifatur/faturcms', 'url' => route('admin.command.composer.update')],
        ['title' => 'Composer Version', 'description' => 'composer --version', 'url' => route('admin.command.composer.version')],
    ];

    // Artisan Commands
    $artisanCommands = [
        // ['title' => 'Install FaturCMS', 'description' => 'php artisan faturcms:install', 'command' => 'faturcms:install'],
        // ['title' => 'Update FaturCMS', 'description' => 'php artisan faturcms:update', 'command' => 'faturcms:update'],
        ['title' => 'Clear Compiled', 'description' => 'php artisan clear-compiled', 'command' => 'clear-compiled'],
        ['title' => 'Clear Cache', 'description' => 'php artisan cache:clear', 'command' => 'cache:clear'],
        ['title' => 'Clear Config', 'description' => 'php artisan config:clear', 'command' => 'config:clear'],
        ['title' => 'Clear View', 'description' => 'php artisan view:clear', 'command' => 'view:clear'],
        ['title' => 'Inspiring Quote', 'description' => 'php artisan inspire', 'command' => 'inspire'],
    ];

    // View
    return view('faturcms::admin.command.index', [
      'composerCommands' => $composerCommands,
      'artisanCommands' => $artisanCommands,
    ]);
  }

  /**
   * Artisan Command
   *
   * @return \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function artisan(Request $request)
  {
    Artisan::call($request->command);
    dd(Artisan::output());
  }

  /**
   * Update package FaturCMS
   *
   * @return \Illuminate\Http\Response
   */
  public function updatePackage()
  {  
    $process = new Process(['/opt/plesk/php/7.3/bin/php', '/usr/lib64/plesk-9.0/composer.phar', 'update', 'ajifatur/faturcms'], base_path());
    $process->setTimeout(null);
    $process->run();
  
    // Executes after the command finishes
    if(!$process->isSuccessful()){
      throw new ProcessFailedException($process);
    }
  
    // echo "<pre>".$process->getOutput()."</pre>";

    Artisan::call("faturcms:update");
    dd(Artisan::output());
  }

  /**
   * Composer version
   *
   * @return \Illuminate\Http\Response
   */
  public function composerVersion()
  {	
    $process = new Process(['/opt/plesk/php/7.3/bin/php', '/usr/lib64/plesk-9.0/composer.phar', '--version'], base_path());
    $process->setTimeout(null);
    $process->run();
  
    // Executes after the command finishes
    if(!$process->isSuccessful()){
      throw new ProcessFailedException($process);
    }
  
    echo $process->getOutput();
  }
}
