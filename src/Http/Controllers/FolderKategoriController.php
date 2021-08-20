<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\FolderKategori;

class FolderKategoriController extends Controller
{
    /**
     * Menampilkan data kategori folder
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kategori
        $kategori = FolderKategori::orderBy('status_kategori','desc')->orderBy('order_kategori','asc')->get();
        
        // View
        return view('faturcms::admin.folder-kategori.index', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menampilkan form tambah kategori folder
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.folder-kategori.create');
    }

    /**
     * Menambah kategori folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'tipe' => 'required',
            'status' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = FolderKategori::latest('order_kategori')->first();

            // Menambah data
            $kategori = new FolderKategori;
            $kategori->folder_kategori = $request->kategori;
            $kategori->slug_kategori = slugify($request->kategori, 'folder_kategori', 'slug_kategori', 'id_fk', null);
            $kategori->tipe_kategori = $request->tipe;
            $kategori->status_kategori = $request->status;
            $kategori->prefix_kategori = $request->prefix_kategori != '' ? $request->prefix_kategori : '' ;
            $kategori->icon_kategori = $request->icon_kategori != '' ? $request->icon_kategori : '' ;
            $kategori->order_kategori = $latest ? $latest->order_kategori + 1 : 1;
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.folder.kategori.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit kategori folder
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = FolderKategori::findOrFail($id);
        
        // View
        return view('faturcms::admin.folder-kategori.edit', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mengupdate kategori folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'tipe' => 'required',
            'status' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $kategori = FolderKategori::find($request->id);
            $kategori->folder_kategori = $request->kategori;
            $kategori->slug_kategori = slugify($request->kategori, 'folder_kategori', 'slug_kategori', 'id_fk', $request->id);
            $kategori->tipe_kategori = $request->tipe;
            $kategori->status_kategori = $request->status;
            $kategori->prefix_kategori = $request->prefix_kategori != '' ? $request->prefix_kategori : '' ;
            $kategori->icon_kategori = $request->icon_kategori != '' ? $request->icon_kategori : '' ;
            $kategori->save();
        }

        // Redirect
		return redirect()->route('admin.folder.kategori.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kategori folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $kategori = FolderKategori::find($request->id);
        $kategori->delete();

        // Redirect
        return redirect()->route('admin.folder.kategori.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Mengurutkan kategori folder
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan kategori
        foreach($request->get('ids') as $key=>$id){
            $kategori = FolderKategori::find($id);
            if($kategori){
                $kategori->order_kategori = $key + 1;
                $kategori->save();
            }
        }
        echo 'Sukses mengupdate urutan kategori!';
    }
}
