<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('blog')) {
            Schema::create('blog', function (Blueprint $table) {
                $table->bigIncrements('id_blog');
                $table->string('blog_title');
                $table->string('blog_permalink');
                $table->string('blog_gambar')->nullable();
                $table->integer('blog_kategori');
                $table->text('blog_tag');
                $table->integer('blog_kontributor');
                $table->text('konten');
                $table->integer('author');
                $table->timestamp('blog_at')->nullable();
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
        // Schema::dropIfExists('blog');
    }
}
