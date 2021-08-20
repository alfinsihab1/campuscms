<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Ajifatur\FaturCMS\Mails\ConfirmationMail;
use Ajifatur\FaturCMS\Mails\VerificationMail;
use Ajifatur\FaturCMS\Mails\WithdrawalMail;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\Rekening;
use Ajifatur\FaturCMS\Models\Withdrawal;

class KomisiController extends Controller
{
    /**
     * Menampilkan data komisi (JSON)
     *
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
		if(Auth::user()->is_admin == 1){
			// Data komisi
			$komisi = Komisi::join('users','komisi.id_user','=','users.id_user')->orderBy('komisi_at','desc')->get();
			
			// Set data komisi
			foreach($komisi as $key=>$data){
				$komisi[$key]->id_sponsor = User::find($data->id_sponsor);
			}

			// Return
			return DataTables::of($komisi)
			->addColumn('checkbox', '<input type="checkbox">')
			->addColumn('komisi_at', function($data){
				if($data->komisi_at != null){
					return '
						<span class="d-none">'.$data->komisi_at.'</span>
						'.date('d/m/Y', strtotime($data->komisi_at)).'
						<br>
						<small><i class="fa fa-clock-o mr-1"></i>'.date('H:i', strtotime($data->komisi_at)).' WIB</small>
					';
				}
				else return '-';
			})
			->addColumn('user_identity', function($data){
				return '
				<a href="'.route('admin.user.detail', ['id' => $data->id_user ]).'">'.$data->nama_user.'</a>
				<br>
				<small><i class="fa fa-envelope mr-1"></i>'.$data->email.'</small>
				<br>
				<small><i class="fa fa-phone mr-1"></i>'.$data->nomor_hp.'</small>
				';
			})
			->addColumn('sponsor', function($data){
				return '
				<a href="'.route('admin.user.detail', ['id' => $data->id_sponsor->id_user ]).'">'.$data->id_sponsor->nama_user.'</a>
				<br>
				<small><i class="fa fa-envelope mr-1"></i>'.$data->id_sponsor->email.'</small>
				<br>
				<small><i class="fa fa-phone mr-1"></i>'.$data->id_sponsor->nomor_hp.'</small>
				';
			})
			->addColumn('komisi', function($data){
				return '
					<strong>Aktivasi Komisi:</strong><br>
                    Rp. '.number_format($data->komisi_aktivasi,0,',',',').'<br><br>
                    <strong>Hasil Komisi:</strong><br>
                    Rp. '.number_format($data->komisi_hasil,0,',',',').'
				';
			})
			->addColumn('komisi_status', function($data){
				if($data->komisi_status == 1)
					return '<span class="d-none">2</span><span class="badge badge-success">Diterima</span>';
				else{
					if($data->komisi_proof != '')
						return '<span class="d-none">1</span><span class="badge badge-warning">Belum Diverifikasi</span>';
					else
						return '<span class="d-none">3</span><span class="badge badge-danger">Belum Membayar</span>';
				}
			})
			->addColumn('options', function($data){
				$html = '';
				$html .= '<div class="btn-group">';
				if($data->komisi_status == 1){
					$html .= '<a href="'.asset('assets/images/komisi/'.$data->komisi_proof).'" class="btn btn-sm btn-info btn-magnify-popup" data-toggle="tooltip" title="Bukti Transfer"><i class="fa fa-image"></i></a>';
				}
				else{
					if($data->komisi_proof != '')
						$html .= '<a href="#" class="btn btn-sm btn-success btn-verify" data-id="'.$data->id_komisi.'" data-proof="'. asset('assets/images/komisi/'.$data->komisi_proof).'" data-toggle="tooltip" title="Verifikasi Pembayaran"><i class="fa fa-check"></i></a>';
					else
						$html .= '<a href="#" class="btn btn-sm btn-success btn-confirm" data-id="'.$data->id_komisi.'" data-toggle="tooltip" title="Konfirmasi Pembayaran"><i class="fa fa-check"></i></a>';
				}
				$html .= '</div>';
				return $html;
			})
			->removeColumn(['password', 'tanggal_lahir', 'jenis_kelamin', 'id_sponsor.password', 'id_sponsor.tanggal_lahir', 'id_sponsor.jenis_kelamin'])
			->rawColumns(['checkbox', 'komisi_at', 'user_identity', 'sponsor', 'komisi', 'komisi_status', 'options'])
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
     * Menampilkan data komisi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

		// Jika role = admin
		if(Auth::user()->is_admin == 1){
			// Data komisi
			$komisi = Komisi::join('users','komisi.id_user','=','users.id_user')->orderBy('komisi_at','desc')->get();
			
			// Set data komisi
			foreach($komisi as $key=>$data){
				$komisi[$key]->id_sponsor = User::find($data->id_sponsor);
			}

			// View
			return view('faturcms::admin.komisi.index', [
				'komisi' => $komisi,
			]);
		}
		// Jika role = member
		elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) abort(403, message('unpaid'));
			
			// Data komisi
			$komisi = Komisi::join('users','komisi.id_user','=','users.id_user')->where('id_sponsor','=',Auth::user()->id_user)->orderBy('register_at','desc')->get();

			// Data rekening
			$rekening = Rekening::join('platform','rekening.id_platform','=','platform.id_platform')->where('id_user',Auth::user()->id_user)->orderBy('platform.tipe_platform','asc')->get();

            // Data current withdrawal
            $current_withdrawal = Withdrawal::where('id_user','=',Auth::user()->id_user)->where('withdrawal_status','=',0)->latest('withdrawal_at')->first();

			// View
			return view('faturcms::member.komisi.index', [
				'komisi' => $komisi,
				'rekening' => $rekening,
                'current_withdrawal' => $current_withdrawal,
			]);
		}
    }

    /**
     * Mengambil komisi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'withdrawal_hidden' => 'required|numeric|min:'.setting('site.min_withdrawal').'|max:'.Auth::user()->saldo,
            'rekening' => 'required',
        ], array_validation_messages());
        
        // Mengecek jika ada error
        if($validator->fails()){
            // Kembali ke halaman sebelumnya dan menampilkan pesan error
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }
        // Jika tidak ada error
        else{
            // Menambah data
            $withdrawal = new Withdrawal;
            $withdrawal->id_user = Auth::user()->id_user;
            $withdrawal->id_rekening = $request->rekening;
            $withdrawal->nominal = $request->withdrawal_hidden;
            $withdrawal->withdrawal_status = 0;
            $withdrawal->withdrawal_success_at = null;
            $withdrawal->withdrawal_proof = '';
            $withdrawal->withdrawal_at = date('Y-m-d H:i:s');
            $withdrawal->inv_withdrawal = '';
            $withdrawal->save();

            // Generate invoice
            $new_withdrawal = Withdrawal::where('withdrawal_at','=',$withdrawal->withdrawal_at)->first();
            $new_withdrawal->inv_withdrawal = generate_invoice($new_withdrawal->id_withdrawal, 'WIT');
            $new_withdrawal->save();
		
			// Send Mail Notification
            $receivers = array_receivers();
			foreach($receivers as $receiver){
				Mail::to($receiver)->send(new WithdrawalMail(Auth::user()->id_user, $new_withdrawal->id_withdrawal));
			}
        }

        // Redirect
        return redirect()->route('member.komisi.index');
    }

    /**
     * Konfirmasi pembayaran aktivasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
		if(Auth::user()->is_admin == 1){
			// Mengupload file
			$file = $request->file('foto');
			$filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
			$file->move('assets/images/komisi', $filename);

			// Mengupdate data komisi
			$komisi = Komisi::find($request->id_komisi);
			$komisi->komisi_proof = $filename;
        	$komisi->komisi_status = 1;
			$komisi->komisi_at = date('Y-m-d H:i:s');
			$komisi->save();

			// Mengupdate data user
			$user = User::find($komisi->id_user);
			$user->status = 1;
			$user->save();

			// Mengupdate data sponsor jika statusnya 1
			$sponsor = User::find($komisi->id_sponsor);
			if($sponsor->status == 1){
				// Menambah saldo
				$sponsor->saldo += $komisi->komisi_hasil;
				$sponsor->save();

				// Mengupdate data komisi
				$komisi->masuk_ke_saldo = 1;
				$komisi->save();
			}
		
			// Send Mail
			Mail::to($user->email)->send(new VerificationMail($user->id_user));

			// Redirect
			return redirect()->route('admin.komisi.index')->with(['message' => 'Berhasil mengonfirmasi member baru.']);
		}
		elseif(Auth::user()->is_admin == 0){
			// Mengupload file
			$file = $request->file('foto');
			$filename = date('Y-m-d-H-i-s').".".$file->getClientOriginalExtension();
			$file->move('assets/images/komisi', $filename);

			// Mengupdate data komisi
			$komisi = Komisi::where('inv_komisi','=',$request->kode_pembayaran)->first();
			$komisi->komisi_proof = $filename;
			$komisi->komisi_at = date('Y-m-d H:i:s');
			$komisi->save();

			// Send Mail Notification
            $receivers = array_receivers();
			foreach($receivers as $receiver){
				Mail::to($receiver)->send(new ConfirmationMail(Auth::user()->id_user, $komisi->id_komisi));
			}

			// Redirect
			return redirect()->route('member.dashboard');
		}
    }

    /**
     * Verifikasi pembayaran aktivasi
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // Mengupdate data komisi
        $komisi = Komisi::find($request->id_komisi);
        $komisi->komisi_status = 1;
        $komisi->save();

        // Mengupdate data user
        $user = User::find($komisi->id_user);
        $user->status = 1;
        $user->save();

        // Mengupdate data sponsor jika statusnya 1
        $sponsor = User::find($komisi->id_sponsor);
        if($sponsor->status == 1){
            // Menambah saldo
            $sponsor->saldo += $komisi->komisi_hasil;
            $sponsor->save();

            // Mengupdate data komisi
            $komisi->masuk_ke_saldo = 1;
            $komisi->save();
        }
		
		// Send Mail
		Mail::to($user->email)->send(new VerificationMail($user->id_user));

        // Redirect
        return redirect()->route('admin.komisi.index')->with(['message' => 'Berhasil memverifikasi komisi.']);
    }
}
