<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopify_product_id')->nullable();
            $table->text('shopify_shop_id')->nullable();

            $table->longText('body_html')->nullable();
            $table->string('title')->nullable();
            $table->string('product_type')->nullable();
            $table->string('handle')->nullable()->nullable();
            $table->string('published_scope')->nullable();
            $table->string('tags')->nullable();
            $table->string('vendor')->nullable();
            $table->text('image')->nullable();
            $table->text('options')->nullable();
            $table->timestamp('published_at')->nullable();

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
        Schema::dropIfExists('products');
    }
}
