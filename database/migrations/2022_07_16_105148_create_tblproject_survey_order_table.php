<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblprojectSurveyOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblproject_survey_order', function (Blueprint $table) {
            $table->id();
             $table->integer('project_id')->nullable();
            $table->integer('survey_id')->nullable();
            $table->string('order')->nullable();
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
        Schema::dropIfExists('tblproject_survey_order');
    }
}
