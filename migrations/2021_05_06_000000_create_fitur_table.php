<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiturTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('fitur')) {
            Schema::create('fitur', function (Blueprint $table) {
                $table->bigIncrements('id_fitur');
                $table->string('nama_fitur');
                $table->text('deskripsi_fitur');
                $table->text('url_fitur');
                $table->string('gambar_fitur');
                $table->integer('order_fitur');
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
        // Schema::dropIfExists('fitur');
    }
}
