<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Ajifatur\FaturCMS\Exports\UserExport;
use App\Models\User;
use Ajifatur\FaturCMS\Models\KategoriUser;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\ProfilePhoto;
use Ajifatur\FaturCMS\Models\Rekening;
use Ajifatur\FaturCMS\Models\Role;
use Ajifatur\FaturCMS\Models\Withdrawal;

class UserController extends Controller
{
    /**
     * Menampilkan data user (JSON)
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
		if($request->ajax()){
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
			}

			// Return
			return DataTables::of($users)
			->addColumn('checkbox', '<input type="checkbox">')
			->addColumn('user_identity', function($user){
				$route = $user->id_user == Auth::user()->id_user ? route('admin.profile') : route('admin.user.detail', ['id' => $user->id_user]);
				return '
				<a href="'.$route.'">'.$user->nama_user.'</a>
				<br>
				<small><i class="fa fa-envelope mr-1"></i>'.$user->email.'</small>
				<br>
				<small><i class="fa fa-phone mr-1"></i>'.$user->nomor_hp.'</small>
				';
			})
			->addColumn('saldo', function($user){
				return $user->is_admin == 0 ? number_format($user->saldo,0,',',',') : '-';
			})
			->addColumn('refer', function($user){
				if($user->is_admin == 0){
					return '<a href="'.route('admin.user.refer', ['id' => $user->id_user]).'" data-toggle="tooltip" title="Lihat Data Refer">'.number_format(count_refer($user->username),0,',',',').'</a>';
				}
				else return '';
			})
			->addColumn('status', function($user){
				if($user->status == 1)
					return '<span class="badge badge-success">Aktif</span>';
				elseif($user->status == 0 && $user->email_verified == 1)
					return '<span class="badge badge-warning">Belum Aktif</span>';
				elseif($user->status == 0 && $user->email_verified == 0)
					return '<span class="badge badge-danger">Tidak Aktif</span>';
			})
			->addColumn('register_at', function($user){
				return '
					<span class="d-none">'.$user->register_at.'</span>
					'.date('d/m/Y', strtotime($user->register_at)).'
					<br>
					<small><i class="fa fa-clock-o mr-1"></i>'.date('H:i', strtotime($user->register_at)).' WIB</small>
				';
			})
			->addColumn('options', function($user){
				$btn_delete_class = $user->id_user > 6 ? 'btn-delete' : '';
				$btn_delete_style = $user->id_user > 6 ? '' : 'cursor: not-allowed';
				$btn_delete_title = $user->id_user <= 6 ? $user->id_user == Auth::user()->id_user ? 'Tidak dapat menghapus akun sendiri' : 'Akun ini tidak boleh dihapus' : 'Hapus';
				$html = '';
				$html .= '<div class="btn-group">';
				$html .= '<a href="'.route('admin.user.detail', ['id' => $user->id_user]).'" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fa fa-eye"></i></a>';
				$html .= '<a href="'.route('admin.user.edit', ['id' => $user->id_user]).'" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
				$html .= '<a href="#" class="btn btn-sm btn-danger '.$btn_delete_class.'" data-id="'.$user->id_user.'" style="'.$btn_delete_style.'" data-toggle="tooltip" title="'.$btn_delete_title.'"><i class="fa fa-trash"></i></a>';
				$html .= '</div>';
				return $html;
			})
			->removeColumn(['password', 'tanggal_lahir', 'jenis_kelamin'])
			->rawColumns(['checkbox', 'user_identity', 'saldo', 'refer', 'status', 'register_at', 'options'])
			->make(true);
		}
		else{
			return response()->json([
				'status' => 403,
				'message' => 'Forbidden!'
			]);
		}
    }

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

        // Get data kategori user
        $kategori = KategoriUser::orderBy('id_ku','desc')->get();

        // View
        return view('faturcms::admin.user.create', [
            'role' => $role,
            'kategori' => $kategori,
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
            'user_kategori' => 'required',
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
            $user->user_kategori = $request->user_kategori;
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
        $user = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->findOrFail($id);

        // Sponsor
        $sponsor = User::where('username','=',$user->reference)->first();

        // Pelatihan trainer
        $pelatihan_trainer = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('trainer','=',$id)->groupBy('pelatihan_member.id_pelatihan')->orderBy('tanggal_pelatihan_from','desc')->get();

        // Pelatihan member
        $pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan.trainer','=','users.id_user')->where('pelatihan_member.id_user','=',$id)->orderBy('tanggal_pelatihan_from','desc')->get();

        // View
        return view('faturcms::admin.user.detail', [
            'user' => $user,
            'sponsor' => $sponsor,
            'pelatihan' => $pelatihan,
            'pelatihan_trainer' => $pelatihan_trainer,
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

        // Get data kategori user
        $kategori = KategoriUser::orderBy('id_ku','desc')->get();

        // View
        return view('faturcms::admin.user.edit', [
            'role' => $role,
            'kategori' => $kategori,
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
            'user_kategori' => 'required',
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
            $user->user_kategori = $request->user_kategori;
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
     * Menampilkan detail trainer
     * 
     * int $id
     * @return \Illuminate\Http\Response
     */
    public function trainer($id)
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Get data user
        $user = User::join('role','users.role','=','role.id_role')->where('role','=',role('trainer'))->findOrFail($id);

        // Sponsor
        $sponsor = User::where('username','=',$user->reference)->first();

        // Pelatihan trainer
        $pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('trainer','=',$id)->groupBy('pelatihan_member.id_pelatihan')->orderBy('tanggal_pelatihan_from','desc')->get();

        // View
        return view('faturcms::member.user.trainer', [
            'user' => $user,
            'sponsor' => $sponsor,
            'pelatihan' => $pelatihan,
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
        $user = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->findOrFail(Auth::user()->id_user);

        // Sponsor
        $sponsor = User::where('username','=',$user->reference)->first();

        // Pelatihan member
        $pelatihan = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('id_user','=',Auth::user()->id_user)->orderBy('tanggal_pelatihan_from','desc')->get();

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
                'pelatihan' => $pelatihan,
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
        if($request->gambar_direct_url == null || $request->gambar_direct_url == ''){
            $photo = new ProfilePhoto;
            $photo->id_user = $user->id_user;
            $photo->photo_name = $image_name;
            $photo->uploaded_at = date('Y-m-d H:i:s');
            $photo->save();
        }

        // Redirect
        if(Auth::user()->is_admin == 1){
            // Redirect berhasil mengupdate foto profil sendiri
            if($user->id_user == Auth::user()->id_user)
                return redirect()->route('admin.profile')->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
            // Redirect berhasil mengupdate foto profil user lain
            else
                return redirect()->route('admin.user.detail', ['id' => $user->id_user])->with(['updatePhotoMessage' => 'Berhasil mengganti foto profil.']);
        }
        elseif(Auth::user()->is_admin == 0){
            // Redirect berhasil mengupdate foto profil sendiri
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
            $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->get();
        }
        else{
            if($request->query('filter') == 'all')
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->get();
            elseif($request->query('filter') == 'admin')
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->where('role.is_admin','=',1)->get();
            elseif($request->query('filter') == 'member')
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->where('role.is_admin','=',0)->get();
            elseif($request->query('filter') == 'aktif')
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->where('role.is_admin','=',0)->where('status','=',1)->get();
            elseif($request->query('filter') == 'belum-aktif')
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->where('role.is_admin','=',0)->where('status','=',0)->get();
            else
                $users = User::join('role','users.role','=','role.id_role')->join('kategori_user','users.user_kategori','=','kategori_user.id_ku')->get();
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