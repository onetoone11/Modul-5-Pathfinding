<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParamColumnsToWorlds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worlds', function (Blueprint $table) {
            $table->string('param1')->nullable();
            $table->string('param2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worlds', function (Blueprint $table) {
            $table->dropColumn('param1');
            $table->dropColumn('param2');
        });
    }
}
