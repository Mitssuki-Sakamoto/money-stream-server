<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('thumbnail', 255)->nullable($value = true);
            $table->date('start_date');
            $table->date('end_date')->nullable($value = true);
            $table->mediumText('description')->nullable($value = true);
            $table->boolean('finish')->default(False);
            $table->unsignedInteger('wallet')->default(0);
            $table->unique('thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
