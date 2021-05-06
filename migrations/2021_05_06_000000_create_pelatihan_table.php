<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pelatihan')) {
            Schema::create('pelatihan', function (Blueprint $table) {
                $table->bigIncrements('id_pelatihan');
                $table->string('nama_pelatihan');
                $table->integer('kategori_pelatihan');
                $table->string('nomor_pelatihan');
                $table->text('deskripsi_pelatihan');
                $table->string('gambar_pelatihan');
                $table->integer('fee_member');
                $table->integer('fee_non_member');
                $table->integer('trainer');
                $table->string('kode_trainer');
                $table->text('tempat_pelatihan');
                $table->timestamp('tanggal_pelatihan_from')->nullable();
                $table->timestamp('tanggal_pelatihan_to')->nullable();
                $table->timestamp('tanggal_sertifikat_from')->nullable();
                $table->timestamp('tanggal_sertifikat_to')->nullable();
                $table->text('materi_pelatihan');
                $table->integer('total_jam_pelatihan');
                $table->timestamp('pelatihan_at')->nullable();
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
        // Schema::dropIfExists('pelatihan');
    }
}
