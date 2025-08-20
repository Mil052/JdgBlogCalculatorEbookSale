<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPostAsset extends Model
{
    protected $table = 'blog_posts_assets';

    protected $fillable = ['file_name', 'alt_text', 'source', 'blog_post_id'];

    public $timestamps = false;
    
    public function blog_post(): BelongsTo
    {
        return $this -> belongsTo(BlogPost::class);
    }
}