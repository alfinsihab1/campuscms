<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ajifatur\FaturCMS\Models\Komisi;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Withdrawal;

class FinanceController extends Controller
{
    /**
     * Income
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function income(Request $request)
    {
        if($request->ajax()){
            // Komisi
            $komisi =  Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->sum('komisi_aktivasi');

            // Transaksi pelatihan
            $transaksi_pelatihan = PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->sum('fee');

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Membership', 'Pelatihan'],
                    'colors' => ['#4a8af5', '#fb9d35'],
                    'data' => [$komisi, $transaksi_pelatihan],
                    'total' => $komisi + $transaksi_pelatihan
                ]
            ]);
        }
    }

    /**
     * Outcome
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function outcome(Request $request)
    {
        if($request->ajax()){
            // Withdrawal
            $withdrawal = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->sum('nominal');

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'labels' => ['Withdrawal'],
                    'colors' => ['#dc3545'],
                    'data' => [$withdrawal],
                    'total' => $withdrawal
                ]
            ]);
        }
    }

    /**
     * Revenue
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function revenue(Request $request, $month, $year)
    {
        if($request->ajax()){
            // Variables
            $labels = array();
            $dataIncome = array();
            $dataOutcome = array();
            $dataSaldo = array();
            $totalIncome = 0;
            $totalOutcome = 0;
            $totalSaldo = 0;

            // Jika menampilkan revenue per tahun
            if($year == 0){
                // Loop
                for($y=2020; $y<=date('Y'); $y++){
                    // Get income
                    $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereYear('komisi_at','=',$y)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereYear('pm_at','=',$y)->sum('fee');

                    // Get outcome
                    $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereYear('withdrawal_at','=',$y)->sum('nominal');

                    // Get saldo
                    $saldo = $income - $outcome;

                    // Increment
                    $totalIncome += $income;
                    $totalOutcome += $outcome;
                    $totalSaldo += $saldo;

                    // Array push
                    array_push($labels, $y);
                    array_push($dataIncome, $income);
                    array_push($dataOutcome, $outcome);
                    array_push($dataSaldo, $saldo);
                }
            }
            // Jika menampilkan revenue per bulan
            elseif($month == 0 && $year != 0){
                // Loop
                for($m=1; $m<=12; $m++){
                    // Array month
                    $arrayMonth = substr(array_indo_month()[$m-1],0,3);

                    // Get income
                    $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereMonth('komisi_at','=',$m)->whereYear('komisi_at','=',$year)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereMonth('pm_at','=',$m)->whereYear('pm_at','=',$year)->sum('fee');

                    // Get outcome
                    $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereMonth('withdrawal_at','=',$m)->whereYear('withdrawal_at','=',$year)->sum('nominal');

                    // Get saldo
                    $saldo = $income - $outcome;

                    // Increment
                    $totalIncome += $income;
                    $totalOutcome += $outcome;
                    $totalSaldo += $saldo;

                    // Array push
                    array_push($labels, $arrayMonth);
                    array_push($dataIncome, $income);
                    array_push($dataOutcome, $outcome);
                    array_push($dataSaldo, $saldo);
                }
            }
            // Jika menampilkan revenue per hari
            elseif($month != 0 && $year != 0){
                // Array tanggal
                $arrayTanggal = [31, date('Y') % 4 == 0 ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

                // Loop
                for($d=1; $d<=$arrayTanggal[$month-1]; $d++){
                    // Get income
                    $income = Komisi::join('users','komisi.id_user','=','users.id_user')->where('komisi_status','=',1)->whereDay('komisi_at','=',$d)->whereMonth('komisi_at','=',$month)->whereYear('komisi_at','=',$year)->sum('komisi_aktivasi') + PelatihanMember::join('users','pelatihan_member.id_user','=','users.id_user')->join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->where('fee_status','=',1)->whereDay('pm_at','=',$d)->whereMonth('pm_at','=',$month)->whereYear('pm_at','=',$year)->sum('fee');

                    // Get outcome
                    $outcome = Withdrawal::join('users','withdrawal.id_user','=','users.id_user')->where('withdrawal_status','=',1)->whereDay('withdrawal_at','=',$d)->whereMonth('withdrawal_at','=',$month)->whereYear('withdrawal_at','=',$year)->sum('nominal');

                    // Get saldo
                    $saldo = $income - $outcome;

                    // Increment
                    $totalIncome += $income;
                    $totalOutcome += $outcome;
                    $totalSaldo += $saldo;

                    // Array push
                    array_push($labels, $d);
                    array_push($dataIncome, $income);
                    array_push($dataOutcome, $outcome);
                    array_push($dataSaldo, $saldo);
                }
            }

            // Datasets
            $datasets = [
                ['label' => 'Income', 'data' => $dataIncome, 'color' => '#17a2b8'],
                ['label' => 'Outcome', 'data' => $dataOutcome, 'color' => '#dc3545'],
                ['label' => 'Saldo', 'data' => $dataSaldo, 'color' => '#28b779'],
            ];

            // Response
            return response()->json([
                'status' => 200,
                'message' => 'Success!',
                'data' => [
                    'data' => [
                        'labels' => $labels,
                        'datasets' => $datasets
                    ],
                    'total' => [
                        'income' => $totalIncome,
                        'outcome' => $totalOutcome,
                        'saldo' => $totalSaldo,
                    ]
                ]
            ]);
        }
    }
}