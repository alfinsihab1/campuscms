<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsikologTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('psikolog')) {
            Schema::create('psikolog', function (Blueprint $table) {
                $table->bigIncrements('id_psikolog');
                $table->string('nama_psikolog');
                $table->integer('kategori_psikolog');
                $table->string('kode_psikolog');
                $table->text('alamat_psikolog');
                $table->string('nomor_telepon_psikolog');
                $table->string('instagram_psikolog');
                $table->timestamp('psikolog_at')->nullable();
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
        // Schema::dropIfExists('psikolog');
    }
}
