<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopify_shop_id')->nullable();
            $table->string('shopify_order_name');
            $table->unsignedBigInteger('shopify_order_id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('order_status_url')->nullable();
            $table->text('note')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->string('presentment_currency')->nullable();
            $table->text('payment_gateway_names')->nullable();
            $table->string('test')->nullable();
            $table->string('contact_email')->nullable();

            $table->text('customer')->nullable();
            $table->integer('order_number')->nullable();

            $table->text('tax_lines')->nullable();
            $table->text('payment_details')->nullable();
            $table->text('line_items')->nullable();
            $table->bigInteger('checkout_id')->nullable();
            $table->float('total_price')->nullable();
            $table->float('subtotal_price')->nullable();
            $table->float('total_weight')->nullable();
            $table->float('total_tax')->nullable();
            $table->string('currency')->nullable();
            $table->string('financial_status')->nullable();
            $table->float('total_line_items_price')->nullable();
            $table->string('taxes_included')->nullable();
            $table->string('confirmed')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('checkout_token')->nullable();
            $table->string('reference')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->string('order_token')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
