@extends('layouts.app')

@section('title', 'Keranjang Belanja - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-shopping-cart"></i> Keranjang Belanja
        </h2>
        <p class="text-muted">Periksa dan kelola item di keranjang Anda</p>
    </div>

    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Cart Items -->
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
            : null);
@endphp

@if($cartImagePath)
    <img src="{{ $cartImagePath }}"
                                                        <img src="/books/{{ strtolower(str_replace(' ', '_', $item->book->title)) }}.jpg" alt="{{ $item->book->title }}" style="width: 50px; height: 70px; object-fit: contain; margin-right: 15px; background-color: #f8f9fa; padding: 3px;">
                                                    @else
                                                        <div style="width: 50px; height: 70px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                            <i class="fas fa-book" style="color: #adb5bd;"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1" style="color: #2a4a54;">
                                                            <a href="{{ route('books.show', $item->book->id) }}" style="text-decoration: none; color: inherit;">
                                                                {{ $item->book->title }}
                                                            </a>
                                                        </h6>
                                                        <small class="text-muted">{{ $item->book->author }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <strong style="color: #335c67;">
                                                    Rp {{ number_format($item->book->price, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="decreaseQty(this)">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" class="form-control text-center" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->book->stock }}" onchange="this.form.submit()">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="increaseQty(this)">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-end">
                                                <strong style="color: #335c67;">
                                                    Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus item ini dari keranjang?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 border-top d-flex justify-content-between align-items-center">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus semua item dari keranjang?')">
                                    <i class="fas fa-trash-alt"></i> Kosongkan Keranjang
                                </button>
                            </form>
                            <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary" style="border-color: #335c67; color: #335c67;">
                                <i class="fas fa-shopping-bag"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt"></i> Ringkasan Pesanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Buku:</span>
                                <strong>{{ $cartItems->sum('quantity') }} item</strong>
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

                        <form action="{{ route('orders.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn w-100 fw-bold py-3" style="background-color: #335c67; color: white; border: none; font-size: 1.1rem;">
                                <i class="fas fa-credit-card"></i> Lanjut ke Checkout
                            </button>
                        </form>

                        <p class="text-center text-muted small mt-3 mb-0">
                            Dengan melanjutkan, Anda setuju dengan <a href="#" style="color: #335c67; text-decoration: none;">Syarat & Ketentuan</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Keranjang Anda Kosong</h3>
                        <p class="text-muted mb-4">
                            Belum ada buku di keranjang Anda. Mulai belanja sekarang!
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

<script>
function increaseQty(btn) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    const max = parseInt(input.getAttribute('max'));
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
        input.onchange();
    }
}

function decreaseQty(btn) {
    const input = btn.parentElement.querySelector('input[type="number"]');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        input.onchange();
    }
}
</script>

<style>
    .alert-sm {
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.75rem;
    }

    .input-group-sm .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .input-group-sm input {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endsection