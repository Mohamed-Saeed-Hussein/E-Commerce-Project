<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MessageController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Home and product routes
Route::get('/home', [HomeController::class, 'index']);
Route::get('/catalog', [ProductController::class, 'catalog']);
Route::get('/product/{id}', [ProductController::class, 'show']);

// Static pages
Route::get('/checkout', [OrderController::class, 'showCheckout'])->middleware('auth.session');
Route::view('/about', 'about');
Route::view('/faq', 'faq');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:20,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth.session');

// Profile Management
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth.session');
Route::post('/profile/update', [ProfileController::class, 'update'])->middleware('auth.session');

// Orders Management
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth.session');
Route::post('/checkout', [OrderController::class, 'checkout'])->middleware('auth.session');

// Cart routes
Route::middleware('auth.session')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/cart/count', [CartController::class, 'count']);
    Route::post('/cart/add', [CartController::class, 'add'])->middleware('throttle:30,1');
    Route::post('/cart/remove', [CartController::class, 'remove'])->middleware('throttle:60,1');
    Route::post('/cart/update', [CartController::class, 'update'])->middleware('throttle:60,1');
});

// Contact
Route::get('/contact', [ContactController::class, 'show'])->middleware('auth.session');
Route::post('/contact', [ContactController::class, 'store'])->middleware(['auth.session','throttle:20,1']);

// Admin routes
Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard']);
    
    // Products
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::get('/products/create', [AdminProductController::class, 'create']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit']);
    Route::put('/products/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);
    Route::get('/import-products', [AdminProductController::class, 'importProducts']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::get('/import-category-images', [CategoryController::class, 'importCategoryImages']);

    // Users
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index']);
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);

    // Messages
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
});

// Shared (removed success/failure pages)