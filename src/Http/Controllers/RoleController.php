<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Role;

class RoleController extends Controller
{
    /**
     * Menampilkan data role
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data role
        $role = Role::orderBy('is_admin','desc')->get();
		
        // View
        return view('faturcms::admin.role.index', [
            'role' => $role,
        ]);
    }

    /**
     * Menampilkan form edit role
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data role
        $role = Role::findOrFail($id);

        // View
        return view('faturcms::admin.role.edit', [
            'role' => $role
        ]);
    }

    /**
     * Mengupdate role
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'nama_role',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data
            $role = Role::find($request->id);
            $role->nama_role = $request->nama_role;
            $role->save();
        }

        // Redirect
        return redirect()->route('admin.role.index')->with(['message' => 'Berhasil mangupdate data.']);
    }
}
