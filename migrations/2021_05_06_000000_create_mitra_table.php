<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('mitra')) {
            Schema::create('mitra', function (Blueprint $table) {
                $table->bigIncrements('id_mitra');
                $table->string('nama_mitra');
                $table->string('logo_mitra');
                $table->integer('order_mitra');
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
        // Schema::dropIfExists('mitra');
    }
}
