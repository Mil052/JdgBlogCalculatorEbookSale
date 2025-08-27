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
            $table->foreignId('user_id')->nullable()->constrained();
            $table->set('payment', ['online', 'traditional'])->nullable();
            $table->decimal('total_price');
            $table->string('invoice_id');
            $table->string('invoice_name');
            $table->string('invoice_surname');
            $table->string('invoice_company_name');
            $table->string('invoice_postal_code');
            $table->string('invoice_city');
            $table->string('invoice_address');
            $table->string('shipping_postal_code');
            $table->string('shipping_city');
            $table->string('shipping_address');
            $table->string('shipping_postal_code');
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
