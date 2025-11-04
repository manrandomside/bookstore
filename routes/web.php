<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $bestSellerBooks = \App\Models\Book::where('is_active', 1)
        ->orderBy('created_at', 'desc')
        ->get();
    return view('pages.home', compact('bestSellerBooks'));
})->name('home');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/about', [BookController::class, 'about'])->name('about');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear-all', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/paid', [OrderController::class, 'markAsPaid'])->name('orders.paid');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $totalUsers = \App\Models\User::where('role', 'user')->count();
        $totalBooks = \App\Models\Book::where('is_active', true)->count();
        $totalOrders = \App\Models\Order::count();
        $pendingMessages = \App\Models\Message::whereNull('admin_reply')->count();
        $ordersThisMonth = \App\Models\Order::whereMonth('created_at', now()->month)->count();
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_price');
        $availableStock = \App\Models\Book::where('stock', '>', 0)->count();
        $lowStock = \App\Models\Book::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $recentOrders = \App\Models\Order::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalBooks', 'totalOrders', 'pendingMessages', 'ordersThisMonth', 'totalRevenue', 'availableStock', 'lowStock', 'recentOrders'));
    })->name('admin.dashboard');

    Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);
    Route::resource('books', AdminBookController::class, ['as' => 'admin']);
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);
    Route::put('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])->name('admin.users.toggle');
    
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('admin.orders.payment');
    Route::put('/orders/{order}/delivery', [AdminOrderController::class, 'updateDeliveryStatus'])->name('admin.orders.delivery');
    
    Route::get('/messages', [MessageController::class, 'indexAdmin'])->name('admin.messages.index');
    Route::get('/messages/{message}', [MessageController::class, 'showAdmin'])->name('admin.messages.show');
    Route::post('/messages/{message}/reply', [MessageController::class, 'replyAdmin'])->name('admin.messages.reply');
});