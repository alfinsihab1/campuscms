<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrefixAndIconToFolderKategoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('folder_kategori', function (Blueprint $table) {
            if (!Schema::hasColumn('folder_kategori', 'prefix_kategori')) {
                $table->string('prefix_kategori');
            }
            if (!Schema::hasColumn('folder_kategori', 'icon_kategori')) {
                $table->string('icon_kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
