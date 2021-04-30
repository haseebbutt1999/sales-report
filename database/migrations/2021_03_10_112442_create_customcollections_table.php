<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomcollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customcollections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopify_customcollection_id')->nullable();
            $table->bigInteger('shopify_shop_id')->nullable();

            $table->string('title')->nullable();
            $table->string('body_html')->nullable();
            $table->string('handle')->nullable();

            $table->string('sort_order')->nullable();
            $table->text('collection_image')->nullable();
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
        Schema::dropIfExists('customcollections');
    }
}
