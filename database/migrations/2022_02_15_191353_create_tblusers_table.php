<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblusers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->integer('right_id')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('taluk')->nullable();
            $table->string('address')->nullable();
            $table->integer('userroleid')->index();
            $table->foreign('userroleid')->references('id')->on('tbluserroles')->onDelete('cascade');
            $table->boolean('isdeleted')->default(false);
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('tblusers');
    }
}
