<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Kelompok;

class KelompokController extends Controller
{
    /**
     * Menampilkan data kelompok
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kelompok
        $kelompok = Kelompok::orderBy('kelompok_at','desc')->get();
        
        // View
        return view('faturcms::admin.kelompok.index', [
            'kelompok' => $kelompok,
        ]);
    }

    /**
     * Menampilkan form tambah kelompok
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // User
        $user = User::where('is_admin','=',0)->where('status','=',1)->orderBy('nama_user','asc')->get();

        // View
        return view('faturcms::admin.kelompok.create', [
            'user' => $user,
        ]);
    }

    /**
     * Menambah kelompok
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_kelompok' => 'required|max:255',
            'anggota_kelompok' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_kelompok',
                'anggota_kelompok',
            ]));
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $kelompok = new Kelompok;
            $kelompok->nama_kelompok = $request->nama_kelompok;
            $kelompok->anggota_kelompok = implode(',', $request->get('anggota_kelompok'));
            $kelompok->kelompok_at = date('Y-m-d H:i:s');
            $kelompok->save();
        }

        // Redirect
        return redirect()->route('admin.user.kelompok.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan detail kelompok
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

    	// Data kelompok
    	$kelompok = Kelompok::findOrFail($id);

        // Data anggota
        $ids = explode(',', $kelompok->anggota_kelompok);
        $anggota = User::where('is_admin','=',0)->where('status','=',1)->whereIn('id_user',$ids)->orderBy('nama_user','asc')->get();
		
        // View
        return view('faturcms::admin.kelompok.detail', [
            'kelompok' => $kelompok,
            'anggota' => $anggota,
        ]);
    }

    /**
     * Menampilkan form edit kelompok
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data kelompok
        $kelompok = Kelompok::findOrFail($id);

        // User
        $user = User::where('is_admin','=',0)->where('status','=',1)->orderBy('nama_user','asc')->get();

        // Data anggota
        $ids = explode(',', $kelompok->anggota_kelompok);
        
        // View
        return view('faturcms::admin.kelompok.edit', [
            'kelompok' => $kelompok,
            'user' => $user,
            'ids' => $ids,
        ]);
    }

    /**
     * Mengupdate kelompok
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_kelompok' => 'required|max:255',
            'anggota_kelompok' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_kelompok',
                'anggota_kelompok',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $kelompok = Kelompok::find($request->id);
            $kelompok->nama_kelompok = $request->nama_kelompok;
            $kelompok->anggota_kelompok = implode(',', $request->get('anggota_kelompok'));
            $kelompok->save();
        }

        // Redirect
        return redirect()->route('admin.user.kelompok.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus kelompok
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $kelompok = Kelompok::find($request->id);
        $kelompok->delete();

        // Redirect
        return redirect()->route('admin.user.kelompok.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
