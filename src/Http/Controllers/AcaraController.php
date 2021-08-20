<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\KategoriAcara;
use Ajifatur\FaturCMS\Models\Acara;

class AcaraController extends Controller
{
    /**
     * Menampilkan data acara
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data acara
        $acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->orderBy('tanggal_acara_from','desc')->get();
        
        // View
        return view('faturcms::admin.acara.index', [
            'acara' => $acara,
        ]);
    }

    /**
     * Menampilkan form tambah acara
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Kategori
        $kategori = KategoriAcara::all();

        // View
        return view('faturcms::admin.acara.create', [
            'kategori' => $kategori,
        ]);
    }

    /**
     * Menambah acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_acara' => 'required|max:255',
            'kategori' => 'required',
            'tanggal_acara' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_acara',
                'kategori',
                'tempat_acara',
                'tanggal_acara',
            ]));
        }
        // Jika tidak ada error
        else{			
            // Menambah data
            $acara = new Acara;
            $acara->nama_acara = $request->nama_acara;
            $acara->slug_acara = slugify($request->nama_acara, 'acara', 'slug_acara', 'id_acara', null);
            $acara->kategori_acara = $request->kategori;
            $acara->tempat_acara = $request->tempat_acara != '' ? $request->tempat_acara : '';
            $acara->tanggal_acara_from = generate_date_range('explode', $request->tanggal_acara)['from'];
            $acara->tanggal_acara_to = generate_date_range('explode', $request->tanggal_acara)['to'];
            $acara->gambar_acara = generate_image_name("assets/images/acara/", $request->gambar, $request->gambar_url);
            $acara->deskripsi_acara = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-acara/'));
            $acara->acara_at = date('Y-m-d H:i:s');
            $acara->save();
        }

        // Redirect
        return redirect()->route('admin.acara.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan detail acara
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data acara
    	$acara = Acara::join('kategori_acara','acara.kategori_acara','=','kategori_acara.id_ka')->findOrFail($id);
		
        // View
        return view('faturcms::admin.acara.detail', [
            'acara' => $acara,
        ]);
    }

    /**
     * Menampilkan form edit acara
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data acara
        $acara = Acara::findOrFail($id);

        // Kategori
        $kategori = KategoriAcara::all();

        // View
        return view('faturcms::admin.acara.edit', [
            'acara' => $acara,
            'kategori' => $kategori,
        ]);
    }

    /**
     * Mengupdate acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_acara' => 'required|max:255',
            'kategori' => 'required|max:255',
            'tanggal_acara' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{             
            // Mengupdate data
            $acara = Acara::find($request->id);
            $acara->nama_acara = $request->nama_acara;
            $acara->slug_acara = slugify($request->nama_acara, 'acara', 'slug_acara', 'id_acara', $request->id);
            $acara->kategori_acara = $request->kategori;
            $acara->tempat_acara = $request->tempat_acara != '' ? $request->tempat_acara : '';
            $acara->tanggal_acara_from = generate_date_range('explode', $request->tanggal_acara)['from'];
            $acara->tanggal_acara_to = generate_date_range('explode', $request->tanggal_acara)['to'];
            $acara->gambar_acara = generate_image_name("assets/images/acara/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/acara/", $request->gambar, $request->gambar_url) : $acara->gambar_acara;
            $acara->deskripsi_acara = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-acara/'));
            $acara->save();
        }

        // Redirect
        return redirect()->route('admin.acara.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus acara
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $acara = Acara::find($request->id);
        $acara->delete();

        // Redirect
        return redirect()->route('admin.acara.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/acara'), ['..png']));
    }
}
