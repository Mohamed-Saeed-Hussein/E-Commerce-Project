<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        'is_available',
        'image',
        'category_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'quantity' => 'integer',
    ];

    /**
     * Validation rules for creating/updating products.
     */
    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:255|min:2',
            'price' => 'required|numeric|min:0|max:999999.99',
            'description' => 'required|string|min:10|max:2000',
            'quantity' => 'required|integer|min:0|max:999999',
            'is_available' => 'required|boolean',
            'image' => 'nullable|url|max:500',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    protected $dates = ['deleted_at'];

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the cart items for this product.
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the order items for this product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope to get only available products.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)->where('quantity', '>', 0);
    }

    /**
     * Scope to get products by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to search products by name or description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock()
    {
        return $this->is_available && $this->quantity > 0;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Scope to get products with images.
     */
    public function scopeWithImages($query)
    {
        return $query->whereNotNull('image');
    }

    /**
     * Scope to get products by price range.
     */
    public function scopeByPriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    /**
     * Reduce stock quantity.
     */
    public function reduceStock($quantity)
    {
        if ($this->quantity >= $quantity) {
            $this->quantity -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Restore stock quantity.
     */
    public function restoreStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
    }
}
