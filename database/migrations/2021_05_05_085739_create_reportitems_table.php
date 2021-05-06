<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportitems', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('report_id')->nullable();
            $table->string('collection_name')->nullable();
            $table->string('begin_stock')->nullable();
            $table->string('unitin')->nullable();
            $table->string('unitout')->nullable();
            $table->string('unitsale')->nullable();
            $table->string('credit_card_sale')->nullable();
            $table->string('cashsale')->nullable();
            $table->string('bank_sale')->nullable();
            $table->string('gross_sale')->nullable();
            $table->string('total_discount')->nullable();
            $table->string('net_sale')->nullable();
            $table->string('shipping_sale')->nullable();
            $table->string('total_sale')->nullable();
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
        Schema::dropIfExists('reportitems');
    }
}
