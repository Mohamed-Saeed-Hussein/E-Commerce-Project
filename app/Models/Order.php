<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function createFromCart($userId, $shippingAddress, $billingAddress)
    {
        $cartItems = Cart::getCartItems($userId);
        
        if ($cartItems->isEmpty()) {
            return null;
        }

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $order = self::create([
            'user_id' => $userId,
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price
            ]);
        }

        // Clear the cart
        Cart::clearCart($userId);

        return $order;
    }
}
