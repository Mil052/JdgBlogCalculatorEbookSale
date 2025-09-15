<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'id' => 1,
            'user_id' => 2,
            'payment' => null,
            'total_price' => 89.98,
            'status' => 'pending',
            'name' => 'Miłosz',
            'surname' => 'Jan',
            'postal_code' => '54-054',
            'city' => 'Wrocław',
            'address' => 'ul. Daktylowa 5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('order_product')->insert([
            [
                'order_id' => 1,
                'product_id' => 1,
                'amount' => 1,
                'price' => 49.99
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
                'amount' => 1,
                'price' => 39.99
            ]
        ]);

        DB::table('invoices')->insert([
            'id' => 1,
            'order_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'name' => 'Miłosz',
            'surname' => 'Jan',
            'company' => 'MySuperCompany',
            'postal_code' => '50-102',
            'city' => 'Wrocław',
            'address' => 'ul. Podwale 1'
        ]);
    }
}
