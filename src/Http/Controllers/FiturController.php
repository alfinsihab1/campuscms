<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Fitur;

class FiturController extends Controller
{
    /**
     * Menampilkan data fitur
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data fitur
        $fitur = Fitur::orderBy('order_fitur','asc')->get();
        
        // View
        return view('faturcms::admin.fitur.index', [
            'fitur' => $fitur,
        ]);
    }

    /**
     * Menampilkan form tambah fitur
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.fitur.create');
    }

    /**
     * Menambah fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_fitur' => 'required',
            'deskripsi_fitur' => 'required',
            'url_fitur' => 'max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_fitur',
                'deskripsi_fitur',
                'url_fitur'
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Fitur::latest('order_fitur')->first();

            // Menambah data
            $fitur = new Fitur;
            $fitur->nama_fitur = $request->nama_fitur;
            $fitur->deskripsi_fitur = $request->deskripsi_fitur;
            $fitur->url_fitur = $request->url_fitur != '' ? $request->url_fitur : '';
            $fitur->gambar_fitur = generate_image_name("assets/images/fitur/", $request->gambar, $request->gambar_url);
            $fitur->order_fitur = $latest ? $latest->order_fitur + 1 : 1;
            $fitur->save();
        }

        // Redirect
        return redirect()->route('admin.fitur.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit fitur
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data fitur
        $fitur = Fitur::findOrFail($id);

        // View
        return view('faturcms::admin.fitur.edit', [
            'fitur' => $fitur
        ]);
    }

    /**
     * Mengupdate fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_fitur' => 'required',
            'deskripsi_fitur' => 'required',
            'url_fitur' => 'max:255',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_fitur',
                'deskripsi_fitur',
                'url_fitur'
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $fitur = Fitur::find($request->id);
            $fitur->nama_fitur = $request->nama_fitur;
            $fitur->deskripsi_fitur = $request->deskripsi_fitur;
            $fitur->url_fitur = $request->url_fitur != '' ? $request->url_fitur : '';
            $fitur->gambar_fitur = generate_image_name("assets/images/fitur/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/fitur/", $request->gambar, $request->gambar_url) : $fitur->gambar_fitur;
            $fitur->save();
        }

        // Redirect
        return redirect()->route('admin.fitur.index')->with(['message' => 'Berhasil mangupdate data.']);
    }

    /**
     * Menghapus fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $fitur = Fitur::find($request->id);
        $fitur->delete();

        // Redirect
        return redirect()->route('admin.fitur.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/fitur'), ['..png']));
    }

    /**
     * Mengurutkan fitur
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan fitur
        foreach($request->get('ids') as $key=>$id){
            $fitur = Fitur::find($id);
            if($fitur){
                $fitur->order_fitur = $key + 1;
                $fitur->save();
            }
        }
        echo 'Sukses mengupdate urutan fitur!';
    }
}
