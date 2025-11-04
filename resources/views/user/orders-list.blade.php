@extends('layouts.app')

@section('title', 'Pesanan Saya - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pesanan Saya</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-shopping-bag"></i> Pesanan Saya
        </h2>
        <p class="text-muted">Kelola dan lacak pesanan Anda</p>
    </div>

    <div class="row">
        <!-- Filter Tabs -->
        <div class="col-12 mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" 
                       href="{{ route('orders.index') }}"
                       style="{{ !request('status') ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-list"></i> Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'unpaid' ? 'active' : '' }}" 
                       href="{{ route('orders.index', ['status' => 'unpaid']) }}"
                       style="{{ request('status') == 'unpaid' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-hourglass-half"></i> Belum Dibayar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'paid' ? 'active' : '' }}" 
                       href="{{ route('orders.index', ['status' => 'paid']) }}"
                       style="{{ request('status') == 'paid' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-check-circle"></i> Sudah Dibayar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}" 
                       href="{{ route('orders.index', ['status' => 'shipped']) }}"
                       style="{{ request('status') == 'shipped' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-truck"></i> Dikirim
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'delivered' ? 'active' : '' }}" 
                       href="{{ route('orders.index', ['status' => 'delivered']) }}"
                       style="{{ request('status') == 'delivered' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-box"></i> Terima
                    </a>
                </li>
            </ul>
        </div>

        <!-- Orders List -->
        <div class="col-12">
            @forelse($orders as $order)
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #335c67;">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h6 class="mb-0" style="color: #2a4a54;">
                                    <i class="fas fa-receipt"></i> Pesanan #{{ $order->order_number }}
                                </h6>
                                <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                @if($order->payment_status === 'unpaid')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-hourglass-half"></i> Belum Dibayar
                                    </span>
                                @elseif($order->payment_status === 'paid')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Sudah Dibayar
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Order Items Preview -->
                        <div class="mb-3">
                            <small class="text-muted fw-bold">Item Pesanan:</small>
                            <div style="max-height: 150px; overflow-y: auto;">
                                @foreach($order->orderItems as $item)
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <div>
                                            <strong style="color: #2a4a54;">{{ $item->book->title }}</strong>
                                            <small class="d-block text-muted">{{ $item->book->author }}</small>
                                        </div>
                                        <div class="text-end">
                                            <small class="d-block">{{ $item->quantity }}x</small>
                                            <small class="text-muted">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Status & Pricing -->
                        <div class="row mb-3 pt-3 border-top">
                            <div class="col-md-6">
                                <small class="text-muted fw-bold">Status Pengiriman:</small>
                                <div class="mt-2">
                                    @if($order->delivery_status === 'pending')
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-hourglass-start"></i> Diproses
                                        </span>
                                    @elseif($order->delivery_status === 'shipped')
                                        <span class="badge bg-info">
                                            <i class="fas fa-truck"></i> Dalam Pengiriman
                                        </span>
                                    @elseif($order->delivery_status === 'delivered')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Terima
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <small class="text-muted fw-bold d-block mb-2">Total Pesanan:</small>
                                <h5 style="color: #335c67; margin: 0;">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>

                        <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #ddd;">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <small class="text-muted mb-2 mb-md-0">
                                    <i class="fas fa-info-circle"></i> Klik detail untuk info lengkap
                                </small>
                                <div>
                                    @if($order->payment_status === 'unpaid')
                                        <form action="{{ route('orders.paid', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success me-2">
                                                <i class="fas fa-money-bill-wave"></i> Bayar
                                            </button>
                                        </form>
                                    @endif

                                    @if($order->status !== 'cancelled')
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger me-2" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                <i class="fas fa-times"></i> Batal
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm" style="background-color: #335c67; color: white;">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #dee2e6; margin-bottom: 20px;"></i>
                        <h5 style="color: #2a4a54;">Belum Ada Pesanan</h5>
                        <p class="text-muted mb-4">Anda belum melakukan pemesanan. Mulai belanja sekarang!</p>
                        <a href="{{ route('books.index') }}" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-book"></i> Jelajahi Buku
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
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

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }

    .nav-pills .nav-link {
        margin-right: 5px;
        border: 1px solid #335c67;
        transition: all 0.3s;
    }

    .nav-pills .nav-link:hover {
        background-color: #335c67;
        color: white !important;
    }
</style>
@endsection