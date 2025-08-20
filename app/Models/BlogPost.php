<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogPost extends Model
{
    protected $fillable = ['title', 'excerpt', 'content', 'author', 'publish'];

    protected $attributes = [
        'title' => 'Nowy Post',
        'publish' => false
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(BlogPostAsset::class);
    }
}
