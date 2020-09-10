<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBudgetRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_budget_relations', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('budget_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->primary(['event_id', 'budget_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_budget_relations');
    }
}
