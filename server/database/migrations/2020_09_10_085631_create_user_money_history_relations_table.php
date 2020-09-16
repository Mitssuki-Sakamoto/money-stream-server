<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMoneyHistoryRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_money_history_relations', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('money_history_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('money_history_id')->references('id')->on('money_histories');
            $table->primary(['user_id', 'money_history_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_money_history_relations');
    }
}
