<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmartcollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smartcollections', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shopify_smartcollection_id')->nullable();
            $table->bigInteger('shopify_shop_id')->nullable();

            $table->string('title')->nullable();
            $table->string('body_html')->nullable();
            $table->string('handle')->nullable();

            $table->string('sort_order')->nullable();
            $table->text('collection_image')->nullable();
            $table->text('rules')->nullable();
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
        Schema::dropIfExists('smartcollections');
    }
}
