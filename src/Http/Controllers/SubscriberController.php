<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\User;
use Ajifatur\FaturCMS\Models\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Menampilkan data subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data subscriber
        $subscriber = Subscriber::all();
        
        // View
        return view('faturcms::admin.subscriber.index', [
            'subscriber' => $subscriber,
        ]);
    }

    /**
     * Menampilkan form tambah subscriber
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.subscriber.create');
    }

    /**
     * Menambah subscriber
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'subscriber_email' => 'required|email|unique:subscriber',
            'subscriber_url' => 'required|unique:subscriber',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $subscriber = new Subscriber;
            $subscriber->subscriber_email = $request->subscriber_email;
            $subscriber->subscriber_url = $request->subscriber_url;
            $subscriber->subscriber_key = Str::random(40);
            $subscriber->subscriber_version = '';
            $subscriber->subscriber_at = date('Y-m-d H:i:s');
            $subscriber->subscriber_up = date('Y-m-d H:i:s');
            $subscriber->save();
        }

        // Redirect
		return redirect()->route('admin.subscriber.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit subscriber
     *
     * * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // subscriber
        $subscriber = Subscriber::findOrFail($id);
        
        // View
        return view('faturcms::admin.subscriber.edit', [
            'subscriber' => $subscriber,
        ]);
    }

    /**
     * Mengupdate subscriber
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'subscriber_email' => [
                'required', 'email', Rule::unique('subscriber')->ignore($request->id, 'id_subscriber')
            ],
            'subscriber_url' => [
                'required', Rule::unique('subscriber')->ignore($request->id, 'id_subscriber')
            ],
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $subscriber = Subscriber::find($request->id);
            $subscriber->subscriber_email = $request->subscriber_email;
            $subscriber->subscriber_url = $request->subscriber_url;
            $subscriber->subscriber_up = date('Y-m-d H:i:s');
            $subscriber->save();
        }

        // Redirect
		return redirect()->route('admin.subscriber.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus subscriber
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);
        
    	// Menghapus data
        $subscriber = Subscriber::find($request->id);
        $subscriber->delete();

        // Redirect
        return redirect()->route('admin.subscriber.index')->with(['message' => 'Berhasil menghapus data.']);
    }
}
