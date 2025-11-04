<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        $orders = $query->latest()->paginate(20);
        $totalOrders = Order::count();
        $unpaidOrders = Order::where('payment_status', 'unpaid')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $pendingDelivery = Order::where('delivery_status', 'pending')->count();
        $shippedOrders = Order::where('delivery_status', 'shipped')->count();

        return view('admin.orders-list', compact('orders', 'totalOrders', 'unpaidOrders', 'paidOrders', 'pendingDelivery', 'shippedOrders'));
    }

    public function show(Order $order)
    {
        $orderItems = $order->orderItems()->with('book')->get();
        return view('admin.order-detail', compact('order', 'orderItems'));
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $order->payment_status = $validated['payment_status'];
        
        if ($validated['payment_status'] === 'paid' && !$order->paid_at) {
            $order->paid_at = now();
        }
        
        $order->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function updateDeliveryStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'delivery_status' => 'required|in:pending,shipped,delivered',
        ]);

        $order->delivery_status = $validated['delivery_status'];
        $order->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}