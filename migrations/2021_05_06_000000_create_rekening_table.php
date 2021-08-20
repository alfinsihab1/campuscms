<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('rekening')) {
            Schema::create('rekening', function (Blueprint $table) {
                $table->bigIncrements('id_rekening');
                $table->integer('id_user');
                $table->integer('id_platform');
                $table->string('nomor');
                $table->string('atas_nama');
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
        // Schema::dropIfExists('rekening');
    }
}
