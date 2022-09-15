<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblprojectlocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblprojectlocations', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->foreign('project_id')->references('id')->on('tblprojects')->onDelete('cascade');
            $table->integer('location_id')->index();
            $table->foreign('location_id')->references('id')->on('tbllocations')->onDelete('cascade');
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
        Schema::dropIfExists('tblprojectlocations');
    }
}
