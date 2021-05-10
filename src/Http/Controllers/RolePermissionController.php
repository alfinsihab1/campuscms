<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Ajifatur\FaturCMS\Models\Permission;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\RolePermission;

class RolePermissionController extends Controller
{
    /**
     * Menampilkan data role permission
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        if(Auth::user()->role == role('it')){
            // Get data permission
            $permissions = Permission::whereNotIn('key_permission',config('faturcms.allowed_access'))->orderBy('order_permission','asc')->get();

            // Get data role
            $roles = Role::all();
            
            // View
            return view('faturcms::admin.role-permission.index', [
                'permissions' => $permissions,
                'roles' => $roles,
            ]);
        }
        else{
            abort(403);
        }
    }

    /**
     * Mengupdate role permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Mengupdate / menambah role permission
        $role_permission = RolePermission::updateOrCreate(['id_permission' => $request->permission, 'id_role' => $request->role], ['access' => $request->access]);
        
        echo 'Berhasil mengupdate hak akses!';
    }
}
