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
        Schema::create('payment_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreignId('order_id')->references('id')->on('orders')->nullOnDelete();
            $table->unsignedBigInteger('old_payment_status_id')->nullable();
            $table->string('old_payment_status_name')->nullable();
            $table->unsignedBigInteger('new_payment_status_id');
            $table->string('new_payment_status_name');
            $table->string('token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_history');
    }
};
