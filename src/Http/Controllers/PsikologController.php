<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Psikolog;

class PsikologController extends Controller
{
    /**
     * Menampilkan data psikolog
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data psikolog
        $psikolog = Psikolog::all();

        // View
        return view('faturcms::admin.psikolog.index', [
            'psikolog' => $psikolog,
        ]);
    }

    /**
     * Menampilkan form tambah psikolog
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.psikolog.create');
    }

    /**
     * Menambah psikolog
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_psikolog' => 'required|max:255',
            'kategori_psikolog' => 'required',
            'kode_psikolog' => 'required|unique:psikolog',
            'nomor_telepon_psikolog' => 'required|numeric',
            'alamat_psikolog' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $psikolog = new Psikolog;
            $psikolog->nama_psikolog = $request->nama_psikolog;
            $psikolog->kategori_psikolog = $request->kategori_psikolog;
            $psikolog->kode_psikolog = $request->kode_psikolog;
            $psikolog->nomor_telepon_psikolog = $request->nomor_telepon_psikolog;
            $psikolog->instagram_psikolog = $request->instagram_psikolog != '' ? $request->instagram_psikolog : '';
            $psikolog->alamat_psikolog = $request->alamat_psikolog;
            $psikolog->psikolog_at = date('Y-m-d H:i:s');
            $psikolog->save();
        }

        // Redirect
        return redirect()->route('admin.psikolog.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit psikolog
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data psikolog
        $psikolog = Psikolog::findOrFail($id);

        // View
        return view('faturcms::admin.psikolog.edit', [
            'psikolog' => $psikolog
        ]);
    }

    /**
     * Mengupdate psikolog
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_psikolog' => 'required|max:255',
            'kategori_psikolog' => 'required',
            'kode_psikolog' => [
                'required', Rule::unique('psikolog')->ignore($request->id, 'id_psikolog')
            ],
            'nomor_telepon_psikolog' => 'required|numeric',
            'alamat_psikolog' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $psikolog = Psikolog::find($request->id);
            $psikolog->nama_psikolog = $request->nama_psikolog;
            $psikolog->kategori_psikolog = $request->kategori_psikolog;
            $psikolog->kode_psikolog = $request->kode_psikolog;
            $psikolog->nomor_telepon_psikolog = $request->nomor_telepon_psikolog;
            $psikolog->instagram_psikolog = $request->instagram_psikolog != '' ? $request->instagram_psikolog : '';
            $psikolog->alamat_psikolog = $request->alamat_psikolog;
            $psikolog->save();
        }

        // Redirect
        return redirect()->route('admin.psikolog.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus psikolog
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $psikolog = Psikolog::find($request->id);
        $psikolog->delete();

        // Redirect
        return redirect()->route('admin.psikolog.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
