<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Cabang;

class CabangController extends Controller
{
    /**
     * Menampilkan data cabang
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data cabang
        $cabang = Cabang::all();

        // View
        return view('faturcms::admin.cabang.index', [
            'cabang' => $cabang,
        ]);
    }

    /**
     * Menampilkan form tambah cabang
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.cabang.create');
    }

    /**
     * Menambah cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|max:255',
            'nomor_telepon_cabang' => 'required|numeric',
            'alamat_cabang' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $cabang = new Cabang;
            $cabang->nama_cabang = $request->nama_cabang;
            $cabang->nomor_telepon_cabang = $request->nomor_telepon_cabang;
            $cabang->instagram_cabang = $request->instagram_cabang != '' ? $request->instagram_cabang : '';
            $cabang->alamat_cabang = $request->alamat_cabang;
            $cabang->cabang_at = date('Y-m-d H:i:s');
            $cabang->save();
        }

        // Redirect
        return redirect()->route('admin.cabang.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit cabang
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data cabang
        $cabang = Cabang::findOrFail($id);

        // View
        return view('faturcms::admin.cabang.edit', [
            'cabang' => $cabang
        ]);
    }

    /**
     * Mengupdate cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|max:255',
            'nomor_telepon_cabang' => 'required|numeric',
            'alamat_cabang' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $cabang = Cabang::find($request->id);
            $cabang->nama_cabang = $request->nama_cabang;
            $cabang->nomor_telepon_cabang = $request->nomor_telepon_cabang;
            $cabang->instagram_cabang = $request->instagram_cabang != '' ? $request->instagram_cabang : '';
            $cabang->alamat_cabang = $request->alamat_cabang;
            $cabang->save();
        }

        // Redirect
        return redirect()->route('admin.cabang.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus cabang
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $cabang = Cabang::find($request->id);
        $cabang->delete();

        // Redirect
        return redirect()->route('admin.cabang.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
