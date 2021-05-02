<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\Kontributor;

class KontributorController extends Controller
{
    /**
     * Menampilkan data kontributor
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kontributor
        $kontributor = Kontributor::all();
        
        // View
        return view('faturcms::admin.kontributor.index', [
            'kontributor' => $kontributor,
        ]);
    }

    /**
     * Menampilkan form tambah kontributor
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.kontributor.create');
    }

    /**
     * Menambah kontributor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kontributor' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $kontributor = new Kontributor;
            $kontributor->kontributor = $request->kontributor;
            $kontributor->slug = slugify($request->kontributor, 'kontributor', 'slug', 'id_kontributor', null);
            $kontributor->save();
        }

        // Redirect
		return redirect()->route('admin.blog.kontributor.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kontributor
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // kontributor
        $kontributor = Kontributor::findOrFail($id);
        
        // View
        return view('faturcms::admin.kontributor.edit', [
            'kontributor' => $kontributor,
        ]);
    }

    /**
     * Mengupdate kontributor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kontributor' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $kontributor = Kontributor::find($request->id);
            $kontributor->kontributor = $request->kontributor;
            $kontributor->slug = slugify($request->kontributor, 'kontributor', 'slug', 'id_kontributor', $request->id);
            $kontributor->save();
        }

        // Redirect
		return redirect()->route('admin.blog.kontributor.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kontributor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $kontributor = Kontributor::find($request->id);
        $kontributor->delete();

        // Redirect
        return redirect()->route('admin.blog.kontributor.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
