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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('delivery_type')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_zipcode')->nullable();
            $table->decimal('delivery_charge', 10, 2)->default(0);
            $table->date('delivery_date')->nullable();
            $table->text('deliveryNote')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            // If you have orders and customers table, you can uncomment these
            // $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
