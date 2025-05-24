<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimesToOffDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('off_days', function (Blueprint $table) {
            $table->time('end_time')->after('day')->defult('23:59');
            $table->time('start_time')->after('day')->defult('00:01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('off_days', function (Blueprint $table) {

        });
    }
}
