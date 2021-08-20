<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Popup;

class PopupController extends Controller
{
    /**
     * Menampilkan data pop-up
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data pop-up
        $popup = Popup::orderBy('popup_from','desc')->get();
			
        // View
        return view('faturcms::admin.pop-up.index', [
            'popup' => $popup,
        ]);
    }

    /**
     * Menampilkan form tambah pop-up
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.pop-up.create');
    }

    /**
     * Menambah pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'popup_judul' => 'required|max:255',
            'popup_tipe' => 'required',
            'foto' => $request->popup_tipe == 1 ? 'required' : '',
            'popup' => $request->popup_tipe == 2 ? 'required' : '',
            'popup_waktu' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'popup_judul',
                'popup_tipe',
                'popup',
                'popup_waktu',
            ]));
        }
        // Jika tidak ada error
        else{
            // Explode date
            $explode_date = explode(' - ', $request->popup_waktu);

            // Menambah data
            $popup = new Popup;
            $popup->popup_judul = $request->popup_judul;
            $popup->popup_tipe = $request->popup_tipe;
            if($popup->popup_tipe == 1){
                // Mengupload file
                $file = $request->file('foto');
                $filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
                $file->move('assets/images/pop-up', $filename);
                $popup->popup = $filename;
            }
            else $popup->popup = $request->popup;
            $popup->popup_from = count($explode_date) == 2 ? generate_date_format($explode_date[0], 'y-m-d') : null;
            $popup->popup_to = count($explode_date) == 2 ? generate_date_format($explode_date[1], 'y-m-d') : null;
            $popup->popup_konten = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-pop-up/'));
            $popup->popup_at = date('Y-m-d H:i:s');
            $popup->save();
        }

        // Redirect
        return redirect()->route('admin.pop-up.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form detail pop-up
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        //
    }

    /**
     * Menampilkan form edit pop-up
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data pop-up
        $popup = Popup::findOrFail($id);

        // View
        return view('faturcms::admin.pop-up.edit', [
            'popup' => $popup,
        ]);
    }

    /**
     * Mengupdate pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'popup_judul' => 'required|max:255',
            'popup_tipe' => 'required',
            // 'foto' => $request->popup_tipe == 1 ? 'required' : '',
            'popup' => $request->popup_tipe == 2 ? 'required' : '',
            'popup_waktu' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'popup_judul',
                'popup_tipe',
                'popup',
                'popup_waktu',
            ]));
        }
        // Jika tidak ada error
        else{
            // Explode date
            $explode_date = explode(' - ', $request->popup_waktu);

            // Mengupdate data
            $popup = Popup::find($request->id);
            $popup->popup_judul = $request->popup_judul;
            $popup->popup_tipe = $request->popup_tipe;
            if($popup->popup_tipe == 1){
                // Mengupload file
                $file = $request->file('foto');

                // If gambar not null
                if($file != null){
                    $filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
                    $file->move('assets/images/pop-up', $filename);
                    $popup->popup = $filename;
                }
            }
            else $popup->popup = $request->popup;
            $popup->popup_from = count($explode_date) == 2 ? generate_date_format($explode_date[0], 'y-m-d') : null;
            $popup->popup_to = count($explode_date) == 2 ? generate_date_format($explode_date[1], 'y-m-d') : null;
            $popup->popup_konten = htmlentities(upload_quill_image($request->deskripsi, 'assets/images/konten-pop-up/'));
            $popup->save();
        }

        // Redirect
        return redirect()->route('admin.pop-up.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus pop-up
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $popup = Popup::find($request->id);
        $popup->delete();

        // Redirect
        return redirect()->route('admin.pop-up.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
