<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTblusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblusers', function (Blueprint $table) {
            $table->tinyInteger('status')->comment('1=Active 0=Inactive')->default(1);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblusers', function (Blueprint $table) {
            $table->dropColumn('status');
            
        });
    }
}
