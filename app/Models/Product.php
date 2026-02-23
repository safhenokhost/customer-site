<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'image', 'sku', 'category_id',
        'price', 'sale_price', 'stock', 'is_active', 'order',
        'meta_title', 'meta_description',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sale_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price !== null && $this->sale_price < $this->price
            ? (float) $this->sale_price
            : (float) $this->price;
    }
}
