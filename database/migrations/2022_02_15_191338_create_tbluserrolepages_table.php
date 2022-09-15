<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbluserrolepagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbluserrolepages', function (Blueprint $table) {
            $table->id();
            $table->integer('userroleid')->index();
            $table->foreign('userroleid')->references('id')->on('tbluserroles')->onDelete('cascade');
            $table->integer('page_id')->index();
            $table->foreign('page_id')->references('id')->on('tblpages')->onDelete('cascade');
            $table->boolean('readright')->default(true);
            $table->boolean('addright')->default(false);
            $table->boolean('editright')->default(false);
            $table->boolean('deleteright')->default(false);
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
        Schema::dropIfExists('tbluserrolepages');
    }
}
