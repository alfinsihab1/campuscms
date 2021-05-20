<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('kelompok')) {
            Schema::create('kelompok', function (Blueprint $table) {
                $table->bigIncrements('id_kelompok');
                $table->string('nama_kelompok');
                $table->text('anggota_kelompok')->nullable();
                $table->timestamp('kelompok_at')->nullable();
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
        // Schema::dropIfExists('kelompok');
    }
}
