<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventorylevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorylevels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('inventory_item_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->string('available')->nullable();
            $table->string('old_available')->nullable();
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
        Schema::dropIfExists('inventorylevels');
    }
}
