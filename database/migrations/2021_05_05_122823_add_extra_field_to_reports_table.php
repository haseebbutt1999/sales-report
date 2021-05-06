<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFieldToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            //all_credit $all_dis all_cash $all_bank $all_gross $all_shipp $all_totalSale
            $table->string('all_credit')->nullable()->after('id');
            $table->string('all_dis')->nullable()->after('id');
            $table->string('all_cash')->nullable()->after('id');
            $table->string('all_bank')->nullable()->after('id');
            $table->string('all_gross')->nullable()->after('id');
            $table->string('all_shipp')->nullable()->after('id');
            $table->string('all_totalSale')->nullable()->after('id');
            $table->string('date')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            //
        });
    }
}
