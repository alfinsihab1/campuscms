<?php

use Illuminate\Database\Seeder;
use Ajifatur\FaturCMS\Models\KategoriArtikel;

class KategoriArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriArtikel::updateOrCreate(['kategori' => 'Tak Berkategori'], ['slug' => 'tak-berkategori', 'id_ka' => 0]);
    }
}
