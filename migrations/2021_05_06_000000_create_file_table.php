<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('file')) {
            Schema::create('file', function (Blueprint $table) {
                $table->bigIncrements('id_file');
                $table->integer('id_folder');
                $table->integer('id_user');
                $table->string('file_nama');
                $table->integer('file_kategori');
                $table->text('file_deskripsi');
                $table->text('file_konten');
                $table->text('file_keterangan')->nullable();
                $table->string('file_thumbnail')->nullable();
                $table->timestamp('file_at')->nullable();
                $table->timestamp('file_up')->nullable();
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
        // Schema::dropIfExists('file');
    }
}
