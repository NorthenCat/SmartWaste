<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('name');
            $table->double('price_per_unit');
            $table->double('price_sell_per_unit');
            $table->string('unit');
            $table->integer('weight_for_point');
            $table->integer('point_per_weight');
            $table->integer('minimal_weight');
            $table->integer('minimal_sell_weight');
            $table->double('stock');
            $table->string('stock_unit');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
