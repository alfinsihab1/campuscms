<?php

namespace Ajifatur\FaturCMS\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\User;
use Ajifatur\FaturCMS\Models\Withdrawal;

class WithdrawalController extends Controller
{
    /**
     * Menampilkan data withdrawal
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check Access
        has_access(generate_method(__METHOD__), Auth::user()->role);

        // Jika role = admin
        if(Auth::user()->is_admin == 1){
            // Data withdrawal
            $withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->orderBy('withdrawal_status','asc')->orderBy('withdrawal_at','desc')->get();

            // View
            return view('faturcms::admin.withdrawal.index', [
                'withdrawal' => $withdrawal,
            ]);
        }
        elseif(Auth::user()->is_admin == 0){
			// User belum membayar
            if(Auth::user()->status == 0) abort(403, message('unpaid'));
            
			// Data withdrawal
			$withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->join('rekening','withdrawal.id_rekening','=','rekening.id_rekening')->join('platform','rekening.id_platform','=','platform.id_platform')->where('withdrawal.id_user',Auth::user()->id_user)->orderBy('withdrawal_status','asc')->orderBy('withdrawal_at','desc')->get();

            // Data current withdrawal
            $current_withdrawal = Withdrawal::where('withdrawal_status','=',0)->latest('withdrawal_at')->first();

			// View
			return view('faturcms::member.withdrawal.index', [
				'withdrawal' => $withdrawal,
                'current_withdrawal' => $current_withdrawal,
			]);
        }
    }

    /**
     * Mengirim withdrawal
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        // Mengupload file
        $file = $request->file('foto');
        $filename = time().".".$file->getClientOriginalExtension();
        $file->move('assets/images/withdrawal', $filename);

        // Update data
        $withdrawal = Withdrawal::find($request->id_withdrawal);
        $withdrawal->withdrawal_status = 1;
        $withdrawal->withdrawal_success_at = date('Y-m-d H:i:s');
        $withdrawal->withdrawal_proof = $filename;
        $withdrawal->save();
        
        // Update data user
        $user = User::find($withdrawal->id_user);
        $user->saldo -= $withdrawal->nominal;
        $user->save();

        // Redirect
        if(Auth::user()->is_admin == 1){
            return redirect()->route('admin.withdrawal.index')->with(['message' => 'Berhasil mengirim komisi.']);
        }
    }
}
