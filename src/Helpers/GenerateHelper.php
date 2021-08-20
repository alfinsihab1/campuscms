<?php

use Ajifatur\FaturCMS\Models\Komentar;
use Ajifatur\FaturCMS\Models\Pelatihan;
use Ajifatur\FaturCMS\Models\Tag;

// Generate materi pelatihan
if(!function_exists('generate_materi_pelatihan')){
    function generate_materi_pelatihan($kode_unit, $judul_unit, $durasi){
        $array = [];
        if(empty(array_filter($kode_unit)) || empty(array_filter($judul_unit)) || empty(array_filter($durasi)))
            return json_encode($array);
        else{
            if(count($kode_unit)>0){
                foreach($kode_unit as $key=>$kode){
                    array_push($array, ['kode' => $kode, 'judul' => $judul_unit[$key], 'durasi' => $durasi[$key]]);
                }
            }
            return json_encode($array);
        }
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
        return $num.'/'.str_replace(' ', '-', kategori_pelatihan($kategori)).'/'.setting('site.sertifikat.kode').'/'.date('Y', strtotime(generate_date_range('explode', $tanggal_pelatihan)['from']));
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