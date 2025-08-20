<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('blog_posts')->insert([
            'id' => 1,
            'title' => 'Super interesujący tytuł nowego posta na temat JDG który zaprosi użytkownika do sekcji BLOG.',
            'excerpt' => 'Krótkie wprowadzenie do tego niesamowitego tematu, które da szybki podgląd co użytkownik znajdzie w artykule i dlaczego potrzebuje to wiedzieć, spowoduje zainteresowanie i zaprosi do pozostania na stronie na dłużej',
            'content' => 'Nie bardzo długi, ale bardzo mądry artykuł na temat prowdzenia Jednoosobowej Działąlności Gospodarczej, związanych z nią obowiązków podatkowych i możliwych sposobów na ograniczenia ich wielkości.',
            'author' => 'Me Myself',
            'publish' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('blog_posts_assets')->insert([
            'id' => 1,
            'file_name' => 'laptop.webp',
            'alt_text' => 'Laptop na biurku',
            'source' => 'https://www.pexels.com/pl-pl/zdjecie/srebrny-laptop-i-bialy-kubek-na-stole-7974',
            'blog_post_id' => 1,
        ]);
    }
}
