<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKarirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('karir')) {
            Schema::create('karir', function (Blueprint $table) {
                $table->bigIncrements('id_karir');
                $table->string('karir_title');
                $table->string('karir_permalink');
                $table->string('karir_gambar');
                $table->string('karir_url');
                $table->text('konten');
                $table->integer('author');
                $table->timestamp('karir_at')->nullable();
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
        // Schema::dropIfExists('karir');
    }
}
