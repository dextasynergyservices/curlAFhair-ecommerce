<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'price',
        'discount_price',
        'is_discounted',
        'category',
        'description',
        'quantity',
        'image',
        'stock',
        'is_active',
        'is_promo_product',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_discounted' => 'boolean',
        'is_active' => 'boolean',
        'is_promo_product' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'PRD-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function winningCodes()
    {
        return $this->hasMany(WinningCode::class);
    }

    /**
     * Scope to get active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get promo products
     */
    public function scopePromo($query)
    {
        return $query->where('is_promo_product', true);
    }

    /**
     * Scope to get featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope to get discounted products
     */
    public function scopeDiscounted($query)
    {
        return $query->where('is_discounted', true);
    }

    /**
     * Get the effective price (discounted or regular)
     */
    public function getEffectivePriceAttribute(): float
    {
        if ($this->is_discounted && $this->discount_price) {
            return $this->discount_price;
        }
        return $this->price;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        if ($this->is_discounted && $this->discount_price && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return null;
    }

    /**
     * Check if product is in stock
     */
    public function getInStockAttribute(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            // Use Storage::url for proper URL generation in all environments
            return Storage::disk('public')->url($this->image);
        }
        return asset('images/product-placeholder.jpg');
    }
}
