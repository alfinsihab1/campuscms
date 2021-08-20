<?php

use Ajifatur\FaturCMS\Models\Files;
use Ajifatur\FaturCMS\Models\Folder;
use Ajifatur\FaturCMS\Models\FolderKategori;

// Generate file name
if(!function_exists('generate_file_name')){
    function generate_file_name($text, $table, $field, $categoryField, $categoryValue, $parentField, $parentValue, $primaryKey, $id = null){
        $name = $text;
        $i = 1;
        while(count_existing_file($table, $field, $name, $categoryField, $categoryValue, $parentField, $parentValue, $primaryKey, $id) > 0){
            $name = rename_file($text, $i);
            $i++;
        }
        return $name;
    }
}

// Menghitung jumlah file / folder duplikat
if(!function_exists('count_existing_file')){
    function count_existing_file($table, $field, $keyword, $categoryField, $categoryValue, $parentField, $parentValue, $primaryKey, $id = null){
        if($id == null) $data = DB::table($table)->where($field,'=',$keyword)->where($categoryField,'=',$categoryValue)->where($parentField,'=',$parentValue)->get();
        else $data = DB::table($table)->where($field,'=',$keyword)->where($categoryField,'=',$categoryValue)->where($parentField,'=',$parentValue)->where($primaryKey,'!=',$id)->get();
        return count($data);
    }
}


// Mengganti nama file jika ada yang sama
if(!function_exists('rename_file')){
    function rename_file($file, $count = 0){
        return $file." (".($count+1).")";
    }
}

// Array folder kategori
if(!function_exists('array_kategori_folder')){
    function array_kategori_folder(){
        $data = FolderKategori::where('status_kategori','=',1)->orderBy('order_kategori','asc')->get();
        return $data;
    }
}

// Status folder kategori
if(!function_exists('status_kategori_folder')){
    function status_kategori_folder($category){
        $data = FolderKategori::where('slug_kategori','=',$category)->first();
        if($data) return $data->status_kategori == 1 ? true : false;
        else return false;
    }
}

// File Manager breadcrumb
if(!function_exists('file_breadcrumb')){
    function file_breadcrumb($directory){
    	$breadcrumb = [$directory];
		$d = $directory;
		while($d->folder_parent != 0){
			$d = Folder::find($d->folder_parent);
			array_push($breadcrumb, $d);
		}
		return array_reverse($breadcrumb);
    }
}

// Menambah angka nol (max: 999)
if(!function_exists('add_zero')){
    function add_zero($number){
        $length = strlen($number);
        if($length == 1) return '00'.$number;
        elseif($length == 2) return '0'.$number;
        else return $number;
    }
}

// Menghapus angka nol (max: 999)
if(!function_exists('remove_zero')){
    function remove_zero($number){
		if(substr($number,0,2) == '00') return substr($number,2,1);
		elseif(substr($number,0,1) == '0') return substr($number,1,2);
		else return $number;
    }
}

// Get tipe file
if(!function_exists('tipe_file')){
    function tipe_file($id){
        $data = FolderKategori::find($id);
        return $data ? $data->tipe_kategori : '';
    }
}

// Menghitung jumlah file dalam folder
if(!function_exists('count_files')){
    function count_files($id_folder, $kategori){
        return Files::where('id_folder','=',$id_folder)->where('file_kategori','=',$kategori)->count();
    }
}

// Menghitung jumlah folder dalam folder
if(!function_exists('count_folders')){
    function count_folders($id_folder, $kategori){
        return Folder::where('folder_parent','=',$id_folder)->where('folder_kategori','=',$kategori)->count();
    }
}