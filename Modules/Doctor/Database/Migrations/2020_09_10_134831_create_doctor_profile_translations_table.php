<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorProfileTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_profile_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('about')->nullable();
            $table->text('job_title')->nullable();
            $table->string('locale')->index();
            $table->bigInteger('doctor_profile_id')->unsigned();
            $table->foreign('doctor_profile_id')->references('id')->on('doctor_profile')->onDelete('cascade');
            $table->unique(['doctor_profile_id','locale'],'d_p_l');
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
        Schema::dropIfExists('doctor_profile_translations');
    }
}
