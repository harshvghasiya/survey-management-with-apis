<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblpostaldatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblpostaldatas', function (Blueprint $table) {
            $table->id();
            $table->string('village')->nullable();
            $table->string('officename')->nullable();
            $table->string('pincode')->nullable();
            $table->string('block')->nullable();
            $table->string('district');
            $table->string('state');
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
        Schema::dropIfExists('tblpostaldatas');
    }
}
