<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceInfoToVisitorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visitor', function (Blueprint $table) {
            if (!Schema::hasColumn('visitor', 'device')) {
                $table->text('device')->nullable();
            }
            if (!Schema::hasColumn('visitor', 'browser')) {
                $table->text('browser')->nullable();
            }
            if (!Schema::hasColumn('visitor', 'platform')) {
                $table->text('platform')->nullable();
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
