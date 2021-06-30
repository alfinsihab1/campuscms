<?php

namespace Ajifatur\FaturCMS\Http\Controllers\API;

use Ajifatur\FaturCMS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\PelatihanMember;
use Ajifatur\FaturCMS\Models\Visitor;

class ByKelompokController extends Controller
{
    /**
     * Login by kelompok - user - pelatihan
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byKelompokLogin(Request $request)
    {
        if($request->ajax()){
            ini_set('max_execution_time', '300');

            // Data member pelatihan
            $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$request->query('id'))->first();

            if($member){
                // Array data
                $labels = [];
                $dataVisit = [];
                $tanggal_awal = $member->tanggal_pelatihan_from;
                $tanggal_akhir = $member->tanggal_pelatihan_to;
                while(strtotime($tanggal_awal) < strtotime($tanggal_akhir)){
                    // Custom data
                    $count_visit = Visitor::where('id_user','=',$member->id_user)->whereDate('visit_at','=',$tanggal_awal)->count();

                    // Push first
                    array_push($labels, date('d/m/y', strtotime($tanggal_awal)));
                    array_push($dataVisit, $count_visit);

                    // Replace then
                    $tanggal_awal = date("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
                }

                // Datasets
                $datasets = [
                    ['label' => 'Login', 'data' => $dataVisit, 'color' => '#17a2b8'],
                ];

                // Response
                return response()->json([
                    'status' => 200,
                    'message' => 'Success!',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => $datasets
                    ]
                ]);
            }
            else{
                // Response
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Found!',
                    'data' => [],
                ]);
            }
        }
    }

    /**
     * Aktivitas by kelompok - user - pelatihan
     * 
     * @return \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function byKelompokAktivitas(Request $request)
    {
        if($request->ajax()){
            ini_set('max_execution_time', '300');

            // Data member pelatihan
            $member = PelatihanMember::join('pelatihan','pelatihan_member.id_pelatihan','=','pelatihan.id_pelatihan')->join('users','pelatihan_member.id_user','=','users.id_user')->where('pelatihan_member.id_pelatihan','=',$request->query('pelatihan'))->where('pelatihan_member.id_user','=',$request->query('user'))->first();

            if($member){
                // Logs
                $logs = $this->toObject('logs/user-activities/'.$member->id_user.'.log');

                // Array data
                $labels = [];
                $view_ebook = [];
                $view_video = [];

                $tanggal_awal = $member->tanggal_pelatihan_from;
                $tanggal_akhir = $member->tanggal_pelatihan_to;
                while(strtotime($tanggal_awal) < strtotime($tanggal_akhir)){
                    // Custom data
                    $count_view_ebook = 0;
                    $count_view_video = 0;

                    // Aktivitas (versi Log)
                    if($logs != false){
                        if(count($logs)>0){
                            // Loop logs
                            foreach($logs as $log){
                                if(is_int(strpos($log->url, '/file/detail/')) && date('d/m/y', $log->time) == date('d/m/y', strtotime($tanggal_awal))){
                                    // Get last segment
                                    $segments = explode('/', $log->url);
                                    $id_file = end($segments);

                                    // Get file
                                    $file = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->find($id_file);
                                    if($file){
                                        if($file->tipe_kategori == 'ebook') $count_view_ebook++;
                                        elseif($file->tipe_kategori == 'video') $count_view_video++;
                                    }
                                }
                            }
                        }
                    }

                    // Aktivitas (versi Tabel Aktivitas)
                    if(Schema::hasTable('aktivitas')){
                        // Get data aktivitas
                        $aktivitas = DB::table('aktivitas')->where('id_user','=',$member->id_user)->whereDate('aktivitas_at','=',$tanggal_awal)->get();
                        if(count($aktivitas)>0){
                            foreach($aktivitas as $data){
                                $data->aktivitas = json_decode($data->aktivitas, true);
                                foreach($data->aktivitas as $row){
                                    // Path format baru
                                    if(is_int(strpos($row['path'], '/member/file-manager/view/'))){
                                        $id_file = str_replace('/member/file-manager/view/', '', $row['path']);
                                        $file = Files::join('folder_kategori','file.file_kategori','=','folder_kategori.id_fk')->find($id_file);
                                        if($file){
                                            if($file->tipe_kategori == 'ebook') $count_view_ebook++;
                                            elseif($file->tipe_kategori == 'video') $count_view_video++;
                                        }
                                    }
                                    // Path course format lama
                                    elseif(is_int(strpos($row['path'], '/member/e-course/detail/'))) $count_view_video++;
                                    // Path course format lama
                                    elseif(is_int(strpos($row['path'], '/member/materi/e-learning/view/')) || is_int(strpos($row['path'], '/member/materi/e-library/view/')) || is_int(strpos($row['path'], '/member/materi/e-competence/view/'))) $count_view_ebook++;
                                }
                            }
                        }
                    }

                    // Push first
                    array_push($labels, date('d/m/y', strtotime($tanggal_awal)));
                    array_push($view_ebook, $count_view_ebook);
                    array_push($view_video, $count_view_video);

                    // Replace then
                    $tanggal_awal = date("Y-m-d", strtotime("+1 day", strtotime($tanggal_awal)));
                }

                // Datasets
                $datasets = [
                    ['label' => 'Belajar E-Book', 'data' => $view_ebook, 'color' => '#28a745'],
                    ['label' => 'Belajar Video', 'data' => $view_video, 'color' => '#dc3545'],
                ];

                // Response
                return response()->json([
                    'status' => 200,
                    'message' => 'Success!',
                    'data' => [
                        'labels' => $labels,
                        'datasets' => $datasets
                    ]
                ]);
            }
            else{
                // Response
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Found!',
                    'data' => [],
                ]);
            }
        }
    }

    /**
     * Mengkonversi konten file log ke object
     *
     * string $path
     * @return \Illuminate\Http\Response
     */
    public function toObject($path)
    {
        if(File::exists(storage_path($path))){
            $logs = File::get(storage_path($path));
            $logs = substr($logs, 0, -1);
            $logs = "[".$logs."]";
            $logs = json_decode($logs);
            return $logs;
        }
        else return false;
    }
}