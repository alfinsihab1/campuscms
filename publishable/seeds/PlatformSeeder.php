<?php

use Illuminate\Database\Seeder;
use Ajifatur\FaturCMS\Models\Platform;

class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ['nama' => 'BNI', 'tipe' => 1],
            ['nama' => 'BRI', 'tipe' => 1],
            ['nama' => 'BTN', 'tipe' => 1],
            ['nama' => 'Bank Mandiri', 'tipe' => 1],
            ['nama' => 'BSI', 'tipe' => 1],
            ['nama' => 'Go-Pay', 'tipe' => 2],
            ['nama' => 'OVO', 'tipe' => 2],
            ['nama' => 'LinkAja', 'tipe' => 2],
            ['nama' => 'DANA', 'tipe' => 2],
        ];

        foreach($array as $key=>$data){
            Platform::updateOrCreate(['nama_platform' => $data['nama']], ['tipe_platform' => $data['tipe']]);
        }
    }
}
