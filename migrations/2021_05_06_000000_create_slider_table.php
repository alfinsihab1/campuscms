<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('slider')) {
            Schema::create('slider', function (Blueprint $table) {
                $table->bigIncrements('id_slider');
                $table->string('slider');
                $table->string('slider_url');
                $table->integer('status_slider');
                $table->integer('order_slider');
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
        // Schema::dropIfExists('slider');
    }
}
