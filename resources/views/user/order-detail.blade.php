@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}" style="color: #335c67;">Pesanan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-receipt"></i> Detail Pesanan #{{ $order->order_number }}
        </h2>
        <p class="text-muted">{{ $order->created_at->format('d MMMM Y H:i') }}</p>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- Status Timeline -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks"></i> Status Pesanan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <!-- Payment Status -->
                        <div class="col-md-6 mb-3">
                            <strong style="color: #2a4a54;">Status Pembayaran</strong>
                            <div class="mt-3">
                                @if($order->payment_status === 'unpaid')
                                    <span class="badge bg-warning" style="padding: 10px 15px; font-size: 0.95rem;">
                                        <i class="fas fa-hourglass-half"></i> Belum Dibayar
                                    </span>
                                @elseif($order->payment_status === 'paid')
                                    <span class="badge bg-success" style="padding: 10px 15px; font-size: 0.95rem;">
                                        <i class="fas fa-check-circle"></i> Sudah Dibayar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Shipping Status -->
                        <div class="col-md-6 mb-3">
                            <strong style="color: #2a4a54;">Status Pengiriman</strong>
                            <div class="mt-3">
                                @if($order->delivery_status === 'pending')
                                    <span class="badge bg-secondary" style="padding: 10px 15px; font-size: 0.95rem;">
                                        <i class="fas fa-hourglass-start"></i> Diproses
                                    </span>
                                @elseif($order->delivery_status === 'shipped')
                                    <span class="badge bg-info" style="padding: 10px 15px; font-size: 0.95rem;">
                                        <i class="fas fa-truck"></i> Dalam Pengiriman
                                    </span>
                                @elseif($order->delivery_status === 'delivered')
                                    <span class="badge bg-success" style="padding: 10px 15px; font-size: 0.95rem;">
                                        <i class="fas fa-box"></i> Terima
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Item Pesanan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="color: #2a4a54;">Produk</th>
                                    <th class="text-center" style="color: #2a4a54;">Jumlah</th>
                                    <th class="text-center" style="color: #2a4a54;">Harga Satuan</th>
                                    <th class="text-end" style="color: #2a4a54;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 50px;">
                                                    @php
                                                        $bookImage = strtolower(str_replace(' ', '_', $item->book->title));
                                                        $imagePath = file_exists(public_path("books/{$bookImage}.jpg")) 
                                                            ? "/books/{$bookImage}.jpg" 
                                                            : (file_exists(public_path("books/{$bookImage}.jpeg")) 
                                                                ? "/books/{$bookImage}.jpeg" 
                                                                : null);
                                                    @endphp
                                                    @if($imagePath)
                                                        <img src="{{ $imagePath }}" alt="{{ $item->book->title }}" class="img-fluid" style="border-radius: 4px;">
                                                    @else
                                                        <div style="width: 50px; height: 70px; background-color: #e9ecef; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fas fa-book" style="color: #adb5bd;"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <strong style="color: #2a4a54;">{{ $item->book->title }}</strong>
                                                    <small class="d-block text-muted">{{ $item->book->author }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $item->quantity }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <strong style="color: #335c67;">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td class="text-end">
                                            <strong style="color: #335c67;">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-truck"></i> Informasi Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <strong style="color: #2a4a54;">Alamat Pengiriman</strong>
                            <p class="text-muted mt-2">{{ $order->delivery_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong style="color: #2a4a54;">Metode Pembayaran</strong>
                            <p class="text-muted mt-2">
                                @if($order->payment_method === 'transfer')
                                    <i class="fas fa-bank"></i> Transfer Bank
                                @elseif($order->payment_method === 'cash')
                                    <i class="fas fa-money-bill-wave"></i> Bayar di Tempat
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Ringkasan Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold" style="color: #2a4a54;">Total Pembayaran:</span>
                            <span class="fw-bold" style="color: #335c67; font-size: 1.3rem;">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    @if($order->paid_at)
                        <div class="alert alert-success alert-sm" role="alert">
                            <small>
                                <i class="fas fa-check-circle"></i> Dibayar pada {{ $order->paid_at->format('d M Y H:i') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($order->payment_status === 'unpaid')
                            <form action="{{ route('orders.paid', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success w-100 fw-bold">
                                    <i class="fas fa-money-bill-wave"></i> Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif

                        @if($order->status !== 'cancelled' && $order->delivery_status !== 'delivered')
                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-outline-danger w-100 fw-bold" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary w-100 fw-bold" style="border-color: #335c67; color: #335c67;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted fw-bold">Nomor Pesanan</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $order->order_number }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted fw-bold">Tanggal Pesanan</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted fw-bold">Total Item</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $orderItems->sum('quantity') }} buku</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb {
        background-color: transparent;
        padding: 0.5rem 0;
    }

    .breadcrumb-item a {
        text-decoration: none;
    }

    .card {
        border-radius: 8px;
    }

    .alert-sm {
        padding: 0.5rem 0.75rem;
    }

    .badge {
        padding: 8px 12px;
    }
</style>
@endsection