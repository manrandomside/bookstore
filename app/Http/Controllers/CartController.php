<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('book')->get();
        
        $subtotal = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });
        
        $shipping = 25000;
        $total = $subtotal + $shipping;

        return view('user.cart', compact('cartItems', 'subtotal', 'shipping', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if ($book->stock <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia.');
        }

        if (!$book->is_active) {
            return redirect()->back()->with('error', 'Buku tidak dapat ditambahkan.');
        }

        $user = Auth::user();
        $cartItem = $user->cartItems()->where('book_id', $book->id)->first();

        $quantity = (int)($request->quantity ?? 1);

        if ($quantity <= 0) {
            return redirect()->back()->with('error', 'Jumlah tidak valid.');
        }

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            
            if ($newQuantity > $book->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            if ($quantity > $book->stock) {
                return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }

            CartItem::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $quantity = (int)($request->quantity ?? 1);

        if ($quantity <= 0) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Buku dihapus dari keranjang.');
        }

        if ($quantity > $cartItem->book->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok yang tersedia.');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Buku dihapus dari keranjang.');
    }

    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}