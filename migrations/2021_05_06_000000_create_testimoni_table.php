<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimoniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('testimoni')) {
            Schema::create('testimoni', function (Blueprint $table) {
                $table->bigIncrements('id_testimoni');
                $table->string('nama_klien');
                $table->string('profesi_klien');
                $table->string('foto_klien');
                $table->text('testimoni');
                $table->integer('order_testimoni');
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
        // Schema::dropIfExists('testimoni');
    }
}
