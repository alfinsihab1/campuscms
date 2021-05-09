<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use Ajifatur\FaturCMS\Models\Package;

class PackageController extends Controller
{
  /**
   * Menampilkan data package
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);

    // View
    return view('faturcms::admin.package.index', [
      'package' => composer_lock()['packages'],
    ]);
  }

  /**
   * Menampilkan detail package
   *
   * @return \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function detail(Request $request)
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);

    // Mencoba melakukan request package
    try {
      $client = new Client(['base_uri' => 'https://api.github.com/repos/']);
      $package_request = $client->request('GET', $request->query('package'));
    } catch (ClientException $e) {
      echo Psr7\Message::toString($e->getResponse());
      return;
    }

    // Request package berhasil
    $package = json_decode($package_request->getBody(), true);

    // Request package releases
    $releases_request = $client->request('GET', $request->query('package').'/releases');
    $releases = json_decode($releases_request->getBody(), true);
    
    // View
    return view('faturcms::admin.package.detail', [
      'package' => $package,
      'releases' => $releases,
    ]);
  }

  /**
   * Menampilkan my package
   *
   * @return \Illuminate\Http\Response
   */
  public function me()
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);

    // Request package berhasil
    $json = file_get_contents(package_path('composer.json'));
    $package = json_decode($json, true);

    // My Package
    $my_package = Package::where('package_name','=',config('faturcms.name'))->first();
    
    // View
    return view('faturcms::admin.package.me', [
      'package' => $package,
      'my_package' => $my_package,
    ]);
  }

  /**
   * Update my package
   *
   * @return \Illuminate\Http\Response
   */
  public function updateMe()
  {
    // Check Access
    has_access(generate_method(__METHOD__), Auth::user()->role);
    
    // Update from packagist
    $process = new Process([setting('site.server.php'), setting('site.server.composer'), 'update', 'ajifatur/faturcms'], base_path());
    $process->setTimeout(null);
    $process->run();
  
    // Executes after the command finishes
    if(!$process->isSuccessful()){
      throw new ProcessFailedException($process);
    }

    // Mencoba melakukan request package
    try {
      $client = new Client(['base_uri' => 'https://api.github.com/repos/']);
      $package_request = $client->request('GET', config('faturcms.name').'/releases/latest');
    } catch (ClientException $e) {
      echo Psr7\Message::toString($e->getResponse());
      return;
    }
    $releases = json_decode($package_request->getBody(), true);

    // Update package detail
    $package = Package::where('package_name','=',config('faturcms.name'))->first();
    if($package){
      $package->package_version = array_key_exists('name', $releases) ? $releases['name'] : '';
      $package->package_up = date('Y-m-d H:i:s');
      $package->save();
    }
    else{
      $package = new Package;
      $package->package_name = config('faturcms.name');
      $package->package_version = array_key_exists('name', $releases) ? $releases['name'] : '';
      $package->package_at = date('Y-m-d H:i:s');
      $package->package_up = date('Y-m-d H:i:s');
      $package->save();
    }

    // Update FaturCMS
    Artisan::call("faturcms:update");
    dd(Artisan::output());
  }
}
