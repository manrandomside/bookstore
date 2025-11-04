@extends('layouts.app')

@section('title', 'Dashboard - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Page Title -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="fw-bold" style="color: #2a4a54;">
                <i class="fas fa-home"></i> Dashboard
            </h2>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Total Pesanan</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ auth()->user()->orders()->count() }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Total Belanja</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">Rp {{ number_format(auth()->user()->orders()->where('payment_status', 'paid')->sum('total_price'), 0, ',', '.') }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2">Pesan Dikirim</p>
                            <h3 class="fw-bold" style="color: #335c67; margin: 0;">{{ auth()->user()->orders()->where('delivery_status', 'delivered')->count() }}</h3>
                        </div>
                        <div style="font-size: 2.5rem; color: #335c67; opacity: 0.2;">
                            <i class="fas fa-box"></i>
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
                            <a href="{{ route('books.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-book"></i> Jelajahi Buku
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-receipt"></i> Lihat Pesanan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('messages.index') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-envelope"></i> Pesan Saya
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('about') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-info-circle"></i> Tentang Kami
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
                    @if(auth()->user()->orders()->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No. Pesanan</th>
                                        <th style="color: #2a4a54;">Total</th>
                                        <th class="text-center" style="color: #2a4a54;">Status Pembayaran</th>
                                        <th class="text-center" style="color: #2a4a54;">Status Pengiriman</th>
                                        <th class="text-center" style="color: #2a4a54;">Tanggal</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(auth()->user()->orders()->latest()->limit(5)->get() as $order)
                                        <tr>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $order->order_number }}</strong>
                                            </td>
                                            <td>
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
                            <i class="fas fa-info-circle"></i> Anda belum melakukan pembelian. 
                            <a href="{{ route('books.index') }}" style="color: #335c67; text-decoration: none; font-weight: bold;">
                                Mulai belanja sekarang
                            </a>
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
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }
</style>
@endsection