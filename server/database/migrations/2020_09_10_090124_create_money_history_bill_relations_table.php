<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyHistoryBillRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_history_bill_relations', function (Blueprint $table) {
            $table->unsignedInteger('money_history_id');
            $table->unsignedInteger('bill_id');
            $table->foreign('money_history_id')->references('id')->on('money_histories');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->primary(['money_history_id', 'bill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_history_bill_relations');
    }
}
