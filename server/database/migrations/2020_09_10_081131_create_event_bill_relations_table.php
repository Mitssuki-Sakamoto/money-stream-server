<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventBillRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_bill_relations', function (Blueprint $table) {
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('bill_id');
            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->primary(['event_id', 'bill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_bill_relations');
    }
}
