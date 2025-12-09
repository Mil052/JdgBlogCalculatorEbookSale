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
            $table->timestamps();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('payment_type', ['online', 'traditional', 'on_delivery'])->nullable();
            $table->string('payment_order_id')->nullable();
            $table->enum('payment_status', ['PENDING', 'COMPLETED', 'CANCELED'])->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->decimal('total_price');
            // status
            $table->enum('order_status', ['awaiting', 'accepted', 'completed', 'canceled']);
            // order shipping data 
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->string('postal_code');
            $table->string('city');
            $table->string('address');
            $table->string('additional_info')->nullable();
        });

        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('quantity');
            $table->decimal('price');
        });

         Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            // order
            $table->foreignId('order_id')->nullable()->constrained();
            // invoice client data
            $table->string('name');
            $table->string('surname');
            $table->string('company')->nullable();
            $table->string('nip')->nullable();
            $table->string('postal_code');
            $table->string('city');
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('invoices');
    }
};
