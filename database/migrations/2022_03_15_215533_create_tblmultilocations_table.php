<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblmultilocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblmultilocations', function (Blueprint $table) {
            $table->id();
            $table->integer('locationid')->index();
            $table->foreign('locationid')->references('id')->on('tbllocations')->onDelete('cascade');
            $table->string('taluk');
            $table->string('village')->nullable();
            $table->string('district');
            $table->string('state');
            $table->string('city')->nullable();
            $table->string('ward')->nullable();
            $table->string('address');
            $table->string('lat');
            $table->string('long');
            $table->geometry('geom');
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
        Schema::dropIfExists('tblmultilocations');
    }
}
