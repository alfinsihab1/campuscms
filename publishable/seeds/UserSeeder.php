<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check user with IT access
        $count = User::where('role','=',role('it'))->count();

        // Create user account if $count less than 1
        if($count < 1){
            $user = new User;
            $user->nama_user = 'Admin';
            $user->email = 'admin@admin.com';
            $user->username = 'admin@admin.com';
            $user->password = bcrypt('password');
            $user->tanggal_lahir = date('Y-m-d');
            $user->jenis_kelamin = 'L';
            $user->nomor_hp = '081234567890';
            $user->reference = '';
            $user->foto = '';
            $user->role = role('it');
            $user->is_admin = 1;
            $user->status = 1;
            $user->email_verified = 1;
            $user->saldo = 0;
            $user->last_visit = null;
            $user->register_at = date('Y-m-d H:i:s');
            $user->save();
        }
    }
}
