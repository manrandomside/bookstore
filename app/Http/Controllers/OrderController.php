<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->orders();
        
        if ($request->filled('status')) {
            $status = $request->status;
            if (in_array($status, ['unpaid', 'paid'])) {
                $query->where('payment_status', $status);
            } elseif (in_array($status, ['pending', 'shipped', 'delivered'])) {
                $query->where('delivery_status', $status);
            }
        }

        $orders = $query->latest()->paginate(10);

        return view('user.orders-list', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $orderItems = $order->orderItems()->with('book')->get();

        return view('user.order-detail', compact('order', 'orderItems'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $validated = $request->validate([
            'delivery_address' => 'required|string|min:10',
            'payment_method' => 'required|in:transfer,cash',
        ]);

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_price' => $totalPrice,
            'payment_status' => 'unpaid',
            'delivery_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'delivery_address' => $validated['delivery_address'],
            'paid_at' => null,
        ]);

        foreach ($cartItems as $cartItem) {
            $subtotal = $cartItem->book->price * $cartItem->quantity;
            
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $cartItem->book_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->book->price,
                'subtotal' => $subtotal,
            ]);

            $cartItem->book->decrement('stock', $cartItem->quantity);
        }

        $user->cartItems()->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function markAsPaid(Order $order)
    {
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
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

        if ($order->payment_status === 'paid') {
            return redirect()->back()->with('error', 'Pesanan yang sudah dibayar tidak bisa dibatalkan.');
        }

        if ($order->delivery_status === 'delivered') {
            return redirect()->back()->with('error', 'Pesanan yang sudah diterima tidak bisa dibatalkan.');
        }

        if ($order->delivery_status === 'shipped') {
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