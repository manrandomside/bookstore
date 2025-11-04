<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminBookController;
use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books', [BookController::class, 'index'])->name('books.list');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
Route::get('/about', [BookController::class, 'about'])->name('books.about');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear-all', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::put('/orders/{order}/paid', [OrderController::class, 'markAsPaid'])->name('orders.paid');
Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
Route::post('/messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);
    Route::resource('books', AdminBookController::class, ['as' => 'admin']);
    Route::resource('users', AdminUserController::class, ['as' => 'admin']);
    Route::put('/users/{user}/toggle', [AdminUserController::class, 'toggleActive'])->name('admin.users.toggle');
});