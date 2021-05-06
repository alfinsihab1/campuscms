<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFolderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('folder')) {
            Schema::create('folder', function (Blueprint $table) {
                $table->bigIncrements('id_folder');
                $table->integer('id_user');
                $table->string('folder_nama');
                $table->integer('folder_kategori');
                $table->text('folder_dir');
                $table->integer('folder_parent');
                $table->string('folder_icon');
                $table->string('folder_voucher');
                $table->timestamp('folder_at')->nullable();
                $table->timestamp('folder_up')->nullable();
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
        // Schema::dropIfExists('folder');
    }
}
