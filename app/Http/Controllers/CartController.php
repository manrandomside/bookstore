<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('book')->get();
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function add(Request $request, Book $book)
    {
        if ($book->isOutOfStock()) {
            return redirect()->back()->with('error', 'Buku tidak tersedia.');
        }

        $user = Auth::user();
        $cartItem = $user->cartItems()->where('book_id', $book->id)->first();

        if ($cartItem) {
            $cartItem->incrementQuantity($request->quantity ?? 1);
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'book_id' => $book->id,
                'quantity' => $request->quantity ?? 1,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->user_id != Auth::id()) {
            abort(403);
        }

        $quantity = $request->quantity ?? 1;

        if ($quantity <= 0) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Buku dihapus dari keranjang.');
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