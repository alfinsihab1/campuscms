<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Ajifatur\FaturCMS\Exports\UserExport;
use App\User;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\ProfilePhoto;
use Ajifatur\FaturCMS\Models\Rekening;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\Withdrawal;

class UserController extends Controller
{
    /**
     * Menampilkan data user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        if($request->query('filter') == null){
            $users = User::join('role','users.role','=','role.id_role')->orderBy('register_at','desc')->get();
        }
        else{
            if($request->query('filter') == 'all')
                $users = User::join('role','users.role','=','role.id_role')->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'admin')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',1)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'member')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',1)->orderBy('register_at','desc')->get();
            elseif($request->query('filter') == 'belum-aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',0)->orderBy('register_at','desc')->get();
            else
                return redirect()->route('admin.user.index');

        }

        // View
        return view('faturcms::admin.user.index', [
            'users' => $users,
            'filter' => $request->query('filter')
        ]);
    }

    /**
     * Menambah data user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data role
        $role = Role::orderBy('is_admin','desc')->get();

        // View
        return view('faturcms::admin.user.create', [
            'role' => $role,
        ]);
    }

    /**
     * Menyimpan data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'username' => 'required|string|min:6|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'status' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Get data role
            $role = Role::find($request->role);

            // Menyimpan data
            $user = new User;
            $user->nama_user = $request->nama_user;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->tanggal_lahir = generate_date_format($request->tanggal_lahir, 'y-m-d');
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->reference = '';
            $user->foto = '';
            $user->role = $request->role;
            $user->is_admin = $role->is_admin;
            $user->status = $request->status;
            $user->saldo = 0;
            $user->email_verified = 1;
            $user->last_visit = null;
            $user->register_at = date('Y-m-d H:i:s');
            $user->save();
        }

        // Redirect
        return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menambah data.']);
    }
    
    /**
     * Menampilkan detail user
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->findOrFail($id);

        // Sponsor
        $sponsor = User::where('username','=',$user->reference)->first();

        // View
        return view('faturcms::admin.user.detail', [
            'user' => $user,
            'sponsor' => $sponsor,
            'id_direct' => $id,
        ]);
    }

    /**
     * Mengedit data user
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::findOrFail($id);

        // Get data role
        $role = Role::orderBy('is_admin','desc')->get();

        // View
        return view('faturcms::admin.user.edit', [
            'role' => $role,
            'user' => $user,
        ]);
    }

    /**
     * Mengupdate data user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'username' => $request->username != '' ? ['required', 'string', 'min:6', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')] : '',
            'email' => [
                'required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id, 'id_user')
            ],
            'password' => $request->password != '' ? 'required|string|min:6' : '',
            'role' => 'required',
            'status' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Get data role
            $role = Role::find($request->role);

            // Menyimpan data
            $user = User::find($request->id);
            $user->nama_user = $request->nama_user;
            $user->tanggal_lahir = generate_date_format($request->tanggal_lahir, 'y-m-d');
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->email = $request->email;
            $user->username = $request->username != '' ? $request->username : $user->username;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->role = $request->role;
            $user->is_admin = $role->is_admin;
            $user->status = $request->status;
            $user->save();
        }

        // Redirect
        return redirect()->route('admin.user.index')->with(['message' => 'Berhasil mengupdate data.']);
    }
    
    /**
     * Menghapus user
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Menghapus user
        $user = User::find($request->id);
        $user->delete();
		
		// Menghapus rekening
		$rekening = Rekening::where('id_user','=',$request->id)->first();
		if($rekening != null) $rekening->delete();
		
		// Menghapus komisi
		$komisi = Komisi::where('id_user','=',$request->id)->first();
		if($komisi != null) $komisi->delete();
		
		// Menghapus withdrawal
		$withdrawal = Withdrawal::where('id_user','=',$request->id)->first();
		if($withdrawal != null) $withdrawal->delete();

        // Redirect
        return redirect()->route('admin.user.index')->with(['message' => 'Berhasil menghapus data.']);
    }
    
    /**
     * Menampilkan data refer
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function refer($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->findOrFail($id);

        // Refer
        $refer = User::where('reference','=',$user->username)->orderBy('status','desc')->get();

        // View
        return view('faturcms::admin.user.refer', [
            'user' => $user,
            'refer' => $refer,
        ]);
    }
    
    /**
     * Menampilkan profil sendiri
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->findOrFail(Auth::user()->id_user);

        // Sponsor
        $sponsor = User::where('username','=',$user->reference)->first();

        // View
        if(Auth::user()->is_admin == 1){
            return view('faturcms::admin.user.profile', [
                'user' => $user,
                'sponsor' => $sponsor,
                'id_direct' => Auth::user()->id_user,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
            return view('faturcms::member.user.profile', [
                'user' => $user,
                'sponsor' => $sponsor,
                'id_direct' => Auth::user()->id_user,
            ]);
        }
    }

    /**
     * Mengedit profil
     * 
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::findOrFail(Auth::user()->id_user);

        // View
        if(Auth::user()->is_admin == 1){
            return view('faturcms::admin.user.edit-profile', [
                'user' => $user,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
            return view('faturcms::member.user.edit-profile', [
                'user' => $user,
            ]);
        }
    }

    /**
     * Mengupdate profil
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|max:255',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required',
            'password' => $request->password != '' ? 'required|string|min:6' : '',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menyimpan data
            $user = User::find($request->id);
            $user->nama_user = $request->nama_user;
            $user->tanggal_lahir = generate_date_format($request->tanggal_lahir, 'y-m-d');
            $user->jenis_kelamin = $request->jenis_kelamin;
            $user->nomor_hp = $request->nomor_hp;
            $user->password = $request->password != '' ? bcrypt($request->password) : $user->password;
            $user->save();
        }

        // Redirect
        if(Auth::user()->is_admin == 1)
            return redirect()->route('admin.profile.edit')->with(['message' => 'Berhasil mengupdate profil.']);
        elseif(Auth::user()->is_admin == 0)
            return redirect()->route('member.profile.edit')->with(['message' => 'Berhasil mengupdate profil.']);
    }

    /**
     * Mengupdate foto profil
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        // Update foto profil
        $image_name = generate_image_name("assets/images/user/", $request->gambar_direct, $request->gambar_direct_url);

        // Update data
        $user = $request->id != null && $request->id != '' ? User::find($request->id) : User::find(Auth::user()->id_user);
        $user->foto = $image_name;
        $user->save();
        
        // Tambah data foto profil
        $photo = new ProfilePhoto;
        $photo->id_user = $user->id_user;
        $photo->photo_name = $image_name;
        $photo->uploaded_at = date('Y-m-d H:i:s');
        $photo->save();

        // Redirect
        if(Auth::user()->is_admin == 1){
            if($user->id_user == Auth::user()->id_user)
                return redirect()->route('admin.profile')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
            else
                return redirect()->route('admin.user.detail', ['id' => $user->id_user])->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
        elseif(Auth::user()->is_admin == 0){
            return redirect()->route('member.profile')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
    }
    
    /**
     * Export ke Excel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        if($request->query('filter') == null){
            $users = User::join('role','users.role','=','role.id_role')->get();
        }
        else{
            if($request->query('filter') == 'all')
                $users = User::join('role','users.role','=','role.id_role')->get();
            elseif($request->query('filter') == 'admin')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',1)->get();
            elseif($request->query('filter') == 'member')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->get();
            elseif($request->query('filter') == 'aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',1)->get();
            elseif($request->query('filter') == 'belum-aktif')
                $users = User::join('role','users.role','=','role.id_role')->where('role.is_admin','=',0)->where('status','=',0)->get();
            else
                $users = User::join('role','users.role','=','role.id_role')->get();

        }

        return Excel::download(new UserExport($users), 'Data User.xlsx');
    }
      
    /**
     * Menampilkan file gambar
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function showImages(Request $request)
    {
        // Get foto
        $photo = ProfilePhoto::where('id_user','=',$request->id)->get()->pluck('photo_name');

        echo json_encode($photo);
    }
}