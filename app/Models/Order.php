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
            
            // Reduce stock when order is created
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->quantity -= $cartItem->quantity;
                $product->save();
            }
        }

        // Clear the cart
        Cart::clearCart($userId);

        return $order;
    }

    /**
     * Update order status and handle stock management
     */
    public function updateStatus($newStatus)
    {
        $oldStatus = $this->status;
        $this->status = $newStatus;
        $this->save();

        // Handle stock management based on status changes
        if ($oldStatus !== $newStatus) {
            if ($newStatus === 'cancelled' && in_array($oldStatus, ['pending', 'processing', 'shipped'])) {
                // Restore stock when order is cancelled
                $this->restoreStock();
            } elseif (in_array($newStatus, ['pending', 'processing', 'shipped', 'delivered']) && $oldStatus === 'cancelled') {
                // Reduce stock again if order is reactivated from cancelled
                $this->reduceStock();
            }
        }
    }

    /**
     * Restore stock for cancelled orders
     */
    public function restoreStock()
    {
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();
            }
        }
    }

    /**
     * Reduce stock for orders
     */
    public function reduceStock()
    {
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->quantity -= $item->quantity;
                $product->save();
            }
        }
    }
}
