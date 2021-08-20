<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('kategori_pelatihan')) {
            Schema::create('kategori_pelatihan', function (Blueprint $table) {
                $table->bigIncrements('id_kp');
                $table->string('kategori');
                $table->string('slug');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('kategori_pelatihan');
    }
}
