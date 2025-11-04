@extends('layouts.app')

@section('title', 'Checkout - Bookstoreside')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-credit-card"></i> Checkout
        </h2>
        <p class="text-muted">Lengkapi informasi pengiriman dan pembayaran Anda</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi Kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('orders.checkout') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-shipping-fast"></i> Informasi Pengiriman
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="delivery_address" class="form-label fw-bold" style="color: #2a4a54;">
                                Alamat Pengiriman <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                name="delivery_address" 
                                id="delivery_address" 
                                class="form-control @error('delivery_address') is-invalid @enderror" 
                                rows="4" 
                                placeholder="Masukkan alamat lengkap pengiriman (minimal 10 karakter)"
                                required>{{ old('delivery_address') }}</textarea>
                            @error('delivery_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Pastikan alamat lengkap termasuk nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota, dan kode pos
                            </small>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-wallet"></i> Metode Pembayaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-mobile-alt" style="font-size: 2.5rem; color: #335c67;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="alert-heading mb-2" style="color: #2a4a54;">
                                        <i class="fas fa-check-circle text-success"></i> ShopeePay
                                    </h5>
                                    <p class="mb-2">
                                        Transfer ke nomor ShopeePay berikut:
                                    </p>
                                    <div class="p-3 bg-white rounded border">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong style="font-size: 1.2rem; color: #335c67;">082144715831</strong>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="copyToClipboard('082144715831')">
                                                <i class="fas fa-copy"></i> Salin
                                            </button>
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle"></i> Setelah melakukan pembayaran, konfirmasi pembayaran Anda di halaman detail pesanan
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Item Pesanan ({{ $cartItems->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-3">
                        <div style="max-height: 300px; overflow-y: auto;">
                            @foreach($cartItems as $item)
                                <div class="d-flex mb-3 pb-3 border-bottom">
                                    @php
                                        $checkoutBookImage = strtolower(str_replace(' ', '_', $item->book->title));
                                        $checkoutImagePath = file_exists(public_path("books/{$checkoutBookImage}.jpg")) 
                                            ? "/books/{$checkoutBookImage}.jpg" 
                                            : (file_exists(public_path("books/{$checkoutBookImage}.jpeg")) 
                                                ? "/books/{$checkoutBookImage}.jpeg" 
                                                : (file_exists(public_path("books/{$checkoutBookImage}.png")) 
                                                    ? "/books/{$checkoutBookImage}.png" 
                                                    : "/books/default.jpg"));
                                    @endphp
                                    <img src="{{ $checkoutImagePath }}" alt="{{ $item->book->title }}" class="me-2" style="width: 50px; height: 75px; object-fit: cover; border-radius: 4px;">
                                    <div class="flex-grow-1">
                                        <small class="d-block fw-bold" style="color: #2a4a54;">{{ $item->book->title }}</small>
                                        <small class="text-muted d-block">{{ $item->quantity }}x Rp {{ number_format($item->book->price, 0, ',', '.') }}</small>
                                        <small class="fw-bold" style="color: #335c67;">Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt"></i> Ringkasan Pembayaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
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

                        <button type="submit" class="btn w-100 fw-bold py-3 mb-3" style="background-color: #335c67; color: white; border: none; font-size: 1.1rem;">
                            <i class="fas fa-check-circle"></i> Buat Pesanan
                        </button>

                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                        </a>

                        <p class="text-center text-muted small mt-3 mb-0">
                            Dengan membuat pesanan, Anda setuju dengan <a href="#" style="color: #335c67; text-decoration: none;">Syarat & Ketentuan</a> kami
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Nomor ShopeePay berhasil disalin: ' + text);
    }, function(err) {
        console.error('Gagal menyalin: ', err);
    });
}
</script>
@endsection