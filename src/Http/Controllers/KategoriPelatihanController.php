<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\KategoriPelatihan;

class KategoriPelatihanController extends Controller
{
    /**
     * Menampilkan data kategori pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kategori
        $kategori = KategoriPelatihan::all();
        
        // View
        return view('faturcms::admin.kategori-pelatihan.index', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menampilkan form tambah kategori pelatihan
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.kategori-pelatihan.create');
    }

    /**
     * Menambah kategori pelatihan
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
            $kategori = new KategoriPelatihan;
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_pelatihan', 'slug', 'id_kp', null);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.pelatihan.kategori.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori pelatihan
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = KategoriPelatihan::findOrFail($id);
        
        // View
        return view('faturcms::admin.kategori-pelatihan.edit', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mengupdate kategori pelatihan
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
            $kategori = KategoriPelatihan::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_pelatihan', 'slug', 'id_kp', $request->id);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.pelatihan.kategori.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori pelatihan
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $kategori = KategoriPelatihan::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect()->route('admin.pelatihan.kategori.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
