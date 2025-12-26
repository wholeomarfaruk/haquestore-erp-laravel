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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
               /** ------------------------------------
             *  relationship &
             * -----------------------------------*/
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
             /** ------------------------------------
             *  Invoice Details
             * -----------------------------------*/
            $table->string('invoice_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2)->default(0.00);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->decimal('due_amount', 10, 2)->default(0.00);
            $table->string('status')->default('draft'); // draft, completed, cancelled,due,overdue
            $table->string('delivery_status')->default('pending'); // delivered, pending,partial_delivered,returned,cancelled
            $table->string('payment_status')->default('unpaid'); // paid, partial, unpaid
            $table->text('note')->nullable();
            $table->json('json_data')->nullable();

             /** ------------------------------------
             *  Foreign Keys
             * -----------------------------------*/
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
