<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
              /** ------------------------------------
             *  relationship
             * -----------------------------------*/
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id')->nullable();
             /** ------------------------------------
             *  product Details
             * -----------------------------------*/
            $table->string('product_name')->nullable();
            $table->string('unit_name')->nullable();
            $table->decimal('unit_qty', 10, 2)->default(0.00);

            $table->decimal('regular_price', 10, 2)->default(0.00);
            $table->decimal('discount_price', 10, 2)->default(0.00);
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
            $table->decimal('price_after_adjustment', 10, 2)->default(0.00);
            $table->boolean('is_price_adjusted')->default(false);

            $table->decimal('total', 10, 2)->default(0.00);

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
