<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTargetToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('target_visit')->nullable();
            $table->integer('target_low')->nullable();
            $table->integer('target_middle')->nullable();
            $table->integer('target_high')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('target_visit');
            $table->dropColumn('target_low');
            $table->dropColumn('target_middle');
            $table->dropColumn('target_high');
        });
    }
}
