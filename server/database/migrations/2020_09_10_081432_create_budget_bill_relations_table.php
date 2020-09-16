<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetBillRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('budget_bill_relations', function (Blueprint $table) {
            $table->unsignedInteger('budget_id');
            $table->unsignedInteger('bill_id');
            $table->foreign('budget_id')->references('id')->on('budgets');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->primary(['budget_id', 'bill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('budget_bill_relations');
    }
}
