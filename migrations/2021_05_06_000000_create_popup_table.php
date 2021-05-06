<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('popup')) {
            Schema::create('popup', function (Blueprint $table) {
                $table->bigIncrements('id_popup');
                $table->string('popup_gambar');
                $table->text('popup_judul');
                $table->text('popup_konten')->nullable();
                $table->date('popup_from')->nullable();
                $table->date('popup_to')->nullable();
                $table->timestamp('popup_at')->nullable();
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
        // Schema::dropIfExists('popup');
    }
}
