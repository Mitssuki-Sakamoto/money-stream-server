<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBillRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bill_relations', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('bill_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->primary(['user_id', 'bill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bill_relations');
    }
}
