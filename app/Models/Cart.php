<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public static function addToCart($userId, $productId, $quantity, $price)
    {
        $cartItem = self::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            self::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }
    }

    public static function getCartItems($userId)
    {
        return self::with('product')
                  ->where('user_id', $userId)
                  ->get();
    }

    public static function clearCart($userId)
    {
        self::where('user_id', $userId)->delete();
    }
}
