<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $orderItems = $order->orderItems()->with('book')->get();

        return view('orders.show', compact('order', 'orderItems'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string',
            'payment_method' => 'required|in:transfer,cash',
        ]);

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->getSubtotal();
        });

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'payment_method' => $validated['payment_method'],
            'delivery_status' => 'pending',
            'delivery_address' => $validated['delivery_address'],
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $cartItem->book_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->book->price,
                'subtotal' => $cartItem->getSubtotal(),
            ]);

            $cartItem->book->decrement('stock', $cartItem->quantity);
        }

        $user->cartItems()->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat. Lakukan pembayaran.');
    }

    public function markAsPaid(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        if ($order->isPaid()) {
            return redirect()->back()->with('error', 'Pesanan sudah dibayar.');
        }

        $order->payment_status = 'paid';
        $order->paid_at = now();
        $order->save();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function cancel(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        if ($order->isCancelled()) {
            return redirect()->back()->with('error', 'Pesanan sudah dibatalkan.');
        }

        if ($order->isDelivered()) {
            return redirect()->back()->with('error', 'Pesanan yang sudah dikirim tidak bisa dibatalkan.');
        }

        $order->status = 'cancelled';
        $order->save();

        foreach ($order->orderItems as $item) {
            $item->book->increment('stock', $item->quantity);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}