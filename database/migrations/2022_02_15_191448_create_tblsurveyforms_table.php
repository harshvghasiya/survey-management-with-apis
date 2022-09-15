<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblsurveyformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblsurveyforms', function (Blueprint $table) {
            $table->id();
            $table->integer('survey_id')->index();
            $table->foreign('survey_id')->references('id')->on('tblsurveys')->onDelete('cascade');
            $table->string('question');
            $table->string('question_type');
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->string('option3')->nullable();
            $table->string('option4')->nullable();
            $table->string('size')->nullable();
            $table->string('column');
            $table->boolean('required')->default(false);
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
        Schema::dropIfExists('tblsurveyforms');
    }
}
