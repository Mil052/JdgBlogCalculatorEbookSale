<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('amount', 'price')->as('product_data');
    }

    public function invoice (): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
