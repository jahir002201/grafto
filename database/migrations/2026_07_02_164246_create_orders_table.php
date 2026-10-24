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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', [
                'Not Paid',
                'Ready To Ship',
                'Shipped',
                'Delivered',
                'Canceled',
            ])->default('Not Paid');
            $table->string('shipping_address');
            $table->string('shipping_phone');
            $table->string('shipping_name');
            $table->timestamps();
            $table->unique(['user_id', 'status']);
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
