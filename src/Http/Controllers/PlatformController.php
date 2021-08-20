<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Platform;

class PlatformController extends Controller
{
    /**
     * Menampilkan data platform
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data platform
        $platform = Platform::orderBy('tipe_platform','asc')->orderBy('nama_platform','asc')->get();

        // View
        return view('faturcms::admin.platform.index', [
            'platform' => $platform,
        ]);
    }

    /**
     * Menampilkan form tambah platform
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.platform.create');
    }

    /**
     * Menambah platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_platform' => 'required|max:255',
            'tipe_platform' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $platform = new Platform;
            $platform->nama_platform = $request->nama_platform;
            $platform->tipe_platform = $request->tipe_platform;
            $platform->kode_platform = $request->kode_platform != '' ? $request->kode_platform : '';
            $platform->save();
        }

        // Redirect
        return redirect()->route('admin.platform.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit platform
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data platform
        $platform = Platform::findOrFail($id);

        // View
        return view('faturcms::admin.platform.edit', [
            'platform' => $platform,
        ]);
    }

    /**
     * Mengupdate platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_platform' => 'required|max:255',
            'tipe_platform' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $platform = Platform::find($request->id);
            $platform->nama_platform = $request->nama_platform;
            $platform->tipe_platform = $request->tipe_platform;
            $platform->kode_platform = $request->kode_platform != '' ? $request->kode_platform : '';
            $platform->save();
        }

        // Redirect
        return redirect()->route('admin.platform.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus platform
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Menghapus data
        $platform = Platform::find($request->id);
        $platform->delete();

        // Redirect
        return redirect()->route('admin.platform.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
