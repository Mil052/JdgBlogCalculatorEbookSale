<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Db::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Dwuosobowa Działalność Gospodarcza od podstaw',
                'type' => 'książka',
                'description' => '„Jednoosobowa Działalność Gospodarcza od podstaw” to praktyczny przewodnik dla osób, które chcą rozpocząć własną działalność gospodarczą w Polsce. Książka krok po kroku wyjaśnia, czym jest jednoosobowa firma, jak ją zarejestrować, jakie obowiązki podatkowe i formalne wiążą się z jej prowadzeniem oraz jakie są korzyści i ryzyka tego rozwiązania. Autor w prosty sposób omawia wybór formy opodatkowania, kwestie związane z ZUS, prowadzeniem księgowości oraz podstawami marketingu i zarządzania finansami. To kompendium wiedzy skierowane zarówno do początkujących przedsiębiorców, jak i osób rozważających przejście na samozatrudnienie.',
                'excerpt' => 'Praktyczny przewodnik dla osób, które chcą rozpocząć własną działalność gospodarczą w Polsce',
                'image' => '2dg_przewodnik.webp',
                'price' => 49.99,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'JDG 2025',
                'type' => 'książka',
                'description' => 'Prowadzenie jednoosobowej działalności gospodarczej w Polsce to wciąż jedna z najpopularniejszych form pracy na własny rachunek. Każdego roku przepisy prawne i podatkowe ulegają jednak istotnym zmianom, które bezpośrednio wpływają na codzienne funkcjonowanie przedsiębiorców. Niniejsza książka powstała, aby w przystępny i praktyczny sposób zaprezentować najnowsze regulacje dotyczące samozatrudnienia - od zasad rejestracji firmy, przez wybór formy opodatkowania, po obowiązki wobec ZUS i urzędów skarbowych. Dzięki temu otrzymasz aktualną i uporządkowaną wiedzę, która pozwoli Ci podejmować świadome decyzje i uniknąć najczęstszych błędów przy prowadzeniu własnej działalności.',
                'excerpt' => 'Każdego roku przepisy prawne i podatkowe ulegają istotnym zmianom, które bezpośrednio wpływają na codzienne funkcjonowanie przedsiębiorców. Niniejsza książka powstała, aby w przystępny i praktyczny sposób zaprezentować najnowsze regulacje dotyczące samozatrudnienia',
                'image' => 'jdg_poradnik.webp',
                'price' => 39.99,
                'available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
