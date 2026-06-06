<?php

// database/migrations/xxxx_xx_xx_create_payments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('gateway')->default('esewa');   // Esewa, Khalti, COD
            $table->string('transaction_id')->nullable(); // Esewa txn ID
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['Pending', 'Paid', 'Failed', 'Refunded'])->default('Pending');
            $table->json('payload')->nullable();          // Store Esewa raw response
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
