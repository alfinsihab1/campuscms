<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('cabang')) {
            Schema::create('cabang', function (Blueprint $table) {
                $table->bigIncrements('id_cabang');
                $table->string('nama_cabang');
                $table->text('alamat_cabang');
                $table->string('nomor_telepon_cabang');
                $table->string('instagram_cabang');
                $table->timestamp('cabang_at')->nullable();
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
        // Schema::dropIfExists('cabang');
    }
}
