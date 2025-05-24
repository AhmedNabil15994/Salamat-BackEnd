<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookedOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('booked_offers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->boolean('unread')->default(false);
                $table->decimal('total',9,3)->default(0.000);
                $table->bigInteger('offer_id')->unsigned();
                $table->bigInteger('order_status_id')->unsigned();

                $table->foreign('offer_id')->references('id')
                ->on('offers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

                $table->foreign('order_status_id')->references('id')
                ->on('order_statuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

                $table->softDeletes();
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
        Schema::dropIfExists('booked_offers');
    }
}
