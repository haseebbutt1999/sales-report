<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('comision')->nullable()->after('id');
            $table->string('payment1')->nullable()->after('comision');
            $table->string('note1')->nullable()->after('payment1');
            $table->string('payment2')->nullable()->after('note1');
            $table->string('note2')->nullable()->after('payment2');
            $table->string('payment3')->nullable()->after('note2');
            $table->string('note3')->nullable()->after('payment3');
            $table->string('payment4')->nullable()->after('note3');
            $table->string('note4')->nullable()->after('payment4');
            $table->string('payment5')->nullable()->after('note4');
            $table->string('note5')->nullable()->after('payment5');
            $table->string('total_cash_remaining')->nullable()->after('note5');
            $table->string('total_cash_collected')->nullable()->after('total_cash_remaining');
            $table->string('total_cash_collected_note')->nullable()->after('total_cash_collected');
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
