<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Slider;

class SliderController extends Controller
{
    /**
     * Menampilkan data slider
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data slider
        $slider = Slider::orderBy('order_slider','asc')->orderBy('status_slider','desc')->get();
        
        // View
        return view('faturcms::admin.slider.index', [
            'slider' => $slider,
        ]);
    }

    /**
     * Menampilkan form tambah slider
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.slider.create');
    }

    /**
     * Menambah slider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'url' => 'max:255',
            'status_slider' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'url',
                'status_slider'
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Slider::latest('order_slider')->first();

            // Menambah data
            $slider = new Slider;
            $slider->slider = generate_image_name("assets/images/slider/", $request->gambar, $request->gambar_url);
            $slider->slider_url = $request->url != '' ? $request->url : '';
            $slider->status_slider = $request->status_slider;
            $slider->order_slider = $latest ? $latest->order_slider + 1 : 1;
            $slider->save();
        }

        // Redirect
        return redirect()->route('admin.slider.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit slider
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data slider
        $slider = Slider::findOrFail($id);

        // View
        return view('faturcms::admin.slider.edit', [
            'slider' => $slider
        ]);
    }

    /**
     * Mengupdate slider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'url' => 'max:255',
            'status_slider' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'url',
                'status_slider'
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $slider = Slider::find($request->id);
            $slider->slider = generate_image_name("assets/images/slider/", $request->gambar, $request->gambar_url) != '' ? generate_image_name("assets/images/slider/", $request->gambar, $request->gambar_url) : $slider->slider;
            $slider->slider_url = $request->url != '' ? $request->url : '';
            $slider->status_slider = $request->status_slider;
            $slider->save();
        }

        // Redirect
        return redirect()->route('admin.slider.index')->with(['message' => 'Berhasil mangupdate data.']);
    }

    /**
     * Menghapus slider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $slider = Slider::find($request->id);
        $slider->delete();

        // Redirect
        return redirect()->route('admin.slider.index')->with(['message' => 'Berhasil menghapus data.']);
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        echo json_encode(generate_file(public_path('assets/images/slider'), ['..png']));
    }

    /**
     * Mengurutkan slider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan slider
        foreach($request->get('ids') as $key=>$id){
            $slider = Slider::find($id);
            if($slider){
                $slider->order_slider = $key + 1;
                $slider->save();
            }
        }
        echo 'Sukses mengupdate urutan slider!';
    }
    
    /**
     * JSON data slider
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {
        // Get limit
        $limit = $request->query('limit');

        // Data slider
        $slider = $limit > 0 ? Slider::orderBy('order_slider','asc')->orderBy('status_slider','desc')->limit($limit)->get() : Slider::orderBy('order_slider','asc')->orderBy('status_slider','desc')->get();
        
        if(count($slider)>0){
            foreach($slider as $data){
                $data->slider = image('assets/images/slider/'.$data->slider, 'slider');
            }
        }

        // Return JSON
        return response()->json([
            'status' => 200,
            'data' => $slider,
            'message' => 'OK'
        ]);
    }
}
