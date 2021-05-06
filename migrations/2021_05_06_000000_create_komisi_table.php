<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('komisi')) {
            Schema::create('komisi', function (Blueprint $table) {
                $table->bigIncrements('id_komisi');
                $table->integer('id_user');
                $table->integer('id_sponsor');
                $table->integer('komisi_hasil');
                $table->integer('komisi_aktivasi');
                $table->integer('komisi_status');
                $table->string('komisi_proof');
                $table->integer('masuk_ke_saldo');
                $table->timestamp('komisi_at')->nullable();
                $table->string('inv_komisi');
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
        // Schema::dropIfExists('komisi');
    }
}
