<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Style Haven</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #e74c3c;
            margin: 0;
            font-size: 28px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .order-info h2 {
            color: #333;
            margin-top: 0;
            font-size: 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }
        .info-label {
            font-weight: bold;
            color: #555;
        }
        .info-value {
            color: #333;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #555;
        }
        .items-table tr:hover {
            background-color: #f5f5f5;
        }
        .total-section {
            background-color: #e74c3c;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: bold;
        }
        .shipping-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .shipping-info h3 {
            color: #333;
            margin-top: 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        .thank-you {
            text-align: center;
            font-size: 18px;
            color: #e74c3c;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Style Haven</h1>
            <p>Order Confirmation</p>
        </div>

        <div class="thank-you">
            <h2>Thank you for your order, {{ $user->name }}!</h2>
            <p>Your order has been successfully placed and is being processed.</p>
        </div>

        <div class="order-info">
            <h2>Order Details</h2>
            <div class="info-row">
                <span class="info-label">Order Number:</span>
                <span class="info-value">#{{ $order->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Order Date:</span>
                <span class="info-value">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method:</span>
                <span class="info-value">Cash on Delivery</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">Processing</span>
            </div>
        </div>

        <div class="shipping-info">
            <h3>Shipping Information</h3>
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $shippingDetails['name'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $shippingDetails['email'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $shippingDetails['phone'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Address:</span>
                <span class="info-value">{{ $shippingDetails['address'] }}, {{ $shippingDetails['city'] }}, {{ $shippingDetails['postal_code'] }}, {{ $shippingDetails['country'] }}</span>
            </div>
        </div>

        <h3>Order Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>${{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>Free</span>
            </div>
            <div class="total-row">
                <span>Tax:</span>
                <span>$0.00</span>
            </div>
            <div class="total-row" style="border-top: 1px solid rgba(255,255,255,0.3); padding-top: 10px; margin-top: 10px;">
                <span>Total:</span>
                <span>${{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing Style Haven!</p>
            <p>If you have any questions about your order, please contact us.</p>
            <p>This email was sent to {{ $user->email }}</p>
        </div>
    </div>
</body>
</html>
