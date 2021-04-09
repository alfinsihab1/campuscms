<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
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
        if(Auth::user()->role == role('it') || Auth::user()->role == role('manager')){
            // Data slider
            $slider = Slider::orderBy('order_slider','asc')->orderBy('status_slider','desc')->get();
            
            // View
            return view('faturcms::admin.slider.index', [
                'slider' => $slider,
            ]);
        }
        else{
            // View
            abort(403);
        }
    }

    /**
     * Menampilkan form tambah slider
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role('it') || Auth::user()->role == role('manager')){
                // View
                return view('faturcms::admin.slider.create');
            }
            else{
                // View
                abort(403);
            }
        }
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
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{			
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/slider/") : '';

            // Menambah data
            $slider = new Slider;
            $slider->slider = $image_name;
            $slider->slider_url = $request->url != '' ? $request->url : '';
            $slider->status_slider = $request->status_slider;
            $slider->save();
        }

        // Redirect
        return redirect('/admin/konten-web/slider')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit slider
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->is_admin == 1){
            if(Auth::user()->role == role('it') || Auth::user()->role == role('manager')){
                // Data slider
                $slider = Slider::find($id);

                if(!$slider){
                    abort(404);
                }

                // View
                return view('faturcms::admin.slider.edit', [
                    'slider' => $slider
                ]);
            }
            else{
                // View
                abort(403);
            }
        }
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
        ], validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{	
            // Upload gambar
            $image_name = $request->gambar != '' ? upload_file_content($request->gambar, "assets/images/slider/") : '';

            // Mengupdate data
            $slider = Slider::find($request->id);
            $slider->slider = $request->gambar != '' ? $image_name : $slider->slider;
            $slider->slider_url = $request->url != '' ? $request->url : '';
            $slider->status_slider = $request->status_slider;
            $slider->save();
        }

        // Redirect
        return redirect('/admin/konten-web/slider')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus slider
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
    	// Menghapus data
        $slider = Slider::find($request->id);
        $slider->delete();

        // Redirect
        return redirect('/admin/konten-web/slider')->with(['message' => 'Berhasil menghapus data.']);
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
     * Mengambil data slider
     *
     * @return \Illuminate\Http\Response
     */
    public function getSlider()
    {
        // Data slider
        $slider = Slider::where('status_slider',1)->orderBy('id_slider','asc')->get();
        
        foreach($slider as $data){
            $data->slider = $data->slider != '' ? '/assets/images/slider/'.$data->slider : '';
        }

        echo json_encode($slider);
    }
}
