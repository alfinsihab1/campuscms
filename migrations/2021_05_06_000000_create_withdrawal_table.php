<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('withdrawal')) {
            Schema::create('withdrawal', function (Blueprint $table) {
                $table->bigIncrements('id_withdrawal');
                $table->integer('id_user');
                $table->integer('id_rekening');
                $table->integer('nominal');
                $table->integer('withdrawal_status');
                $table->timestamp('withdrawal_success_at')->nullable();
                $table->string('withdrawal_proof');
                $table->timestamp('withdrawal_at')->nullable();
                $table->string('inv_withdrawal');
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
        // Schema::dropIfExists('withdrawal');
    }
}
