<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $attributes = [
        'name' => 'Nowy Produkt',
        'available' => false
    ];
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product');
    }
}