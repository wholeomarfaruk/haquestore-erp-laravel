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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('stock', 10, 3)->default(0.000)->change();
                        $table->decimal('unit_value', 10, 3)->default(0.000)->change();

        });
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->decimal('unit_qty', 10, 3)->default(0.000)->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('stock', 10, 2)->default(0.00)->change();
            $table->decimal('unit_value', 10, 2)->default(0.00)->change();
        });
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->decimal('unit_qty', 10, 2)->default(0.00)->change();
        });
    }
};
