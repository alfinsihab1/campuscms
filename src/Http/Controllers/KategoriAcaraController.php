<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\KategoriAcara;

class KategoriAcaraController extends Controller
{
    /**
     * Menampilkan data kategori acara
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kategori
        $kategori = KategoriAcara::all();
        
        // View
        return view('faturcms::admin.kategori-acara.index', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menampilkan form tambah kategori acara
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.kategori-acara.create');
    }

    /**
     * Menambah kategori acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $kategori = new KategoriAcara;
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_acara', 'slug', 'id_ka', null);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.acara.kategori.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori acara
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = KategoriAcara::findOrFail($id);
        
        // View
        return view('faturcms::admin.kategori-acara.edit', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mengupdate kategori acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $kategori = KategoriAcara::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_acara', 'slug', 'id_ka', $request->id);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.acara.kategori.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $kategori = KategoriAcara::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect()->route('admin.acara.kategori.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
