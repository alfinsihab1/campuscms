<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultRekeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('default_rekening')) {
            Schema::create('default_rekening', function (Blueprint $table) {
                $table->bigIncrements('id_dr');
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
        // Schema::dropIfExists('default_rekening');
    }
}
