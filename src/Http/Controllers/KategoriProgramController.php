<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\KategoriProgram;

class KategoriprogramController extends Controller
{
    /**
     * Menampilkan data kategori program
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor')){
            // Data kategori
            $kategori = KategoriProgram::all();
            
            // View
            return view('faturcms::admin.kategori-program.index', [
                'kategori' => $kategori,
            ]);
        }
        else{
            // View
            abort(403);
        }
    }

    /**
     * Menampilkan form tambah kategori program
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor')){ 
            // View
            return view('faturcms::admin.kategori-program.create');
        }
        else{
            // View
            abort(403);
        }
    }

    /**
     * Menambah kategori program
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
            $kategori = new Kategoriprogram;
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_program', 'slug', 'id_kp', null);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.program.kategori.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori program
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role == role('it') || Auth::user()->role == role('manager') || Auth::user()->role == role('mentor')){ 
            // Kategori
            $kategori = KategoriProgram::findOrFail($id);
            
            // View
            return view('faturcms::admin.kategori-program.edit', [
                'kategori' => $kategori,
            ]);
        }
        else{
            // View
            abort(403);
        }
    }

    /**
     * Mengupdate kategori program
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
            $kategori = KategoriProgram::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_program', 'slug', 'id_kp', $request->id);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.program.kategori.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori program
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $kategori = KategoriProgram::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect()->route('admin.program.kategori.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
