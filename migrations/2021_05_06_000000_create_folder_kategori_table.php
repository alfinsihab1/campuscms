<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('folder_kategori')) {
            Schema::create('folder_kategori', function (Blueprint $table) {
                $table->bigIncrements('id_fk');
                $table->string('folder_kategori');
                $table->string('slug_kategori');
                $table->string('tipe_kategori');
                $table->integer('status_kategori');
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
        // Schema::dropIfExists('folder_kategori');
    }
}
