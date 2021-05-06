<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(KategoriSettingSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(PlatformSeeder::class);
        $this->call(KategoriArtikelSeeder::class);
        $this->call(KategoriPelatihanSeeder::class);
        $this->call(UserSeeder::class);
    }
}
