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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->nullOnDelete();
            $table->unsignedBigInteger('payment_method_id');
            $table->string('payment_method_name');
            $table->unsignedBigInteger('payment_status_id');
            $table->string('payment_status_name');
            $table->unsignedBigInteger('payment_address_id');
            $table->string('payment_address_name');
            $table->unsignedBigInteger('shipping_status_id');
            $table->string('shipping_status_name');
            $table->unsignedBigInteger('shipping_method_id');
            $table->string('shipping_method_name');
            $table->unsignedBigInteger('shipping_address_id');
            $table->string('shipping_address_name');
            $table->string('notes')->nullable();
            $table->string('discount_code')->nullable();
            $table->decimal('total', 10)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
