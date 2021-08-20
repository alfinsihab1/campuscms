<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Halaman;

class HalamanController extends Controller
{
    /**
     * Menampilkan data halaman
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data halaman
        $halaman = Halaman::orderBy('halaman_at','desc')->get();
		
        // View
        return view('faturcms::admin.halaman.index', [
            'halaman' => $halaman,
        ]);
    }

    /**
     * Menampilkan form tambah halaman
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.halaman.create');
    }

    /**
     * Menambah halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_halaman' => 'required|max:255',
            'tipe' => 'required',
            'view' => $request->tipe == 2 ? 'required' : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'judul_halaman',
                'tipe',
                'view',
            ]));
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $halaman = new Halaman;
            $halaman->halaman_title = $request->judul_halaman;
            $halaman->halaman_permalink = slugify($request->judul_halaman, 'halaman', 'halaman_permalink', 'id_halaman', null);
            $halaman->halaman_tipe = $request->tipe;
            $halaman->konten = $request->tipe == 1 ? htmlentities(upload_quill_image($request->konten, 'assets/images/konten-halaman/')) : $request->view;
            $halaman->halaman_at = date('Y-m-d H:i:s');
            $halaman->save();
        }

        // Redirect
        return redirect()->route('admin.halaman.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit halaman
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data halaman
    	$halaman = Halaman::findOrFail($id);

        // View
        return view('faturcms::admin.halaman.edit', [
        	'halaman' => $halaman,
        ]);
    }

    /**
     * Mengupdate halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_halaman' => 'required|max:255',
            'tipe' => 'required',
            'view' => $request->tipe == 2 ? 'required' : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'judul_halaman',
                'tipe',
                'view',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $halaman = Halaman::find($request->id);
            $halaman->halaman_title = $request->judul_halaman;
            $halaman->halaman_permalink = slugify($request->judul_halaman, 'halaman', 'halaman_permalink', 'id_halaman', $request->id);
            $halaman->halaman_tipe = $request->tipe;
            $halaman->konten = $request->tipe == 1 ? htmlentities(upload_quill_image($request->konten, 'assets/images/konten-halaman/')) : $request->view;
            $halaman->save();
        }

        // Redirect
        return redirect()->route('admin.halaman.edit', ['id' => $request->id])->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus halaman
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $halaman = Halaman::find($request->id);
        $halaman->delete();

        // Redirect
        return redirect()->route('admin.halaman.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/halaman'), ['..png']));
    }
}
