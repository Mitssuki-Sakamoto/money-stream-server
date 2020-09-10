<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyHistoryBudgetRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_history_budget_relations', function (Blueprint $table) {
            $table->unsignedInteger('money_history_id');
            $table->unsignedInteger('budget_id');
            $table->foreign('money_history_id')->references('id')->on('money_histories');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->primary(['money_history_id', 'budget_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_history_budget_relations');
    }
}
