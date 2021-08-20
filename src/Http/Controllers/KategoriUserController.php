<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\KategoriUser;

class KategoriUserController extends Controller
{
    /**
     * Menampilkan data kategori user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kategori
        $kategori = KategoriUser::all();
        
        // View
        return view('faturcms::admin.kategori-user.index', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menampilkan form tambah kategori user
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.kategori-user.create');
    }

    /**
     * Menambah kategori user
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
            $kategori = new KategoriUser;
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_user', 'slug', 'id_ku', null);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.user.kategori.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan detail user berdasarkan kategori
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data kategori
    	$kategori = KategoriUser::findOrFail($id);

        // Data user
        $user = User::where('is_admin','=',0)->where('status','=',1)->where('user_kategori','=',$kategori->id_ku)->orderBy('nama_user','asc')->get();
		
        // View
        return view('faturcms::admin.kategori-user.detail', [
            'kategori' => $kategori,
            'user' => $user,
        ]);
    }

    /**
     * Menampilkan form edit kategori user
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = KategoriUser::findOrFail($id);
        
        // View
        return view('faturcms::admin.kategori-user.edit', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mengupdate kategori user
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
            $kategori = KategoriUser::find($request->id);
            $kategori->kategori = $request->kategori;
            $kategori->slug = slugify($request->kategori, 'kategori_user', 'slug', 'id_ku', $request->id);
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.user.kategori.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $kategori = KategoriUser::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect()->route('admin.user.kategori.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
