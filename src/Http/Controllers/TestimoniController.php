<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Testimoni;

class TestimoniController extends Controller
{
    /**
     * Menampilkan data testimoni
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data testimoni
        $testimoni = Testimoni::orderBy('order_testimoni','asc')->get();
        
        // View
        return view('faturcms::admin.testimoni.index', [
            'testimoni' => $testimoni,
        ]);
    }

    /**
     * Menampilkan form tambah testimoni
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.testimoni.create');
    }

    /**
     * Menambah testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_klien' => 'required',
            'testimoni' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_klien',
                'profesi_klien',
                'testimoni',
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Testimoni::latest('order_testimoni')->first();

            // Menambah data
            $testimoni = new Testimoni;
            $testimoni->nama_klien = $request->nama_klien;
            $testimoni->profesi_klien = $request->profesi_klien != '' ? $request->profesi_klien : '';
            $testimoni->foto_klien = generate_image_name("assets/images/testimoni/", $request->gambar, $request->gambar_url);
            $testimoni->testimoni = $request->testimoni;
            $testimoni->order_testimoni = $latest ? $latest->order_testimoni + 1 : 1;
            $testimoni->save();
        }

        // Redirect
        return redirect()->route('admin.testimoni.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit testimoni
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data testimoni
        $testimoni = Testimoni::findOrFail($id);

        // View
        return view('faturcms::admin.testimoni.edit', [
            'testimoni' => $testimoni
        ]);
    }

    /**
     * Mengupdate testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_klien' => 'required',
            'testimoni' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_klien',
                'profesi_klien',
                'testimoni',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $testimoni = Testimoni::find($request->id);
            $testimoni->nama_klien = $request->nama_klien;
            $testimoni->profesi_klien = $request->profesi_klien != '' ? $request->profesi_klien : '';
            $testimoni->foto_klien = generate_image_name("assets/images/testimoni/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/testimoni/", $request->gambar, $request->gambar_url) : $testimoni->foto_klien;
            $testimoni->testimoni = $request->testimoni;
            $testimoni->save();
        }

        // Redirect
        return redirect()->route('admin.testimoni.index')->with(['message' => 'Berhasil mangupdate data.']);
    }

    /**
     * Menghapus testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $testimoni = Testimoni::find($request->id);
        $testimoni->delete();

        // Redirect
        return redirect()->route('admin.testimoni.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/testimoni'), ['..png']));
    }

    /**
     * Mengurutkan testimoni
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan testimoni
        foreach($request->get('ids') as $key=>$id){
            $testimoni = Testimoni::find($id);
            if($testimoni){
                $testimoni->order_testimoni = $key + 1;
                $testimoni->save();
            }
        }
        echo 'Sukses mengupdate urutan testimoni!';
    }
}
