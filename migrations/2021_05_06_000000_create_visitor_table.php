<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('visitor')) {
            Schema::create('visitor', function (Blueprint $table) {
                $table->bigIncrements('id_visitor');
                $table->integer('id_user');
                $table->string('ip_address');
                $table->timestamp('visit_at')->nullable();
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
        // Schema::dropIfExists('visitor');
    }
}
