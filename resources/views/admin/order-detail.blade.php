@extends('layouts.app')

@section('title', 'Detail Pesanan - Bookstoreside')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" style="color: #335c67;">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}" style="color: #335c67;">Pesanan</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-receipt"></i> Detail Pesanan #{{ $order->order_number }}
        </h2>
        <p class="text-muted">Kelola dan validasi pesanan pelanggan</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Informasi Pembeli
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted fw-bold d-block mb-2">Nama</small>
                            <p class="mb-0" style="color: #2a4a54;">{{ $order->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted fw-bold d-block mb-2">Email</small>
                            <p class="mb-0">
                                <a href="mailto:{{ $order->user->email }}" style="color: #335c67; text-decoration: none;">
                                    {{ $order->user->email }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-box-open"></i> Item Pesanan
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th style="color: #2a4a54;">Buku</th>
                                    <th class="text-center" style="color: #2a4a54;">Harga</th>
                                    <th class="text-center" style="color: #2a4a54;">Jumlah</th>
                                    <th class="text-end" style="color: #2a4a54;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderItems as $item)
                                    <tr>
                                        <td>
                                            <strong style="color: #2a4a54;">{{ $item->book->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item->book->author }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span style="color: #335c67;">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <strong>{{ $item->quantity }}</strong>
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

            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-truck"></i> Informasi Pengiriman & Pembayaran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <small class="text-muted fw-bold d-block mb-2">Alamat Pengiriman</small>
                        <p class="mb-0" style="color: #2a4a54; white-space: pre-wrap;">{{ $order->delivery_address }}</p>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <small class="text-muted fw-bold d-block mb-2">Metode Pembayaran</small>
                        <p class="mb-0" style="color: #2a4a54;">
                            @if($order->payment_method === 'shopeepay')
                                <i class="fas fa-mobile-alt"></i> ShopeePay - 082144715831
                            @elseif($order->payment_method === 'transfer')
                                <i class="fas fa-university"></i> Transfer Bank
                            @else
                                <i class="fas fa-money-bill-wave"></i> {{ ucfirst($order->payment_method) }}
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div>
                        <small class="text-muted fw-bold d-block mb-2">Tanggal Pesanan</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if($order->paid_at)
                        <hr>
                        <div>
                            <small class="text-muted fw-bold d-block mb-2">Tanggal Pembayaran</small>
                            <p class="mb-0" style="color: #2a4a54;">{{ $order->paid_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Ringkasan
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
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Status Pembayaran</small>
                        <p class="mb-0">
                            @if($order->payment_status === 'unpaid')
                                <span class="badge bg-warning">
                                    <i class="fas fa-hourglass-half"></i> Belum Dibayar
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Sudah Dibayar
                                </span>
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div>
                        <small class="text-muted fw-bold d-block mb-2">Status Pengiriman</small>
                        <p class="mb-0">
                            @if($order->delivery_status === 'pending')
                                <span class="badge bg-secondary">
                                    <i class="fas fa-clock"></i> Diproses
                                </span>
                            @elseif($order->delivery_status === 'shipped')
                                <span class="badge bg-info">
                                    <i class="fas fa-truck"></i> Dikirim
                                </span>
                            @else
                                <span class="badge bg-success">
                                    <i class="fas fa-box"></i> Diterima
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-money-check-alt"></i> Validasi Pembayaran
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">
                        <i class="fas fa-info-circle"></i> Cek manual apakah pembayaran sudah masuk ke rekening ShopeePay
                    </p>
                    <form action="{{ route('admin.orders.payment', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold small" style="color: #2a4a54;">Status Pembayaran</label>
                            <select name="payment_status" class="form-select" required>
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            </select>
                        </div>
                        <button type="submit" class="btn w-100 fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-check"></i> Update Status Pembayaran
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-shipping-fast"></i> Update Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.orders.delivery', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold small" style="color: #2a4a54;">Status Pengiriman</label>
                            <select name="delivery_status" class="form-select" required>
                                <option value="pending" {{ $order->delivery_status === 'pending' ? 'selected' : '' }}>Diproses</option>
                                <option value="shipped" {{ $order->delivery_status === 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="delivered" {{ $order->delivery_status === 'delivered' ? 'selected' : '' }}>Diterima</option>
                            </select>
                        </div>
                        <button type="submit" class="btn w-100 fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-truck"></i> Update Status Pengiriman
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
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