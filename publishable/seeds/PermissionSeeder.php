<?php

use Illuminate\Database\Seeder;
use Ajifatur\FaturCMS\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['key_permission' => 'UserController::editProfile', 'nama_permission' => 'Mengupdate Profil', 'order_permission' => 0],
            ['key_permission' => 'VisitorController::index', 'nama_permission' => 'Menampilkan Data Visitor', 'order_permission' => 0],
            ['key_permission' => 'VisitorController::topVisitor', 'nama_permission' => 'Menampilkan Data Top Visitor', 'order_permission' => 0],
            ['key_permission' => 'MediaController::index', 'nama_permission' => 'Menampilkan Data Media', 'order_permission' => 0],
            ['key_permission' => 'MediaController::detail', 'nama_permission' => 'Menampilkan Detail Media', 'order_permission' => 0],
            ['key_permission' => 'MediaController::delete', 'nama_permission' => 'Menghapus Media', 'order_permission' => 0],
            ['key_permission' => 'MediaController::deleteBatch', 'nama_permission' => 'Menghapus Media (Batch)', 'order_permission' => 0],
        ];

        foreach($array as $data){
            Permission::firstOrCreate(['key_permission' => $data['key_permission']], ['nama_permission' => $data['nama_permission'], 'order_permission' => $data['order_permission']]);
        }
    }
}
