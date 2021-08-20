<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('komentar')) {
            Schema::create('komentar', function (Blueprint $table) {
                $table->bigIncrements('id_komentar');
                $table->integer('id_user');
                $table->integer('id_artikel');
                $table->text('komentar');
                $table->integer('komentar_parent');
                $table->timestamp('komentar_at')->nullable();
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
        // Schema::dropIfExists('komentar');
    }
}
