<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
    ];

    protected $casts = [
        'image' => 'string',
    ];

    /**
     * Validation rules for creating/updating categories.
     */
    public static function validationRules()
    {
        return [
            'name' => 'required|string|max:255|min:2|unique:categories,name',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'image' => 'nullable|url|max:500',
        ];
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope to get categories with products.
     */
    public function scopeWithProducts($query)
    {
        return $query->whereHas('products');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}


