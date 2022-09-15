<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblprojectusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblprojectusers', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->index();
            $table->foreign('project_id')->references('id')->on('tblprojects')->onDelete('cascade');
            $table->integer('user_id')->index();
            $table->foreign('user_id')->references('id')->on('tblusers')->onDelete('cascade');
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
        Schema::dropIfExists('tblprojectusers');
    }
}
