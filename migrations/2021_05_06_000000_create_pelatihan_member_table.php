<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelatihanMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('pelatihan_member')) {
            Schema::create('pelatihan_member', function (Blueprint $table) {
                $table->bigIncrements('id_pm');
                $table->integer('id_user');
                $table->integer('id_pelatihan');
                $table->string('kode_sertifikat');
                $table->integer('status_pelatihan');
                $table->integer('fee');
                $table->string('fee_bukti');
                $table->integer('fee_status');
                $table->string('inv_pelatihan');
                $table->timestamp('pm_at')->nullable();
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
        // Schema::dropIfExists('pelatihan_member');
    }
}
