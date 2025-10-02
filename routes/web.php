<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;

Route::get('/', function () {
    return redirect('/login');
});

// Customer pages
Route::get('/home', function () {
    $products = Product::where('is_available', true)->take(6)->get();
    return view('home', ['products' => $products]);
});
Route::get('/catalog', function () {
    $products = Product::where('is_available', true)->get();
    return view('catalog', ['products' => $products]);
});
Route::get('/product/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $similarProducts = Product::where('id', '!=', $id)
        ->where('is_available', true)
        ->take(4)
        ->get();
    return view('product', ['product' => $product, 'similarProducts' => $similarProducts]);
});
Route::view('/cart', 'cart');
Route::view('/checkout', 'checkout');
Route::view('/about', 'about');
Route::view('/faq', 'faq');

// Auth pages
Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', function (Request $request) {
    // Trim all inputs to remove trailing spaces
    $request->merge([
        'name' => trim($request->input('name')),
        'email' => trim($request->input('email')),
        'password' => $request->input('password'),
        'password_confirmation' => $request->input('password_confirmation'),
    ]);

    $request->validate([
        'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|min:2',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
        'password_confirmation' => 'required|same:password',
    ], [
        'name.required' => 'Name is required',
        'name.regex' => 'Name must contain only letters and spaces',
        'name.min' => 'Name must be at least 2 characters long',
        'email.required' => 'Email is required',
        'email.email' => 'Please enter a valid email address',
        'email.unique' => 'This email is already registered',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters long',
        'password.regex' => 'Password must contain letters, numbers, and special characters',
        'password_confirmation.required' => 'Please confirm your password',
        'password_confirmation.same' => 'Password confirmation does not match',
    ]);

    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'role' => 'user',
    ]);

    return redirect('/login')->with('status', 'Account created successfully! Please log in.');
});
Route::get('/login', function () {
    return view('auth.login');
});
Route::post('/login', function (Request $request) {
    // Trim all inputs to remove trailing spaces
    $request->merge([
        'email' => trim($request->input('email')),
        'password' => $request->input('password'),
    ]);

    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ], [
        'email.required' => 'Email is required',
        'email.email' => 'Please enter a valid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters long',
    ]);

    $email = $request->input('email');
    $password = $request->input('password');
    $remember = $request->has('remember');

    $user = User::where('email', $email)->first();
    if (!$user || !Hash::check($password, $user->password)) {
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    $request->session()->put('auth.user_id', $user->id);
    $request->session()->put('auth.email', $user->email);
    $request->session()->put('auth.name', $user->name);
    $request->session()->put('auth.role', $user->role);
    
    // Handle Remember Me functionality
    if ($remember) {
        $request->session()->put('auth.remember', true);
        // Set session lifetime to 30 days for remember me
        $request->session()->put('auth.remember_token', Str::random(60));
    }
    
    return redirect($user->role === 'admin' ? '/admin' : '/home');
});
Route::get('/logout', function (Request $request) {
    $request->session()->invalidate();
    return redirect('/login');
});

// Password Recovery Flow
Route::get('/recover/initiate', function () {
    return view('auth.recover.initiate');
});

Route::post('/recover/initiate', function (Request $request) {
    // Trim all inputs to remove trailing spaces
    $request->merge([
        'email' => trim($request->input('email')),
    ]);

    $email = $request->input('email');
    if ($email === '') {
        return back()->withErrors(['email' => 'Please enter your email address'])->withInput();
    }

    $user = User::where('email', $email)->first();
    if (!$user) {
        return back()->withErrors(['email' => "We're sorry. We weren't able to identify you given the information provided."])->withInput();
    }

    $ipAddress = $request->ip();
    
    // Check rate limiting
    if (\App\Models\VerificationCode::isRateLimited($email, $ipAddress)) {
        return back()->withErrors(['email' => 'Too many password reset requests. Please wait before trying again.'])->withInput();
    }

    // Clean up old codes
    \App\Models\VerificationCode::cleanup();

    // Get an available verification code
    $verificationCode = \App\Models\VerificationCode::getAvailableCode($email, $ipAddress);
    
    try {
        Mail::to($email)->send(new \App\Mail\VerificationCodeMail($verificationCode->code, $email));
        
        // In development mode, also log the code for easy testing
        if (config('app.debug')) {
            \Log::info("Verification code for {$email}: {$verificationCode->code}");
        }
    } catch (\Throwable $e) {
        // Log the error but don't show it to user
        \Log::error('Failed to send verification email: ' . $e->getMessage());
        return back()->withErrors(['email' => 'Failed to send verification email. Please try again.'])->withInput();
    }

    return redirect('/recover/code')->with('email', $email);
});

Route::get('/recover/code', function (Request $request) {
    $email = $request->session()->get('recover.email') ?? 
             $request->session()->get('email') ?? 
             $request->get('email');
    if (!$email) {
        return redirect('/recover/initiate');
    }
    // Store email in session for page refreshes
    $request->session()->put('recover.email', $email);
    return view('auth.recover.code', ['email' => $email]);
});

Route::post('/recover/code', function (Request $request) {
    $email = $request->input('email');
    $code = $request->input('code');
    
    if (!$email || !$code) {
        return back()->withErrors(['code' => "Please enter a valid verification code."])->withInput();
    }

    $ipAddress = $request->ip();
    
    // Verify the code using the enhanced system
    $verificationResult = \App\Models\VerificationCode::verifyCode($email, $code, $ipAddress);
    
    if (!$verificationResult['success']) {
        return back()->withErrors(['code' => $verificationResult['message']])->withInput();
    }

    // Code is valid, mark verification as complete and proceed to reset
    $request->session()->put('recover.verified', true);
    $request->session()->put('recover.verified_email', $email);
    return redirect('/recover/reset')->with('email', $email);
});

Route::get('/recover/reset', function (Request $request) {
    // Check if user has completed code verification
    if (!$request->session()->get('recover.verified')) {
        return redirect('/recover/initiate');
    }
    
    $email = $request->session()->get('recover.verified_email') ?? 
             $request->session()->get('email') ?? 
             $request->get('email');
    
    if (!$email) {
        return redirect('/recover/initiate');
    }
    
    // Store email in session for page refreshes
    $request->session()->put('recover.reset_email', $email);
    return view('auth.recover.reset', ['email' => $email]);
});

Route::post('/recover/reset', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $email = $request->input('email');
    $user = User::where('email', $email)->first();
    
    if (!$user) {
        return back()->withErrors(['email' => "We're sorry. We weren't able to identify you given the information provided."])->withInput();
    }

    $user->password = Hash::make((string) $request->input('password'));
    $user->save();

    // Clear any recovery codes for this email
    \App\Models\VerificationCode::where('email', $email)->delete();

    // Clear recovery session data
    $request->session()->forget(['recover.verified', 'recover.verified_email', 'recover.email', 'recover.reset_email']);

    return redirect('/login')->with('status', 'Your password has been reset successfully. Please sign in with your new credentials.');
});

Route::post('/recover/resend', function (Request $request) {
    $email = $request->input('email') ?? $request->session()->get('recover.email');
    if (!$email) {
        return redirect('/recover/initiate');
    }

    $user = User::where('email', $email)->first();
    if (!$user) {
        return back()->withErrors(['code' => "We're sorry. We weren't able to identify you given the information provided."])->withInput();
    }

    $ipAddress = $request->ip();
    
    // Check rate limiting
    if (\App\Models\VerificationCode::isRateLimited($email, $ipAddress)) {
        return back()->withErrors(['code' => 'Too many password reset requests. Please wait before trying again.'])->withInput();
    }

    // Check if there's already a valid code (prevent spam)
    if (\App\Models\VerificationCode::hasValidCode($email)) {
        $currentCode = \App\Models\VerificationCode::getCurrentCode($email);
        $timeLeft = $currentCode->expires_at->diffInSeconds(now());
        if ($timeLeft > 300) { // 5 minutes
            return back()->withErrors(['code' => "Please wait before requesting a new code. Your current code is still valid."])->withInput();
        }
    }

    // Get a new verification code
    $verificationCode = \App\Models\VerificationCode::getAvailableCode($email, $ipAddress);
    
    try {
        Mail::to($email)->send(new \App\Mail\VerificationCodeMail($verificationCode->code, $email));
        
        // In development mode, also log the code for easy testing
        if (config('app.debug')) {
            \Log::info("Resend verification code for {$email}: {$verificationCode->code}");
        }
    } catch (\Throwable $e) {
        // Log the error but don't show it to user
        \Log::error('Failed to send verification email: ' . $e->getMessage());
        return back()->withErrors(['code' => 'Failed to send verification email. Please try again.'])->withInput();
    }

    return back()->with('status', 'A new verification code has been sent to your email.');
});

// Debug route to check verification codes (only in debug mode)
if (config('app.debug')) {
    Route::get('/debug/verification-code/{email}', function ($email) {
        $code = \App\Models\VerificationCode::where('email', $email)
                                           ->where('used', false)
                                           ->where('expires_at', '>', now())
                                           ->first();
        
        if ($code) {
            return response()->json([
                'email' => $email,
                'code' => $code->code,
                'expires_at' => $code->expires_at->format('Y-m-d H:i:s'),
                'time_left' => $code->expires_at->diffInSeconds(now()) . ' seconds'
            ]);
        }
        
        return response()->json(['error' => 'No valid verification code found for this email']);
    });
}

// Profile Management
Route::get('/profile', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }
    $user = User::find($request->session()->get('auth.user_id'));
    return view('profile', ['user' => $user]);
});

// Orders Management
Route::get('/orders', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }
    
    $userId = $request->session()->get('auth.user_id');
    $orders = \App\Models\Order::with('items.product')
                              ->where('user_id', $userId)
                              ->orderBy('created_at', 'desc')
                              ->get();
    
    return view('orders', ['orders' => $orders]);
});

Route::post('/profile/update', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }
    
    // Trim all inputs to remove trailing spaces
    $request->merge([
        'name' => trim($request->input('name')),
        'email' => trim($request->input('email')),
    ]);
    
    $request->validate([
        'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/|min:2',
        'email' => 'required|email|max:255',
    ], [
        'name.required' => 'Name is required',
        'name.regex' => 'Name must contain only letters and spaces',
        'name.min' => 'Name must be at least 2 characters long',
        'email.required' => 'Email is required',
        'email.email' => 'Please enter a valid email address',
    ]);
    
    $user = User::find($request->session()->get('auth.user_id'));
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->save();
    
    // Update session
    $request->session()->put('auth.name', $user->name);
    $request->session()->put('auth.email', $user->email);
    
    return back()->with('status', 'Profile updated successfully!');
});

Route::post('/profile/delete', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }
    
    $request->validate([
        'password' => 'required',
    ]);
    
    $user = User::find($request->session()->get('auth.user_id'));
    
    if (!Hash::check($request->input('password'), $user->password)) {
        return back()->withErrors(['password' => 'Incorrect password']);
    }
    
    $user->delete();
    $request->session()->invalidate();
    
    return redirect('/login')->with('status', 'Your account has been deleted successfully.');
});

// Contact
Route::view('/contact', 'contact');
Route::post('/contact', function () {
    return redirect('/success');
});

// Admin pages
Route::prefix('admin')->group(function () {
    Route::get('/', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $userCount = User::count();
        $productCount = Product::count();
        return view('admin.dashboard', ['userCount' => $userCount, 'productCount' => $productCount]);
    });
    
    // Products
    Route::get('/products', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products', ['products' => $products]);
    });
    
    Route::get('/products/create', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        return view('admin.products.create');
    });
    
    Route::post('/products', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'image' => 'nullable|url',
        ]);
        
        Product::create($request->all());
        
        return redirect('/admin/products')->with('status', 'Product created successfully!');
    });
    
    Route::get('/products/{id}/edit', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product]);
    });
    
    Route::put('/products/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'image' => 'nullable|url',
        ]);
        
        $product = Product::findOrFail($id);
        $product->update($request->all());
        
        return redirect('/admin/products')->with('status', 'Product updated successfully!');
    });
    
    Route::delete('/products/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect('/admin/products')->with('status', 'Product deleted successfully!');
    });
    
    // Users
    Route::get('/users', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', ['users' => $users]);
    });
    
    Route::delete('/users/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $user = User::findOrFail($id);
        $user->delete();
        
        return redirect('/admin/users')->with('status', 'User deleted successfully!');
    });
    
    // Orders
    Route::get('/orders', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        return view('admin.orders');
    });
});

// Email change verification routes
Route::post('/profile/change-email/initiate', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }

    // Trim all inputs to remove trailing spaces
    $request->merge([
        'new_email' => trim($request->input('new_email')),
    ]);

    $request->validate([
        'new_email' => 'required|email|max:255|different:current_email',
    ], [
        'new_email.required' => 'New email is required',
        'new_email.email' => 'Please enter a valid email address',
        'new_email.different' => 'New email must be different from current email',
    ]);

    $newEmail = $request->input('new_email');
    $currentEmail = $request->session()->get('auth.email');
    $ipAddress = $request->ip();

    // Check if email already exists
    $existingUser = \App\Models\User::where('email', $newEmail)->first();
    if ($existingUser) {
        return back()->withErrors(['new_email' => 'This email is already registered with another account.'])->withInput();
    }

    // Check rate limiting
    if (\App\Models\VerificationCode::isRateLimited($newEmail, $ipAddress)) {
        return back()->withErrors(['new_email' => 'Too many email change requests. Please wait before trying again.'])->withInput();
    }

    // Clean up old codes
    \App\Models\VerificationCode::cleanup();

    // Get an available verification code
    $verificationCode = \App\Models\VerificationCode::getAvailableCode($newEmail, $ipAddress);
    
    try {
        Mail::to($newEmail)->send(new \App\Mail\VerificationCodeMail($verificationCode->code, $newEmail));
        return back()->with('success', 'Verification code sent to your new email address.');
    } catch (\Throwable $e) {
        \Log::error('Failed to send email change verification: ' . $e->getMessage());
        return back()->withErrors(['new_email' => 'Failed to send verification email. Please try again.'])->withInput();
    }
});

Route::post('/profile/change-email/verify', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }

    $request->validate([
        'new_email' => 'required|email|max:255',
        'verification_code' => 'required|string|size:6',
    ]);

    $newEmail = $request->input('new_email');
    $code = $request->input('verification_code');
    $ipAddress = $request->ip();

    // Verify the code using the enhanced system
    $verificationResult = \App\Models\VerificationCode::verifyCode($newEmail, $code, $ipAddress);
    
    if (!$verificationResult['success']) {
        return back()->withErrors(['verification_code' => $verificationResult['message']])->withInput();
    }

    // Update user email
    $userId = $request->session()->get('auth.user_id');
    $user = \App\Models\User::find($userId);
    if ($user) {
        $user->update(['email' => $newEmail]);
        
        // Update session
        $request->session()->put('auth.email', $newEmail);
        
        return back()->with('success', 'Email address updated successfully!');
    }

    return back()->withErrors(['verification_code' => 'Failed to update email address. Please try again.'])->withInput();
});

// Cart routes
Route::post('/cart/add', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return response()->json(['success' => false, 'message' => 'Please log in to add items to cart']);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $userId = $request->session()->get('auth.user_id');
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    // Get product details
    $product = \App\Models\Product::find($productId);
    if (!$product || !$product->is_available) {
        return response()->json(['success' => false, 'message' => 'Product not available']);
    }

    // Check if quantity is available
    if ($quantity > $product->quantity) {
        return response()->json(['success' => false, 'message' => 'Not enough stock available']);
    }

    // Add to cart
    \App\Models\Cart::addToCart($userId, $productId, $quantity, $product->price);

    // Get updated cart count
    $cartCount = \App\Models\Cart::where('user_id', $userId)->sum('quantity');

    return response()->json(['success' => true, 'cart_count' => $cartCount]);
});

Route::get('/cart', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }

    $userId = $request->session()->get('auth.user_id');
    $cartItems = \App\Models\Cart::getCartItems($userId);

    return view('cart', ['cartItems' => $cartItems]);
});

Route::get('/cart/count', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return response()->json(['success' => false, 'count' => 0]);
    }

    $userId = $request->session()->get('auth.user_id');
    $count = \App\Models\Cart::where('user_id', $userId)->sum('quantity');

    return response()->json(['success' => true, 'count' => $count]);
});

Route::post('/cart/remove', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return response()->json(['success' => false, 'message' => 'Please log in']);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id'
    ]);

    $userId = $request->session()->get('auth.user_id');
    $productId = $request->input('product_id');

    \App\Models\Cart::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->delete();

    $cartCount = \App\Models\Cart::where('user_id', $userId)->sum('quantity');

    return response()->json(['success' => true, 'cart_count' => $cartCount]);
});

Route::post('/cart/update', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return response()->json(['success' => false, 'message' => 'Please log in']);
    }

    $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $userId = $request->session()->get('auth.user_id');
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity');

    $cartItem = \App\Models\Cart::where('user_id', $userId)
                               ->where('product_id', $productId)
                               ->first();

    if ($cartItem) {
        $cartItem->quantity = $quantity;
        $cartItem->save();
    }

    $cartCount = \App\Models\Cart::where('user_id', $userId)->sum('quantity');

    return response()->json(['success' => true, 'cart_count' => $cartCount]);
});

// Checkout route
Route::post('/checkout', function (Request $request) {
    if (!$request->session()->get('auth.user_id')) {
        return redirect('/login');
    }

    $request->validate([
        'shipping_address' => 'required|string|max:255',
        'billing_address' => 'required|string|max:255'
    ]);

    $userId = $request->session()->get('auth.user_id');
    $shippingAddress = $request->input('shipping_address');
    $billingAddress = $request->input('billing_address');

    $order = \App\Models\Order::createFromCart($userId, $shippingAddress, $billingAddress);

    if ($order) {
        return redirect('/orders')->with('success', 'Order placed successfully!');
    } else {
        return redirect('/cart')->with('error', 'Your cart is empty');
    }
});

// Shared
Route::view('/success', 'success');
Route::view('/failure', 'failure');
