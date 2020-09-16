<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventMoneyHistoryRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_money_history_relations', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('money_history_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('money_history_id')->references('id')->on('money_histories');
            $table->primary(['event_id', 'money_history_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_money_history_relations');
    }
}
