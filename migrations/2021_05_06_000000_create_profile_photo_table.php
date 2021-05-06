<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('profile_photo')) {
            Schema::create('profile_photo', function (Blueprint $table) {
                $table->bigIncrements('id_pp');
                $table->integer('id_user');
                $table->string('photo_name');
                $table->timestamp('uploaded_at')->nullable();
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
        // Schema::dropIfExists('profile_photo');
    }
}
