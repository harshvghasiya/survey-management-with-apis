<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblprojectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblprojects', function (Blueprint $table) {
            $table->id();
            $table->string('projectname');
            $table->string('startdate');
            $table->string('enddate');
            $table->integer('category_id')->index();
            $table->foreign('category_id')->references('id')->on('tblprojectcateogries')->onDelete('cascade');
            $table->integer('survey_id')->index()->nullable();
            $table->foreign('survey_id')->references('id')->on('tblsurveys')->onDelete('cascade');
            $table->integer('targetbeneficiaries')->nullable();
            $table->integer('projectestimation');
            $table->string('description')->nullable();
            $table->boolean('isdeleted')->default(false);
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
        Schema::dropIfExists('tblprojects');
    }
}
