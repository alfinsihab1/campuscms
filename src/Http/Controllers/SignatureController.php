<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Signature;

class SignatureController extends Controller
{
    /**
     * Menampilkan data signature
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role('it') || Auth::user()->role == role('manager')){
            // Data signature
            $signature = Signature::join('users','signature.id_user','=','users.id_user')->orderBy('is_admin','desc')->get();
            
            // View
            return view('faturcms::admin.signature.index', [
                'signature' => $signature,
            ]);
        }
        else{
            // View
            abort(403);
        }
    }

    /**
     * Menampilkan form input signature
     *
     * @return \Illuminate\Http\Response
     */
    public function input()
    {
		if(Auth::user()->role == role('manager') || Auth::user()->role == role('mentor')){
			// Data signature
			$signature = Signature::where('id_user','=',Auth::user()->id_user)->firstOrFail();

			// View
			return view('faturcms::admin.signature.input', [
				'signature' => $signature,
			]);
		}
		// elseif(Auth::user()->role == role_trainer()){
		// 	// Data signature
		// 	$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();

		// 	// View
		// 	return view('signature/member/index', [
		// 		'signature' => $signature,
		// 	]);
		// }
		else{
			abort(403);
		}
    }

    /**
     * Mengupdate e-signature
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		// Get data
		$signature = Signature::where('id_user','=',Auth::user()->id_user)->first();

		// Jika belum ada
		if(!$signature) $signature = new Signature;

		if($request->signature != ''){
			// Buat e-signature sendiri
			$filename = generate_image_name("assets/images/signature/", $request->signature, '');
		}
		elseif($request->upload == 1){
			// Mengupload file
			$file = $request->file('foto');
			$filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
			$file->move('assets/images/signature', $filename);
		}

		// Simpan e-signature
		$signature->id_user = Auth::user()->id_user;
		$signature->signature = isset($filename) ? $filename : '';
		$signature->signature_at = date('Y-m-d H:i:s');
		$signature->save();

		// Redirect
		if(Auth::user()->is_admin == 1)
			return redirect()->route('admin.signature.input')->with(['message' => 'Berhasil menyimpan E-Signature.']);
		// elseif(Auth::user()->is_admin == 0)
		// 	return redirect('/member/e-signature')->with(['message' => 'Berhasil menyimpan E-Signature.']);
    }

    /**
     * Menghapus e-signature
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $signature = Signature::find($request->id);
        $signature->delete();

        // Redirect
        return redirect()->route('admin.signature.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
