<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Mitra;

class MitraController extends Controller
{
    /**
     * Menampilkan data mitra
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data mitra
        $mitra = Mitra::orderBy('order_mitra','asc')->get();
        
        // View
        return view('faturcms::admin.mitra.index', [
            'mitra' => $mitra,
        ]);
    }

    /**
     * Menampilkan form tambah mitra
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.mitra.create');
    }

    /**
     * Menambah mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_mitra',
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Mitra::latest('order_mitra')->first();

            // Menambah data
            $mitra = new Mitra;
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->logo_mitra = generate_image_name("assets/images/mitra/", $request->gambar, $request->gambar_url);
            $mitra->order_mitra = $latest ? $latest->order_mitra + 1 : 1;
            $mitra->save();
        }

        // Redirect
        return redirect()->route('admin.mitra.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit mitra
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data mitra
        $mitra = Mitra::findOrFail($id);

        // View
        return view('faturcms::admin.mitra.edit', [
            'mitra' => $mitra
        ]);
    }

    /**
     * Mengupdate mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mitra' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_mitra',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $mitra = Mitra::find($request->id);
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->logo_mitra = generate_image_name("assets/images/mitra/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/mitra/", $request->gambar, $request->gambar_url) : $mitra->logo_mitra;
            $mitra->save();
        }

        // Redirect
        return redirect()->route('admin.mitra.index')->with(['message' => 'Berhasil mangupdate data.']);
    }

    /**
     * Menghapus mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $mitra = Mitra::find($request->id);
        $mitra->delete();

        // Redirect
        return redirect()->route('admin.mitra.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/mitra'), ['..png']));
    }

    /**
     * Mengurutkan mitra
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan mitra
        foreach($request->get('ids') as $key=>$id){
            $mitra = Mitra::find($id);
            if($mitra){
                $mitra->order_mitra = $key + 1;
                $mitra->save();
            }
        }
        echo 'Sukses mengupdate urutan mitra!';
    }
}
