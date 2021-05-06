<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('absensi')) {
            Schema::create('absensi', function (Blueprint $table) {
                $table->bigIncrements('id_absensi');
                $table->integer('id_user');
                $table->string('instansi')->nullable();
                $table->string('jurusan')->nullable();
                $table->string('kelas')->nullable();
                $table->timestamp('absensi_at')->nullable();
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
        // Schema::dropIfExists('absensi');
    }
}
