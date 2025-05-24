<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffCustomDateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_custom_date', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time_from');
            $table->time('time_to');
            $table->morphs('customable_off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('off_custom_date');
    }
}
