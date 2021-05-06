<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('signature')) {
            Schema::create('signature', function (Blueprint $table) {
                $table->bigIncrements('id_signature');
                $table->integer('id_user');
                $table->string('signature');
                $table->timestamp('signature_at')->nullable();
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
        // Schema::dropIfExists('signature');
    }
}
