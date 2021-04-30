<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderExtraFieldToOrderssTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->float('total_discounts')->nullable()->after('total_price');
//            $table->text('payment_details')->nullable()->after('total_price');
//            $table->text('total_line_items_price_set')->nullable()->after('total_price');
//            $table->text('total_discounts_set')->nullable()->after('total_price');
//            $table->text('total_shipping_price_set')->nullable()->after('total_price');
//            $table->text('subtotal_price_set')->nullable()->after('total_price');
//            $table->text('total_price_set')->nullable()->after('total_price');
//
//            $table->string('payment_gateway_names')->nullable()->after('total_price');
//            $table->text('processing_method')->nullable()->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
