@extends('layouts.app')

@section('title', 'Kelola Pesanan - Bookstoreside')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        <i class="fas fa-shopping-bag"></i> Kelola Pesanan
                    </h2>
                    <p class="text-muted">Monitor dan kelola semua pesanan pelanggan</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !request('payment_status') && !request('delivery_status') ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index') }}"
                       style="{{ !request('payment_status') && !request('delivery_status') ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-list"></i> Semua ({{ $totalOrders }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('payment_status') == 'unpaid' ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index', ['payment_status' => 'unpaid']) }}"
                       style="{{ request('payment_status') == 'unpaid' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-hourglass-half"></i> Belum Dibayar ({{ $unpaidOrders }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('payment_status') == 'paid' ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index', ['payment_status' => 'paid']) }}"
                       style="{{ request('payment_status') == 'paid' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-check-circle"></i> Sudah Dibayar ({{ $paidOrders }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('delivery_status') == 'pending' ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index', ['delivery_status' => 'pending']) }}"
                       style="{{ request('delivery_status') == 'pending' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-clock"></i> Pending ({{ $pendingDelivery }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('delivery_status') == 'shipped' ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index', ['delivery_status' => 'shipped']) }}"
                       style="{{ request('delivery_status') == 'shipped' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-truck"></i> Dikirim ({{ $shippedOrders }})
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Daftar Pesanan ({{ $orders->total() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
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
                                    @foreach($orders as $order)
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
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-hourglass-half"></i> Belum Dibayar
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Dibayar
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
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
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $order->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa;">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-bag" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada Pesanan</h3>
                        <p class="text-muted mb-0">
                            Pesanan dari pelanggan akan muncul di sini.
                        </p>
                    </div>
                </div>
            @endif
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

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection