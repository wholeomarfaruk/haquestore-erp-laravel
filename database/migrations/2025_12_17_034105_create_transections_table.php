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
        Schema::create('transections', function (Blueprint $table) {
            $table->id();
            // Relationship
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();

            // Data
            $table->decimal('before_balance', 8, 2)->default(0.00);
            $table->decimal('after_balance', 8, 2)->default(0.00);
            $table->decimal('amount', 8, 2);
            $table->string('type')->nullable()->comment('credit,debit');
            $table->string('status')->default('complete');
            $table->text('note')->nullable();
            $table->string('payment_method')->nullable()->comment('cash,card,cheque,online');
            $table->softDeletes();

            // forein key
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transections');
    }
};
