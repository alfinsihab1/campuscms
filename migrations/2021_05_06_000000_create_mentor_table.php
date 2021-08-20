<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('mentor')) {
            Schema::create('mentor', function (Blueprint $table) {
                $table->bigIncrements('id_mentor');
                $table->string('nama_mentor');
                $table->string('profesi_mentor');
                $table->string('foto_mentor');
                $table->integer('order_mentor');
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
        // Schema::dropIfExists('mentor');
    }
}
