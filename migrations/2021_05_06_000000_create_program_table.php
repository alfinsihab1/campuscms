<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('program')) {
            Schema::create('program', function (Blueprint $table) {
                $table->bigIncrements('id_program');
                $table->string('program_title');
                $table->string('program_permalink');
                $table->string('program_gambar');
                $table->integer('program_kategori');
                $table->text('konten');
                $table->integer('author');
                $table->timestamp('program_at')->nullable();
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
        // Schema::dropIfExists('program');
    }
}
