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
   * Mengupdate package dari remote
   *
   * @return \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
	  $url = $request->query('url');

	  try {
		  $client = new Client(['base_uri' => $url.'/api/']);
		  $request = $client->request('POST', 'package/update');
	  } catch (ClientException $e) {
		  echo Psr7\Message::toString($e->getResponse());
		  return;
	  }
	  echo $request->getBody();
  }

  /**
   * Update my package
   *
   * @return \Illuminate\Http\Request
   * @return \Illuminate\Http\Response
   */
  public function updateMe(Request $request)
  {
    // Mengecek autentikasi subscriber
    try {
      $client = new Client(['base_uri' => 'https://fpm.campusdigital.id/api/']);
      $faturcms_request = $client->request('PUT', 'subscriber/auth', [
        'query' => [
          'url' => url()->to('/'),
          'key' => env('FATURCMS_APP_KEY'),
        ]
      ]);
    } catch (ClientException $e) {
      echo Psr7\Message::toString($e->getResponse());
      return;
    }
    $response = json_decode($faturcms_request->getBody(), true);
    if($response['status'] == 403){
      // echo $faturcms_request->getBody();
      echo '<div class="alert alert-danger text-center">'.$response['message'].'</div>';
      return;
    }
    
    // Update from packagist
    $process = new Process([setting('site.server.php'), setting('site.server.composer'), 'update', config('faturcms.name')], base_path());
    $process->setTimeout(null);
    $process->run();
  
    // Executes after the command finishes
    if(!$process->isSuccessful()){
      throw new ProcessFailedException($process);
    }

    // Update FaturCMS
    Artisan::call("faturcms:update");
    dd(Artisan::output());
  }
}
