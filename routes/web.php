<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('welcome');
});

// (Email verification routes removed by revert)

// Customer pages
Route::get('/home', function () {
    $products = Product::where('is_available', true)->take(6)->get();
    return view('home', ['products' => $products]);
});
Route::get('/catalog', function () {
    $products = Product::where('is_available', true)->get();
    $categories = Category::orderBy('name')->get();
    return view('catalog', ['products' => $products, 'categories' => $categories]);
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
Route::get('/register', function (Request $request) {
    if ($request->session()->get('auth.user_id')) {
        return redirect('/home');
    }
    return view('auth.register');
});

Route::post('/register', function (Request $request) {
    if ($request->session()->get('auth.user_id')) {
        return redirect('/home');
    }
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

    // Log the user in immediately after registration
    $request->session()->put('auth.user_id', $user->id);
    $request->session()->put('auth.email', $user->email);
    $request->session()->put('auth.name', $user->name);
    $request->session()->put('auth.role', $user->role);

    return redirect('/home');
});
Route::get('/login', function (Request $request) {
    if ($request->session()->get('auth.user_id')) {
        return redirect('/home');
    }
    return view('auth.login');
});
Route::post('/login', function (Request $request) {
    if ($request->session()->get('auth.user_id')) {
        return redirect('/home');
    }
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
        $rememberToken = $user->generateRememberToken();
        
        // Set a remember me cookie that expires in 30 days
        $cookie = cookie('remember_me', $rememberToken, 60 * 24 * 30); // 30 days
        
        // Set session lifetime to 30 days for remember me
        $request->session()->put('auth.remember', true);
        
        return redirect($user->role === 'admin' ? '/admin' : '/home')->withCookie($cookie);
    }

    return redirect($user->role === 'admin' ? '/admin' : '/home');
});
Route::get('/logout', function (Request $request) {
    // Clear remember me token if user is logged in
    if ($request->session()->has('auth.user_id')) {
        $userId = $request->session()->get('auth.user_id');
        $user = User::find($userId);
        if ($user) {
            $user->clearRememberToken();
        }
    }
    
    $request->session()->invalidate();
    
    // Clear the remember me cookie
    $cookie = cookie('remember_me', '', -1);
    
    return redirect('/')->withCookie($cookie);
});

// Password recovery routes removed

// Debug verification route removed

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
Route::post('/contact', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string',
    ]);

    \App\Models\Message::create([
        'user_id' => $request->session()->get('auth.user_id'),
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'subject' => $request->input('subject'),
        'content' => $request->input('message'),
    ]);

    return redirect('/success');
});

// Admin pages
Route::prefix('admin')->group(function () {
    Route::get('/', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = \App\Models\Order::count();
        $revenue = \App\Models\Order::whereIn('status', ['processing','shipped','delivered'])->sum('total_amount');
        $messageCount = \App\Models\Message::count();
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'productCount' => $productCount,
            'orderCount' => $orderCount,
            'revenue' => $revenue,
            'messageCount' => $messageCount,
        ]);
    });
    
    // Products
    Route::get('/products', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products', ['products' => $products]);
    });

    // Categories
    Route::get('/categories', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        return view('admin.categories');
    });

    Route::post('/categories', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        
        Category::create([
            'name' => $request->input('name'),
            'slug' => strtolower(str_replace(' ', '-', $request->input('name'))),
        ]);
        
        return back()->with('status', 'Category added successfully!');
    });

    Route::delete('/categories/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        
        $category = Category::findOrFail($id);
        $category->delete();
        
        return back()->with('status', 'Category deleted successfully!');
    });

    // Bulk import products from public/images/products
    Route::get('/import-products', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');

        $basePath = public_path('images/products');
        if (!File::exists($basePath)) {
            return back()->with('status', 'No products directory found at /public/images/products');
        }

        $imported = 0;
        $updated = 0;

        $imageExtensions = ['jpg','jpeg','png','gif','webp'];

        // Helper to process a single image file
        $processImage = function ($relativeDir, $filename) use (&$imported, &$updated, $imageExtensions) {
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $imageExtensions)) return;

            $categoryName = trim($relativeDir, DIRECTORY_SEPARATOR);
            $categoryName = $categoryName === '' ? null : str_replace(['-', '_'], ' ', $categoryName);

            $categoryId = null;
            if ($categoryName) {
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['slug' => Str::slug($categoryName)]
                );
                $categoryId = $category->id;
            }

            $basename = pathinfo($filename, PATHINFO_FILENAME);
            $productName = ucwords(str_replace(['-', '_'], ' ', $basename));
            $imageUrl = '/images/products' . ($relativeDir ? '/' . trim(str_replace('\\', '/', $relativeDir), '/') : '') . '/' . $filename;

            $existing = Product::where('image', $imageUrl)->first();

            if ($existing) {
                $existing->update([
                    'name' => $existing->name ?: $productName,
                    'category_id' => $categoryId,
                ]);
                $updated++;
            } else {
                Product::create([
                    'name' => $productName,
                    'price' => 0,
                    'description' => 'Imported product',
                    'quantity' => 0,
                    'is_available' => true,
                    'image' => $imageUrl,
                    'category_id' => $categoryId,
                ]);
                $imported++;
            }
        };

        // Walk through subdirectories
        $dirs = File::directories($basePath);
        // Also include base directory as a category-less import
        $dirs = array_merge([$basePath], $dirs);

        foreach ($dirs as $dir) {
            $relativeDir = trim(str_replace($basePath, '', $dir), DIRECTORY_SEPARATOR);
            foreach (File::files($dir) as $file) {
                $processImage($relativeDir, $file->getFilename());
            }
        }

        return back()->with('status', "Imported: {$imported}, Updated: {$updated}");
    });

    // Messages
    Route::get('/messages', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $messages = \App\Models\Message::orderBy('created_at','desc')->get();
        return view('admin.messages', ['messages' => $messages]);
    });
    Route::get('/messages/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $message = \App\Models\Message::findOrFail($id);
        return view('admin.message_show', ['message' => $message]);
    });

    // Import category images from public/images/products/<CategoryName> (first image in each folder)
    Route::get('/import-category-images', function (Request $request) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');

        $basePath = public_path('images/products');
        if (!File::exists($basePath)) {
            return back()->with('status', 'No products directory found at /public/images/products');
        }

        $imageExtensions = ['jpg','jpeg','png','gif','webp'];
        $updated = 0;

        foreach (File::directories($basePath) as $dir) {
            $relative = trim(str_replace($basePath, '', $dir), DIRECTORY_SEPARATOR);
            if ($relative === '') continue;
            $categoryName = str_replace(['-', '_'], ' ', $relative);
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            $files = collect(File::files($dir))
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), $imageExtensions))
                ->values();

            if ($files->count() > 0) {
                $file = $files->first();
                $imageUrl = '/images/products/' . $relative . '/' . $file->getFilename();
                if ($category->image !== $imageUrl) {
                    $category->image = $imageUrl;
                    $category->save();
                    $updated++;
                }
            }
        }

        return back()->with('status', "Category images updated: {$updated}");
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
            'category_id' => 'nullable|exists:categories,id',
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
            'category_id' => 'nullable|exists:categories,id',
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

    Route::post('/users/{id}/role', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $request->validate(['role' => 'required|in:user,admin']);
        $actingUserId = (int) $request->session()->get('auth.user_id');
        $user = User::findOrFail($id);
        if ((int)$user->id === $actingUserId) {
            return back()->withErrors(['role' => 'Edit your own information from My Profile.']);
        }
        if ($user->role === 'admin') {
            return back()->withErrors(['role' => 'You cannot modify roles of admins.']);
        }
        $user->role = $request->input('role');
        $user->save();
        return back()->with('status', 'User role updated.');
    });

    Route::put('/users/{id}', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $actingUserId = (int) $request->session()->get('auth.user_id');
        $user = User::findOrFail($id);
        if ((int)$user->id === $actingUserId) {
            return back()->withErrors(['name' => 'Edit your own information from My Profile.']);
        }
        if ($user->role === 'admin') {
            return back()->withErrors(['name' => 'You cannot modify details of admins.']);
        }
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return back()->with('status', 'User updated.');
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
        $orders = \App\Models\Order::with('user')->orderBy('created_at','desc')->get();
        return view('admin.orders', ['orders' => $orders]);
    });
    Route::post('/orders/{id}/status', function (Request $request, $id) {
        if ($request->session()->get('auth.role') !== 'admin') return redirect('/login');
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order = \App\Models\Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();
        return back()->with('status', 'Order status updated');
    });
});

// Email change verification routes removed

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
