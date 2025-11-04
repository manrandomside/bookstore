@extends('layouts.app')

@section('title', 'Pesanan Saya - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-list"></i> Pesanan Saya
        </h2>
        <p class="text-muted">Kelola dan pantau status pesanan Anda</p>
    </div>

    @if($orders->count() > 0)
        <div class="row">
            <!-- Filter Tabs -->
            <div class="col-12 mb-4">
                <ul class="nav nav-pills" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ !request('status') ? 'active' : '' }}" 
                           href="{{ route('orders.index') }}" 
                           style="{{ !request('status') ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                            <i class="fas fa-inbox"></i> Semua
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
                           href="{{ route('orders.index', ['status' => 'pending']) }}"
                           style="{{ request('status') == 'pending' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                            <i class="fas fa-hourglass-half"></i> Pending
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'paid' ? 'active' : '' }}" 
                           href="{{ route('orders.index', ['status' => 'paid']) }}"
                           style="{{ request('status') == 'paid' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                            <i class="fas fa-check-circle"></i> Dibayar
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
                    <li class="nav-item">
                        <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
                           href="{{ route('orders.index', ['status' => 'cancelled']) }}"
                           style="{{ request('status') == 'cancelled' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                            <i class="fas fa-times-circle"></i> Batal
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
                                    @if($order->payment_status === 'pending')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-hourglass-half"></i> Menunggu Pembayaran
                                        </span>
                                    @elseif($order->payment_status === 'paid')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Sudah Dibayar
                                        </span>
                                    @elseif($order->payment_status === 'cancelled')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times-circle"></i> Dibatalkan
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
                                                <small class="text-muted">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</small>
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
                                        @if($order->shipping_status === 'pending')
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-hourglass-start"></i> Diproses
                                            </span>
                                        @elseif($order->shipping_status === 'shipped')
                                            <span class="badge bg-info">
                                                <i class="fas fa-truck"></i> Dalam Pengiriman
                                            </span>
                                        @elseif($order->shipping_status === 'delivered')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Terima
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <small class="text-muted fw-bold d-block mb-2">Total Pesanan:</small>
                                    <h5 style="color: #335c67; margin: 0;">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer" style="background-color: #f8f9fa; border-top: 1px solid #ddd;">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> Klik untuk melihat detail
                                </small>
                                <div>
                                    @if($order->payment_status === 'pending')
                                        <form action="{{ route('orders.paid', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success me-2">
                                                <i class="fas fa-money-bill-wave"></i> Bayar
                                            </button>
                                        </form>
                                    @endif

                                    @if($order->payment_status === 'pending' || $order->payment_status === 'paid')
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger me-2" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                <i class="fas fa-times"></i> Batalkan
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
                @empty
                    <div class="alert alert-info text-center" role="alert">
                        <i class="fas fa-inbox"></i>
                        <h5 class="mt-2">Tidak ada pesanan</h5>
                        <p class="text-muted mb-0">Mulai belanja sekarang untuk membuat pesanan pertama Anda.</p>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4 mb-5">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada Pesanan</h3>
                        <p class="text-muted mb-4">
                            Anda belum melakukan pembelian. Mulai belanja sekarang!
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-shopping-bag"></i> Jelajahi Koleksi Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    .nav-pills .nav-link {
        border-radius: 8px;
        margin-right: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background-color: #335c67 !important;
        color: white !important;
    }

    .badge {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
</style>
@endsection