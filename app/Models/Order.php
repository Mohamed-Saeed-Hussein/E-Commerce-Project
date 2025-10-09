<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'billing_address',
        'phone',
        'postal_code',
        'city',
        'country',
        'billing_phone',
        'billing_postal_code',
        'billing_city',
        'billing_country'
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

    /**
     * Get formatted total amount.
     */
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    /**
     * Scope to get orders by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get orders by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public static function createFromCart($userId, $shippingAddress, $billingAddress, $shippingDetails = null, $billingDetails = null)
    {
        $cartItems = Cart::getCartItems($userId);
        
        if ($cartItems->isEmpty()) {
            return null;
        }

        // Calculate total amount
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $orderData = [
            'user_id' => $userId,
            'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'shipping_address' => $shippingAddress,
            'billing_address' => $billingAddress
        ];

        // Add detailed shipping information if provided
        if ($shippingDetails) {
            $orderData['phone'] = $shippingDetails['phone'] ?? null;
            $orderData['postal_code'] = $shippingDetails['postal_code'] ?? null;
            $orderData['city'] = $shippingDetails['city'] ?? null;
            $orderData['country'] = $shippingDetails['country'] ?? null;
        }

        // Add detailed billing information if provided
        if ($billingDetails) {
            $orderData['billing_phone'] = $billingDetails['phone'] ?? null;
            $orderData['billing_postal_code'] = $billingDetails['postal_code'] ?? null;
            $orderData['billing_city'] = $billingDetails['city'] ?? null;
            $orderData['billing_country'] = $billingDetails['country'] ?? null;
        }

        // Use database transaction to ensure data consistency
        return DB::transaction(function () use ($orderData, $cartItems) {
            $order = self::create($orderData);

            foreach ($cartItems as $cartItem) {
                // Double-check product availability before creating order item
                $product = Product::find($cartItem->product_id);
                if (!$product || !$product->is_available || $cartItem->quantity > $product->quantity) {
                    throw new \Exception("Product {$cartItem->product_id} is no longer available or insufficient stock");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price
                ]);
                
                // Reduce stock atomically
                $product->reduceStock($cartItem->quantity);
            }

            // Clear the cart only after successful order creation
            Cart::clearCart($orderData['user_id']);

            return $order;
        });
    }

    /**
     * Update order status and handle stock management
     */
    public function updateStatus($newStatus)
    {
        $oldStatus = $this->status;
        
        // Validate status transition
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($newStatus, $validStatuses)) {
            throw new \InvalidArgumentException("Invalid order status: {$newStatus}");
        }

        // Prevent invalid status transitions
        if ($oldStatus === 'delivered' && $newStatus !== 'delivered') {
            throw new \InvalidArgumentException("Cannot change status of delivered order");
        }

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

        // Log status change
        \Log::info('Order status updated', [
            'order_id' => $this->id,
            'order_number' => $this->order_number,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'user_id' => $this->user_id
        ]);
    }

    /**
     * Restore stock for cancelled orders
     */
    public function restoreStock()
    {
        foreach ($this->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->restoreStock($item->quantity);
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
                $product->reduceStock($item->quantity);
            }
        }
    }

    /**
     * Scope to get orders for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
