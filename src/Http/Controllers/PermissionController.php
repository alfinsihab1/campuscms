<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Permission;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\RolePermission;

class PermissionController extends Controller
{
    /**
     * Menampilkan form tambah permission
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // View
        return view('faturcms::admin.role-permission.create');
    }

    /**
     * Menambah permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'key_permission' => 'required|unique:permission|regex:/^[0-9A-Za-z:]+$/',
            'nama_permission' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'key_permission',
                'nama_permission',
            ]));
        }
        // Jika tidak ada error
        else{
            // Latest data
            $latest = Permission::latest('order_permission')->first();

            // Menambah data permission
            $permission = new Permission;
            $permission->key_permission = $request->key_permission;
            $permission->nama_permission = $request->nama_permission;
            $permission->order_permission = $latest ? $latest->order_permission + 1 : 1;
            $permission->save();

            // Get latest permission
            $get_permission = Permission::where('key_permission','=',$request->key_permission)->first();

            // Menambah data role permission jika ada permission baru
            if($get_permission){
                // Get data role
                $roles = Role::all();

                // Loop data role
                if(count($roles)>0){
                    foreach($roles as $role){
                        $role_permission = new RolePermission;
                        $role_permission->id_permission = $get_permission->id_permission;
                        $role_permission->id_role = $role->id_role;
                        $role_permission->access = 0;
                        $role_permission->save();
                    }
                }
            }
        }

        // Redirect
        return redirect()->route('admin.rolepermission.index')->with(['message' => 'Berhasil menambah data.']);
    }

    /**
     * Menampilkan form edit permission
     *
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Data permission
        $permission = Permission::findOrFail($id);

        // View
        return view('faturcms::admin.role-permission.edit', [
            'permission' => $permission
        ]);
}

    /**
     * Mengupdate permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'key_permission' => [
                'required', 'regex:/^[0-9A-Za-z:]+$/', Rule::unique('permission')->ignore($request->id, 'id_permission')
            ],
            'nama_permission' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput($request->only([
                'key_permission',
                'nama_permission',
            ]));
        }
        // Jika tidak ada error
        else{
            // Mengupdate data permission
            $permission = Permission::find($request->id);
            $permission->key_permission = $request->key_permission;
            $permission->nama_permission = $request->nama_permission;
            $permission->save();
        }

        // Redirect
        return redirect()->route('admin.rolepermission.index')->with(['message' => 'Berhasil mengupdate data.']);
    }

    /**
     * Menghapus permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus data
        $permission = Permission::find($request->id);
        $permission->delete();

        // Redirect
        return redirect()->route('admin.rolepermission.index')->with(['message' => 'Berhasil menghapus data.']);
    }

    /**
     * Mengurutkan permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sorting(Request $request)
    {
        // Mengurutkan permission
        foreach($request->get('ids') as $key=>$id){
            $permission = Permission::find($id);
            if($permission){
                $permission->order_permission = $key + 1;
                $permission->save();
            }
        }
        echo 'Sukses mengupdate urutan permission!';
    }
}
