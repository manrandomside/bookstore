@extends('layouts.app')

@section('title', 'Dashboard Admin - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #2a4a54;">
                <i class="fas fa-chart-line"></i> Dashboard Admin
            </h2>
            <p class="text-muted">Selamat datang kembali, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Total Pengguna</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ $totalUsers }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Total Buku</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ $totalBooks }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Total Pesanan</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ $totalOrders }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Pesan Menunggu</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ $pendingMessages }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag"></i> Ringkasan Penjualan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <p class="text-muted small mb-2">Pesanan Bulan Ini</p>
                            <h4 class="fw-bold" style="color: #335c67;">{{ $ordersThisMonth }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-2">Total Terjual</p>
                            <h4 class="fw-bold" style="color: #335c67;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-box"></i> Status Stok
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 border-end">
                            <p class="text-muted small mb-2">Stok Tersedia</p>
                            <h4 class="fw-bold" style="color: #335c67;">{{ $availableStock }}</h4>
                        </div>
                        <div class="col-6">
                            <p class="text-muted small mb-2">Stok Rendah</p>
                            <h4 class="fw-bold text-warning">{{ $lowStock }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary w-100" style="border-color: #335c67; color: #335c67;">
                                <i class="fas fa-plus"></i> Tambah Kategori
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.books.create') }}" class="btn btn-outline-primary w-100" style="border-color: #335c67; color: #335c67;">
                                <i class="fas fa-plus"></i> Tambah Buku
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100" style="border-color: #335c67; color: #335c67;">
                                <i class="fas fa-users"></i> Kelola User
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-primary w-100" style="border-color: #335c67; color: #335c67;">
                                <i class="fas fa-envelope"></i> Lihat Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-history"></i> Pesanan Terbaru
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No. Pesanan</th>
                                        <th style="color: #2a4a54;">Pembeli</th>
                                        <th class="text-center" style="color: #2a4a54;">Total</th>
                                        <th class="text-center" style="color: #2a4a54;">Status Pembayaran</th>
                                        <th class="text-center" style="color: #2a4a54;">Status Pengiriman</th>
                                        <th class="text-center" style="color: #2a4a54;">Tanggal</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
                                                {{ $order->user->name }}
                                            </td>
                                            <td class="text-center">
                                                <strong style="color: #335c67;">
                                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                @if($order->payment_status === 'unpaid')
                                                    <span class="badge bg-warning">Belum Dibayar</span>
                                                @elseif($order->payment_status === 'paid')
                                                    <span class="badge bg-success">Dibayar</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($order->delivery_status === 'pending')
                                                    <span class="badge bg-secondary">Diproses</span>
                                                @elseif($order->delivery_status === 'shipped')
                                                    <span class="badge bg-info">Dikirim</span>
                                                @elseif($order->delivery_status === 'delivered')
                                                    <span class="badge bg-success">Terima</span>
                                                @endif
                                            </td>
                                            <td class="text-center text-muted">
                                                <small>{{ $order->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm" style="background-color: #335c67; color: white;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info m-3" role="alert">
                            <i class="fas fa-info-circle"></i> Belum ada pesanan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        border: none;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }
</style>
@endsection