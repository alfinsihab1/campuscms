<?php

use Ajifatur\FaturCMS\Models\Folder;

// Generate file name
if(!function_exists('generate_file_name')){
    function generate_file_name($text, $table, $field, $parentField, $parentValue, $primaryKey, $id = null){
        $name = $text;
        $i = 1;
        while(count_existing_file($table, $field, $name, $parentField, $parentValue, $primaryKey, $id) > 0){
            $name = rename_file($text, $i);
            $i++;
        }
        return $name;
    }
}

// Menghitung jumlah file / folder duplikat
if(!function_exists('count_existing_file')){
    function count_existing_file($table, $field, $keyword, $parentField, $parentValue, $primaryKey, $id = null){
        if($id == null) $data = DB::table($table)->where($field,'=',$keyword)->where($parentField,'=',$parentValue)->get();
        else $data = DB::table($table)->where($field,'=',$keyword)->where($parentField,'=',$parentValue)->where($primaryKey,'!=',$id)->get();
        return count($data);
    }
}


// Mengganti nama file jika ada yang sama
if(!function_exists('rename_file')){
    function rename_file($file, $count = 0){
        return $file." (".($count+1).")";
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