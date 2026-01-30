<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'product_variant_id',
        'quantity',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the unit price (variant price or product price)
     */
    public function getUnitPriceAttribute(): float
    {
        if ($this->variant) {
            // Check if variant is discounted
            if ($this->variant->is_discounted && $this->variant->discount_price) {
                return $this->variant->discount_price;
            }
            return $this->variant->price;
        }

        // Check if product is discounted
        if ($this->product->is_discounted && $this->product->discount_price) {
            return $this->product->discount_price;
        }
        return $this->product->price;
    }

    /**
     * Get the original price (before discount)
     */
    public function getOriginalPriceAttribute(): float
    {
        if ($this->variant) {
            return $this->variant->price;
        }
        return $this->product->price;
    }

    /**
     * Get total price for this item
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->unit_price * $this->quantity;
    }

    /**
     * Check if item has discount
     */
    public function getHasDiscountAttribute(): bool
    {
        if ($this->variant) {
            return $this->variant->is_discounted && $this->variant->discount_price;
        }
        return $this->product->is_discounted && $this->product->discount_price;
    }
}
