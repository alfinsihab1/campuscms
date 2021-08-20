<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('email')) {
            Schema::create('email', function (Blueprint $table) {
                $table->bigIncrements('id_email');
                $table->string('subject');
                $table->text('receiver_id');
                $table->text('receiver_email');
                $table->integer('sender');
                $table->text('content');
                $table->timestamp('sent_at')->nullable();
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
        // Schema::dropIfExists('email');
    }
}
