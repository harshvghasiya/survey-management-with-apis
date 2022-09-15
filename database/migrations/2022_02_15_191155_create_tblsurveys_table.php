<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblsurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsurveys', function (Blueprint $table) {
            $table->id();
            $table->string('surveyname');
            $table->string('description')->nullable();
            $table->integer('surveytype_id')->index();
            $table->integer('order')->index();
            $table->foreign('surveytype_id')->references('id')->on('tblsurveytypes')->onDelete('cascade');
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
        Schema::dropIfExists('tblsurveys');
    }
}
