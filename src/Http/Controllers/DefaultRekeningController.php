<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\DefaultRekening;
use Ajifatur\FaturCMS\Models\Platform;
use Ajifatur\FaturCMS\Models\Rekening;

class DefaultRekeningController extends Controller
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

        // Data rekening
        $rekening = DefaultRekening::join('platform','default_rekening.id_platform','=','platform.id_platform')->orderBy('id_dr','desc')->get();

        // View
        return view('faturcms::admin.default-rekening.index', [
            'rekening' => $rekening,
        ]);
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

        // Data platform bank
        $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
        
        // Data platform fintech
        $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();

        // View
        return view('faturcms::admin.default-rekening.create', [
            'bank' => $bank,
            'fintech' => $fintech,
        ]);
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
            $rekening = new DefaultRekening;
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect()->route('admin.default-rekening.index')->with(['message' => 'Berhasil menambah data.']);
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

        // Data rekening
        $rekening = DefaultRekening::findOrFail($id);

        // Data platform bank
        $bank = Platform::where('tipe_platform','=',1)->orderBy('nama_platform','asc')->get();
        
        // Data platform fintech
        $fintech = Platform::where('tipe_platform','=',2)->orderBy('nama_platform','asc')->get();

        // View
        return view('faturcms::admin.default-rekening.edit', [
            'bank' => $bank,
            'fintech' => $fintech,
            'rekening' => $rekening,
        ]);
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
            $rekening = DefaultRekening::find($request->id);
            $rekening->id_platform = $request->platform;
            $rekening->nomor = $request->nomor;
            $rekening->atas_nama = $request->atas_nama;
            $rekening->save();
        }

        // Redirect
        return redirect()->route('admin.default-rekening.index')->with(['message' => 'Berhasil mengupdate data.']);
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
        $rekening = DefaultRekening::find($request->id);
        $rekening->delete();

        // Redirect
        return redirect()->route('admin.default-rekening.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
