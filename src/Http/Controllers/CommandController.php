<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
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

    // View
    return view('faturcms::admin.command.index');
  }

  /**
   * Update package FaturCMS
   *
   * @return \Illuminate\Http\Response
   */
  public function updatePackage()
  {
    // ini_set('max_execution_time', 0);
    // ini_set('memory_limit', -1);
  
    $process = new Process(['/opt/plesk/php/7.3/bin/php', '/usr/lib64/plesk-9.0/composer.phar', 'update', 'ajifatur/faturcms'], base_path());
    $process->setTimeout(null);
    $process->run();
  
    // Executes after the command finishes
    if(!$process->isSuccessful()){
      throw new ProcessFailedException($process);
    }
  
    echo "<pre>".$process->getOutput()."</pre>";

    // Artisan::call('faturcms:update');
    // dd(Artisan::output());
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
