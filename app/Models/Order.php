<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'payment_type',
        'payment_id',
        'payment_status',
        'total_price',
        'order_status',
        'name',
        'surname',
        'email',
        'phone',
        'postal_code',
        'city',
        'address',
        'additional_info',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('quantity', 'price')->as('product_data');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
