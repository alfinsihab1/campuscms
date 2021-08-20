<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeskripsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('deskripsi')) {
            Schema::create('deskripsi', function (Blueprint $table) {
                $table->bigIncrements('id_deskripsi');
                $table->string('judul_deskripsi');
                $table->text('deskripsi');
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
        // Schema::dropIfExists('deskripsi');
    }
}
