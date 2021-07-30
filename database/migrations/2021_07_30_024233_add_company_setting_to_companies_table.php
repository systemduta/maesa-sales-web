<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanySettingToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('schema')->nullable();
            $table->string('target_low')->nullable();
            $table->string('target_middle')->nullable();
            $table->string('target_high')->nullable();
            $table->string('payment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('schema');
            $table->dropColumn('target_low');
            $table->dropColumn('target_middle');
            $table->dropColumn('target_high');
            $table->dropColumn('payment');
        });
    }
}
