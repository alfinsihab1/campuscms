<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Platform;
use Ajifatur\FaturCMS\Models\Rekening;

class RekeningController extends Controller
{
    /**
     * Menampilkan data rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // Data rekening
            $rekening = Rekening::join('users','rekening.id_user','=','users.id_user')->join('platform','rekening.id_platform','=','platform.id_platform')->orderBy('id_rekening','desc')->get();

            // View
            return view('faturcms::admin.rekening.index', [
                'rekening' => $rekening,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
            // User belum membayar
            if(Auth::user()->status == 0) abort(403, message('unpaid'));
            
            // Data rekening
            $rekening = Rekening::join('users','rekening.id_user','=','users.id_user')->join('platform','rekening.id_platform','=','platform.id_platform')->where('rekening.id_user','=',Auth::user()->id_user)->orderBy('id_rekening','desc')->get();

            // View
            return view('faturcms::member.rekening.index', [
                'rekening' => $rekening,
            ]);
        }
    }

    /**
     * Menampilkan form tambah rekening
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // User
            $user = User::where('is_admin','=',0)->where('status','=',1)->get();

            // Data platform bank
            $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
            
            // Data platform fintech
            $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();

            // View
            return view('faturcms::admin.rekening.create', [
                'user' => $user,
                'bank' => $bank,
                'fintech' => $fintech,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
    		// User belum membayar
            if(Auth::user()->status == 0) abort(403, message('unpaid'));
    			
    		// Data platform bank
    		$bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
    		
    		// Data platform fintech
    		$fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();
    		
            // View
            return view('faturcms::member.rekening.create', [
    			'bank' => $bank,	
    			'fintech' => $fintech,	
    		]);
        }
    }

    /**
     * Menambah rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'user' => Auth::user()->is_admin == 1 ? 'required' : '',
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $rekening = new Rekening;
            $rekening->id_user = Auth::user()->is_admin == 1 ? $request->user : Auth::user()->id_user;
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        if(Auth::user()->is_admin == 1)
            return redirect()->route('admin.rekening.index')->with(['message' => 'Berhasil menambah data.']);
        elseif(Auth::user()->is_admin == 0)
            return redirect()->route('member.rekening.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit rekening
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        if(Auth::user()->is_admin == 1){
            // Data rekening
            $rekening = Rekening::findOrFail($id);

            // Data platform bank
            $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
            
            // Data platform fintech
            $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();

            // View
            return view('faturcms::admin.rekening.edit', [
                'bank' => $bank,
                'fintech' => $fintech,
                'rekening' => $rekening,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
            // User belum membayar
            if(Auth::user()->status == 0) abort(403, message('unpaid'));
            
            // Data rekening
            $rekening = Rekening::where('id_user','=',Auth::user()->id_user)->findOrFail($id);

            // Data platform bank
            $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
            
            // Data platform fintech
            $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();

            // View
            return view('faturcms::member.rekening.edit', [
                'bank' => $bank,
                'fintech' => $fintech,
                'rekening' => $rekening,
            ]);
        }
    }

    /**
     * Mengupdate rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'platform' => 'required',
            'nomor' => 'required|numeric',
            'atas_nama' => 'required|max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $rekening = Rekening::find($request->id);
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        if(Auth::user()->is_admin == 1)
            return redirect()->route('admin.rekening.index')->with(['message' => 'Berhasil mengupdate data.']);
        elseif(Auth::user()->is_admin == 0)
            return redirect()->route('member.rekening.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus rekening
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Menghapus data
        $rekening = Rekening::find($request->id);
        $rekening->delete();

        // Redirect
        if(Auth::user()->is_admin == 1)
            return redirect()->route('admin.rekening.index')->with(['message' => 'Berhasil menghapus data.']);
        elseif(Auth::user()->is_admin == 0)
            return redirect()->route('member.rekening.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
