<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_program')) {
            Schema::create('user_program', function (Blueprint $table) {
                $table->bigIncrements('id_up');
                $table->integer('id_program');
                $table->string('nama_lengkap');
                $table->string('nama_panggilan');
                $table->string('email');
                $table->string('nomor_hp');
                $table->timestamp('up_at')->nullable();
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
        // Schema::dropIfExists('user_program');
    }
}
