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
        Schema::create('blog_posts_assets', function (Blueprint $table) {
            $table -> id();
            $table -> string('file_name');
            $table -> string('alt_text') -> nullable();
            $table -> string('source') -> nullable();
            $table -> foreignId('blog_post_id') -> constrained() -> onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts_assets');
    }
};
