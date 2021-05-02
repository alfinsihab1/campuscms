<?php

use Ajifatur\FaturCMS\Models\Komentar;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\Tag;

// Generate method
if(!function_exists('generate_method')){
    function generate_method($method){
        $explode = explode('\\', $method);
        return end($explode);
    }
}

// Generate umur / usia
if(!function_exists('generate_age')){
    function generate_age($date){
        $birthdate = new DateTime($date);
        $today = new DateTime('today');
        $old = $today->diff($birthdate)->old;
        return $old;
    }
}

// Generate tanggal
if(!function_exists('generate_date')){
    function generate_date($date){
        $explode = explode(" ", $date);
        $explode = explode("-", $explode[0]);
        return count($explode) == 3 ? $explode[2]." ".array_indo_month()[$explode[1]-1]." ".$explode[0] : '';
    }
}

// Generate tanggal dan waktu
if(!function_exists('generate_date_time')){
    function generate_date_time($datetime){
        $explode = explode(" ", $datetime);
        if(count($explode) == 2){
            $date = explode("-", $explode[0]);
            return count($date) == 3 ? $date[2]." ".array_indo_month()[$date[1]-1]." ".$date[0].", ".substr($explode[1],0,5) : '';
        }
        else{
            return '';
        }
    }
}

// Generate format tanggal
if(!function_exists('generate_date_format')){
    function generate_date_format($date, $format){
        if($format == 'd/m/y'){
            $explode = explode("-", $date);
            return count($explode) == 3 ? $explode[2].'/'.$explode[1].'/'.$explode[0] : '';
        }
        elseif($format == 'y-m-d'){
            $explode = explode("/", $date);
            return count($explode) == 3 ? $explode[2].'-'.$explode[1].'-'.$explode[0] : '';
        }
        else
            return '';
    }
}

// Generate tanggal (range)
if(!function_exists('generate_date_range')){
    function generate_date_range($type, $date){
		// Join date range
		if($type == 'join'){
			$explode_dash = explode(" - ", $date);
			$explode_from = explode(" ", $explode_dash[0]);
			$explode_date_from = explode("-", $explode_from[0]);
			$from = $explode_date_from[2].'/'.$explode_date_from[1].'/'.$explode_date_from[0].' '.substr($explode_from[1],0,5);
			$explode_to = explode(" ", $explode_dash[1]);
			$explode_date_to = explode("-", $explode_to[0]);
			$to = $explode_date_to[2].'/'.$explode_date_to[1].'/'.$explode_date_to[0].' '.substr($explode_to[1],0,5);
			return array('from' => $from, 'to' => $to);
		}
		elseif($type == 'explode'){
			$explode_dash = explode(" - ", $date);
			$explode_from = explode(" ", $explode_dash[0]);
			$explode_date_from = explode("/", $explode_from[0]);
			$from = $explode_date_from[2].'-'.$explode_date_from[1].'-'.$explode_date_from[0].' '.$explode_from[1].':00';
			$explode_to = explode(" ", $explode_dash[1]);
			$explode_date_to = explode("/", $explode_to[0]);
			$to = $explode_date_to[2].'-'.$explode_date_to[1].'-'.$explode_date_to[0].' '.$explode_to[1].':00';
			return array('from' => $from, 'to' => $to);
		}
    }
}

// Generate time
if(!function_exists('generate_time')){
    function generate_time($time){
		if($time < 60)
			return $time." detik";
		elseif($time >= 60 && $time < 3600)
			return floor($time / 60)." menit ".fmod($time, 60)." detik";
		else
			return floor($time / 3600)." jam ".(floor($time / 60) - (floor($time / 3600) * 60))." menit ".fmod($time, 60)." detik";
    }
}

// Generate file dari folder
if(!function_exists('generate_file')){
    function generate_file($path, $exception_array = []){
		$dir = $path;
		$array = [];
		if(is_dir($dir)){
			if($handle = opendir($dir)){
    			// Loop file
           		while(($file = readdir($handle)) !== false){
                    // Pilih jika nama file bukan ".", "..", file bukan folder, serta file tidak dikecualikan
                    if($file != '.' && $file != '..' && !is_dir($dir.'/'.$file) && !in_array($file, $exception_array)){
                        array_push($array, $file);
                    }
            	}
            	closedir($handle);
        	}
    	}
		return $array;
    }
}

// Generate warna kebalikan
if(!function_exists('generate_inversion_color')){
    function generate_inversion_color($color){
        $hsl = rgb_to_hsl(hex_to_rgb($color));
        if($hsl->lightness > 200) return '#000000';
        else return '#ffffff';
    }
}

// Generate image name
if(!function_exists('generate_image_name')){
    function generate_image_name($path, $image_base64, $image_url){
        if($image_base64 != '')
            $image_name = upload_file($image_base64, $path);
        elseif($image_url != '')
            $image_name = str_replace(url()->to($path).'/', '', $image_url);
        else
            $image_name = '';

        return $image_name;
    }
}

// Generate invoice
if(!function_exists('generate_invoice')){
    function generate_invoice($id, $prefix = ''){    
        // Max 999.999
        if($id > 0 && $id < 10)
            $invoice = $prefix."00000".($id);
        elseif($id >= 10 && $id < 100)
            $invoice = $prefix."0000".($id);
        elseif($id >= 100 && $id < 1000)
            $invoice = $prefix."000".($id);
        elseif($id >= 1000 && $id < 10000)
            $invoice = $prefix."00".($id);
        elseif($id >= 10000 && $id < 100000)
            $invoice = $prefix."0".($id);
        elseif($id >= 100000 && $id < 1000000)
            $invoice = $prefix.($id);
        
        return $invoice;
    }
}

// Generate permalink
if(!function_exists('generate_permalink')){
    function generate_permalink($string){
        $result = strtolower($string);
        $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
        $result = preg_replace("/\s+/", " ",$result);
        $result = str_replace(" ", "-", $result);
        return $result;
    }
}

// Generate ukuran dari satuan byte
if(!function_exists('generate_size')){
    function generate_size($bytes){ 
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;

        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return round($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return round($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return round($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return round($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}

// Generate materi pelatihan
if(!function_exists('generate_materi_pelatihan')){
    function generate_materi_pelatihan($kode_unit, $judul_unit, $durasi){
        $array = [];
        if(count($kode_unit)>0){
            foreach($kode_unit as $key=>$kode){
                array_push($array, ['kode' => $kode, 'judul' => $judul_unit[$key], 'durasi' => $durasi[$key]]);
            }
        }
        return json_encode($array);
    }
}

// Generate nomor pelatihan
if(!function_exists('generate_nomor_pelatihan')){
    function generate_nomor_pelatihan($kategori, $tanggal_pelatihan){
        // Cek data
        $data = Pelatihan::where('kategori_pelatihan','=',$kategori)->whereYear('tanggal_pelatihan_from','=',date('Y', strtotime(generate_date_range('explode', $tanggal_pelatihan)['from'])))->latest('nomor_pelatihan')->first();

        // Generate Nomor
        if($data == null) $num = 1;
        else{
            $explode = explode('/', $data->nomor_pelatihan);
            if(substr($explode[0],0,1) == 0)
                $num = (int)substr($explode[0],1,1) + 1;
            else
                $num = (int)$explode[0] + 1;
        }
        if($num < 10) $num = '0'.$num;

        // Return
        return $num.'/'.kategori_pelatihan($kategori).'/'.setting('site.sertifikat.kode').'/'.date('Y', strtotime(generate_date_range('explode', $tanggal_pelatihan)['from']));
    }
}

// Generate nomor sertifikat
if(!function_exists('generate_nomor_sertifikat')){
    function generate_nomor_sertifikat($count, $pelatihan){
        $num = $count + 1;
        if($num < 10) $num = '0'.$num;
        $explode = explode('/', $pelatihan->nomor_pelatihan);
        return $num.'.'.$explode[2].'.'.$explode[0].'.'.$explode[1].'.'.$explode[3];
    }
}

// Generate tag by name
if(!function_exists('generate_tag_by_name')){
    function generate_tag_by_name($tags){
        // Define empty array
        $array = [];

        // Explode and filter array
        $array_tag = explode(",", $tags);
        $array_tag = array_filter($array_tag);

        // Convert tag to ID
        if(count($array_tag)>0){
            foreach($array_tag as $key=>$tag){
                // Get data tag
                $data = Tag::where('tag','=',$tag)->first();
                // If not exist, add new tag
                if(!$data){
                    $new = new Tag;
                    $new->tag = $tag;
                    $new->slug = slugify($tag, 'tag', 'slug', 'id_tag', null);
                    $new->save();

                    // Push latest data
                    $newest = Tag::latest('id_tag')->first();
                    array_push($array, $newest->id_tag);
                }
                else{
                    array_push($array, $data->id_tag);
                }
            }
        }

        // Return
        return implode(",", $array);
    }
}

// Generate tag by id
if(!function_exists('generate_tag_by_id')){
    function generate_tag_by_id($tags){
        if($tags != ''){
            // Explode and filter array
            $array_tag = explode(",", $tags);
            $array_tag = array_filter($array_tag);

            if(count($array_tag)>0){
                foreach($array_tag as $key=>$tag){
                    // Custom data
                    $data = Tag::find($tag);
                    $array_tag[$key] = $data ? $data->tag : '';
                }
                return implode(",", $array_tag);
            }
        }
        else{
            return '';
        }
    }
}

// Generate anak komentar
if(!function_exists('generate_comment_children')){
    function generate_comment_children($post, $parent){
        $komentar = Komentar::join('users','komentar.id_user','=','users.id_user')->where('id_artikel','=',$post)->where('komentar_parent','=',$parent)->orderBy('komentar_at','asc')->get();
        return $komentar;
    }
}