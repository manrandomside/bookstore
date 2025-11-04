@extends('layouts.app')

@section('title', 'Keranjang Belanja - Bookstoreside')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-shopping-cart"></i> Keranjang Belanja
        </h2>
        <p class="text-muted">Periksa dan kelola item di keranjang Anda</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Item Keranjang ({{ $cartItems->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">Produk</th>
                                        <th class="text-center" style="color: #2a4a54;">Harga</th>
                                        <th class="text-center" style="color: #2a4a54;">Jumlah</th>
                                        <th class="text-end" style="color: #2a4a54;">Subtotal</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $cartBookImage = strtolower(str_replace(' ', '_', $item->book->title));
                                                        $cartImagePath = file_exists(public_path("books/{$cartBookImage}.jpg")) 
                                                            ? "/books/{$cartBookImage}.jpg" 
                                                            : (file_exists(public_path("books/{$cartBookImage}.jpeg")) 
                                                                ? "/books/{$cartBookImage}.jpeg" 
                                                                : (file_exists(public_path("books/{$cartBookImage}.png")) 
                                                                    ? "/books/{$cartBookImage}.png" 
                                                                    : "/books/default.jpg"));
                                                    @endphp
                                                    <img src="{{ $cartImagePath }}" alt="{{ $item->book->title }}" class="me-3" style="width: 60px; height: 90px; object-fit: cover; border-radius: 4px;">
                                                    <div>
                                                        <strong style="color: #2a4a54;">{{ $item->book->title }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $item->book->author }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span style="color: #335c67; font-weight: 600;">
                                                    Rp {{ number_format($item->book->price, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 30px; height: 30px; padding: 0;">-</button>
                                                    </form>
                                                    <input type="text" value="{{ $item->quantity }}" readonly class="form-control form-control-sm text-center mx-2" style="width: 50px;">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" style="width: 30px; height: 30px; padding: 0;">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="text-end align-middle">
                                                <strong style="color: #335c67;">
                                                    Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center align-middle">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #f8f9fa;">
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua item di keranjang?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt"></i> Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Buku:</span>
                                <strong style="color: #2a4a54;">
                                    {{ $cartItems->count() }} item
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <strong style="color: #335c67;">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ongkir:</span>
                                <strong style="color: #335c67;">
                                    Rp {{ number_format($shipping, 0, ',', '.') }}
                                </strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold" style="color: #2a4a54;">Total:</span>
                                <span class="fw-bold" style="color: #335c67; font-size: 1.3rem;">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="alert alert-info alert-sm mb-3" role="alert">
                            <small>
                                <i class="fas fa-info-circle"></i> Ongkos kirim dihitung berdasarkan berat paket dan lokasi pengiriman.
                            </small>
                        </div>

                        <a href="{{ route('checkout.show') }}" class="btn w-100 fw-bold py-3" style="background-color: #335c67; color: white; border: none; font-size: 1.1rem;">
                            <i class="fas fa-credit-card"></i> Lanjut ke Checkout
                        </a>

                        <p class="text-center text-muted small mt-3 mb-0">
                            Dengan melanjutkan, Anda setuju dengan <a href="#" style="color: #335c67; text-decoration: none;">Syarat & Ketentuan</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Keranjang Anda Kosong</h3>
                        <p class="text-muted mb-4">
                            Belum ada buku di keranjang Anda. Mulai belanja sekarang!
                        </p>
                        <a href="{{ route('books.index') }}" class="btn btn-lg" style="background-color: #335c67; color: white;">
                            <i class="fas fa-book"></i> Jelajahi Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection