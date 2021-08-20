<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Tag;

class TagController extends Controller
{
    /**
     * Menampilkan data tag
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data tag
        $tag = Tag::all();
        
        // View
        return view('faturcms::admin.tag.index', [
            'tag' => $tag,
        ]);
    }

    /**
     * Menampilkan form tambah tag
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.tag.create');
    }

    /**
     * Menambah tag
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'tag' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $tag = new Tag;
            $tag->tag = $request->tag;
            $tag->slug = slugify($request->tag, 'tag', 'slug', 'id_tag', null);
            $tag->save();
        }

        // Redirect
		return redirect()->route('admin.blog.tag.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit tag
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // tag
        $tag = Tag::findOrFail($id);
        
        // View
        return view('faturcms::admin.tag.edit', [
            'tag' => $tag,
        ]);
    }

    /**
     * Mengupdate tag
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'tag' => 'required'
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $tag = Tag::find($request->id);
            $tag->tag = $request->tag;
            $tag->slug = slugify($request->tag, 'tag', 'slug', 'id_tag', $request->id);
            $tag->save();
        }

        // Redirect
		return redirect()->route('admin.blog.tag.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus tag
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $tag = Tag::find($request->id);
        $tag->delete();

        // Redirect
        return redirect()->route('admin.blog.tag.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
