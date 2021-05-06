<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('acara')) {
            Schema::create('acara', function (Blueprint $table) {
                $table->bigIncrements('id_acara');
                $table->string('nama_acara');
                $table->string('slug_acara');
                $table->integer('kategori_acara');
                $table->text('deskripsi_acara');
                $table->string('gambar_acara')->nullable();
                $table->string('tempat_acara')->nullable();
                $table->timestamp('tanggal_acara_from')->nullable();
                $table->timestamp('tanggal_acara_to')->nullable();
                $table->timestamp('acara_at')->nullable();
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
        // Schema::dropIfExists('acara');
    }
}
