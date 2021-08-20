<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Mentor;

class MentorController extends Controller
{
    /**
     * Menampilkan data mentor
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data mentor
        $mentor = Mentor::orderBy('order_mentor','asc')->get();
        
        // View
        return view('faturcms::admin.mentor.index', [
            'mentor' => $mentor,
        ]);
    }

    /**
     * Menampilkan form tambah mentor
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.mentor.create');
    }

    /**
     * Menambah mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mentor' => 'required',
            'profesi_mentor' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_mentor',
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Mentor::latest('order_mentor')->first();

            // Menambah data
            $mentor = new Mentor;
            $mentor->nama_mentor = $request->nama_mentor;
            $mentor->profesi_mentor = $request->profesi_mentor;
            $mentor->foto_mentor = generate_image_name("assets/images/mentor/", $request->gambar, $request->gambar_url);
            $mentor->order_mentor = $latest ? $latest->order_mentor + 1 : 1;
            $mentor->save();
        }

        // Redirect
        return redirect()->route('admin.mentor.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit mentor
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data mentor
        $mentor = Mentor::findOrFail($id);

        // View
        return view('faturcms::admin.mentor.edit', [
            'mentor' => $mentor
        ]);
    }

    /**
     * Mengupdate mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_mentor' => 'required',
            'profesi_mentor' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_mentor',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $mentor = Mentor::find($request->id);
            $mentor->nama_mentor = $request->nama_mentor;
            $mentor->profesi_mentor = $request->profesi_mentor;
            $mentor->foto_mentor = generate_image_name("assets/images/mentor/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/mentor/", $request->gambar, $request->gambar_url) : $mentor->foto_mentor;
            $mentor->save();
        }

        // Redirect
        return redirect()->route('admin.mentor.index')->with(['message' => 'Berhasil mangupdate data.']);
    }

    /**
     * Menghapus mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $mentor = Mentor::find($request->id);
        $mentor->delete();

        // Redirect
        return redirect()->route('admin.mentor.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/mentor'), ['..png']));
    }

    /**
     * Mengurutkan mentor
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan mentor
        foreach($request->get('ids') as $key=>$id){
            $mentor = Mentor::find($id);
            if($mentor){
                $mentor->order_mentor = $key + 1;
                $mentor->save();
            }
        }
        echo 'Sukses mengupdate urutan mentor!';
    }
}
