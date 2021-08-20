<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Deskripsi;

class DeskripsiController extends Controller
{
    /**
     * Menampilkan data deskripsi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data deskripsi
        $deskripsi = Deskripsi::first();
        
        // View
        return view('faturcms::admin.deskripsi.index', [
            'deskripsi' => $deskripsi,
        ]);
    }

    /**
     * Mengupdate deskripsi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_deskripsi' => 'required|max:255',
            'deskripsi' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'judul_deskripsi',
                'deskripsi'
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $deskripsi = Deskripsi::first();
            if(!$deskripsi) $deskripsi = new Deskripsi;
            $deskripsi->judul_deskripsi = $request->judul_deskripsi;
            $deskripsi->deskripsi = $request->deskripsi;
            $deskripsi->save();
        }

        // Redirect
        return redirect()->route('admin.deskripsi.index')->with(['message' => 'Berhasil mangupdate data.']);
    }
}
