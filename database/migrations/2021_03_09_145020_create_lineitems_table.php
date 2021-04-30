<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineitems', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('shopify_shop_id')->nullable();
            $table->bigInteger('shopify_order_id')->nullable();

            $table->bigInteger('variant_id')->nullable();
            $table->bigInteger('product_id')->nullable();

            $table->string('title')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('sku')->nullable();
            $table->string('price')->nullable();
            $table->string('vendor')->nullable();
            $table->integer('fulfillable_quantity')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->string('fulfillment_response')->nullable();
            $table->text('properties')->nullable();
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
        Schema::dropIfExists('lineitems');
    }
}
