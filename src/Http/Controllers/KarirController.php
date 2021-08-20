<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Karir;

class KarirController extends Controller
{
    /**
     * Menampilkan data karir
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data karir
        $karir = Karir::join('users','karir.author','=','users.id_user')->orderBy('karir_at','desc')->get();
		
        // View
        return view('faturcms::admin.karir.index', [
            'karir' => $karir,
        ]);
    }

    /**
     * Menampilkan form tambah karir
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.karir.create');
    }

    /**
     * Menambah karir
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_karir' => 'required|max:255',
            'url' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'judul_karir',
                'url',
            ]));
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $karir = new Karir;
            $karir->karir_title = $request->judul_karir;
            $karir->karir_permalink = slugify($request->judul_karir, 'karir', 'karir_permalink', 'id_karir', null);
            $karir->karir_gambar = generate_image_name("assets/images/karir/", $request->gambar, $request->gambar_url);
            $karir->karir_url = $request->url;
            $karir->konten = htmlentities(upload_quill_image($request->konten, 'assets/images/konten-karir/'));
            $karir->author = Auth::user()->id_user;
            $karir->karir_at = date('Y-m-d H:i:s');
            $karir->save();
        }

        // Redirect
        return redirect()->route('admin.karir.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit karir
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data karir
    	$karir = Karir::findOrFail($id);

        // View
        return view('faturcms::admin.karir.edit', [
        	'karir' => $karir,
        ]);
    }

    /**
     * Mengupdate karir
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'judul_karir' => 'required|max:255',
            'url' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'judul_karir',
                'url',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $karir = Karir::find($request->id);
            $karir->karir_title = $request->judul_karir;
            $karir->karir_permalink = slugify($request->judul_karir, 'karir', 'karir_permalink', 'id_karir', $request->id);
            $karir->karir_gambar = generate_image_name("assets/images/karir/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/karir/", $request->gambar, $request->gambar_url) : $karir->karir_gambar;
            $karir->karir_url = $request->url;
            $karir->konten = htmlentities(upload_quill_image($request->konten, 'assets/images/konten-karir/'));
            $karir->save();
        }

        // Redirect
        return redirect()->route('admin.karir.edit', ['id' => $request->id])->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus karir
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $karir = Karir::find($request->id);
        $karir->delete();

        // Redirect
        return redirect()->route('admin.karir.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/karir'), ['..png']));
    }
}
