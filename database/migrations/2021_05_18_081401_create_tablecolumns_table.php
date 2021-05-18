<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablecolumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablecolumns', function (Blueprint $table) {
            $table->id();
            $table->string('begin_stock')->nullable();
            $table->string('units_in')->nullable();
            $table->string('units_out')->nullable();
            $table->string('units_sales')->nullable();
            $table->string('credit_card_sales')->nullable();
            $table->string('cashsales')->nullable();
            $table->string('bank_transfer_sales')->nullable();
            $table->string('gross_sales')->nullable();
            $table->string('total_discounts')->nullable();
            $table->string('net_sales')->nullable();
            $table->string('shipping_sales')->nullable();
            $table->string('total_sales')->nullable();
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
        Schema::dropIfExists('tablecolumns');
    }
}
