<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHalamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('halaman')) {
            Schema::create('halaman', function (Blueprint $table) {
                $table->bigIncrements('id_halaman');
                $table->string('halaman_title');
                $table->string('halaman_permalink');
                $table->integer('halaman_tipe');
                $table->text('konten');
                $table->timestamp('halaman_at')->nullable();
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
        // Schema::dropIfExists('halaman');
    }
}
