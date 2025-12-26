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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            /** ------------------------------------
             *  Basic Product Information
             * -----------------------------------*/
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();

            /** ------------------------------------
             *  Pricing
             * -----------------------------------*/
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('discount_price', 10, 2)->default(0.00);

            /** ------------------------------------
             *  Inventory & Units
             * -----------------------------------*/

            $table->string('unit_name')->nullable(); // e.g. kg, liter, piece
            $table->decimal('unit_value', 10, 2)->default(0.00); // renamed: 'unit' → 'unit_value'
            $table->string('stock_status')->default('in_stock'); // in_stock, out_of_stock, low_stock, backorder
            /** ------------------------------------
             *  Additional Data
             * -----------------------------------*/
            $table->string('status')->default('published'); // published/draft/private
            $table->text('note')->nullable();

            $table->json('json_data')->nullable(); // extra dynamic info
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
