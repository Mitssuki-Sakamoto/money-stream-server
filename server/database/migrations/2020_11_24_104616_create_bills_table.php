<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->unsignedInteger('money');
            $table->dateTime('datetime');
            $table->boolean('done')->default(False);
            $table->mediumText('note')->nullable($value = true);

            $table->unsignedInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events');

            $table->unsignedInteger('budget_id')->nullable($value = True);
            $table->foreign('budget_id')->references('id')->on('budgets');

            $table->unsignedInteger('money_history_id')->nullable($value = True);
            $table->foreign('money_history_id')->references('id')->on('money_histories');

            $table->unsignedInteger('to_user_id');
            $table->foreign('to_user_id')->references('id')->on('users');

            $table->unsignedInteger('from_user_id');
            $table->foreign('from_user_id')->references('id')->on('users');

            $table->unique(['event_id', 'budget_id', 'to_user_id'], // 多重請求防止
                'unique_budget_to_user');
            $table->unique(['event_id', 'money_history_id', 'to_user_id'], // 多重請求防止
                'unique_history_to_user'); // 第2引数はindex名(省略可能)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
