@extends('layouts.app')

@section('title', $book->title . ' - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}" style="color: #335c67;">Buku</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index', ['category_id' => $book->category_id]) }}" style="color: #335c67;">{{ $book->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav>

    <!-- Book Detail -->
    <div class="row mb-5">
        <!-- Book Image -->
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm border-0">
                @php
    $bookImage = strtolower(str_replace(' ', '_', $book->title));
    $imagePath = file_exists(public_path("books/{$bookImage}.jpg")) 
        ? "/books/{$bookImage}.jpg" 
        : (file_exists(public_path("books/{$bookImage}.jpeg")) 
            ? "/books/{$bookImage}.jpeg" 
            : null);
@endphp

@if($imagePath)
    <img src="{{ $imagePath }}"
                    <img src="/books/{{ strtolower(str_replace(' ', '_', $book->title)) }}.jpg" class="card-img-top" alt="{{ $book->title }}" style="max-height: 500px; object-fit: contain; padding: 20px; background-color: #f8f9fa;">
                @else
                    <div style="width: 100%; height: 500px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-image" style="font-size: 5rem; color: #adb5bd;"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Book Info -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <!-- Category Badge -->
                    <div class="mb-3">
                        <a href="{{ route('books.index', ['category_id' => $book->category_id]) }}" class="badge" style="background-color: #335c67; text-decoration: none; font-size: 0.9rem; padding: 8px 12px;">
                            {{ $book->category->name }}
                        </a>
                    </div>

                    <!-- Title -->
                    <h1 class="fw-bold mb-2" style="color: #2a4a54;">
                        {{ $book->title }}
                    </h1>

                    <!-- Author -->
                    <p class="text-muted mb-1">
                        <i class="fas fa-pen"></i> Penulis: <strong>{{ $book->author }}</strong>
                    </p>

                    <!-- ISBN -->
                    <p class="text-muted mb-4">
                        <i class="fas fa-barcode"></i> ISBN: <strong>{{ $book->isbn }}</strong>
                    </p>

                    <!-- Rating dan Stock Info -->
                    <div class="mb-4 pb-4 border-bottom">
                        <div class="row">
                            <div class="col-6">
                                @if($book->stock > 0)
                                    <p class="mb-0">
                                        <span class="badge bg-success" style="font-size: 1rem;">
                                            <i class="fas fa-check-circle"></i> Tersedia
                                        </span>
                                    </p>
                                    <small class="text-muted">Stok: {{ $book->stock }} buku</small>
                                @else
                                    <p class="mb-0">
                                        <span class="badge bg-danger" style="font-size: 1rem;">
                                            <i class="fas fa-times-circle"></i> Habis
                                        </span>
                                    </p>
                                @endif
                            </div>
                            <div class="col-6 text-end">
                                <p class="mb-0">
                                    <span class="text-muted">Dilihat:</span> <strong>{{ rand(50, 500) }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <p class="text-muted mb-1">Harga</p>
                        <h2 class="fw-bold" style="color: #335c67;">
                            Rp {{ number_format($book->price, 0, ',', '.') }}
                        </h2>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 mb-4">
                        @auth
                            @if(auth()->user()->role === 'user')
                                @if($book->stock > 0)
                                    <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                                            <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-lg fw-bold" style="background-color: #ccc; color: white; border: none;" disabled>
                                        <i class="fas fa-times"></i> Stok Habis
                                    </button>
                                @endif
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none; text-decoration: none;">
                                <i class="fas fa-shopping-cart"></i> Login untuk Membeli
                            </a>
                        @endauth
                    </div>

                    <!-- Wishlist & Share -->
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-heart"></i> Wishlist
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary w-100">
                                <i class="fas fa-share-alt"></i> Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">Deskripsi Buku</h5>
                </div>
                <div class="card-body p-4">
                    <p style="line-height: 1.8; color: #555;">
                        {{ $book->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="row mb-5">
        <div class="col-md-6 mb-3 mb-md-0">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Buku
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong style="color: #2a4a54;">Penulis:</strong>
                        <p class="text-muted">{{ $book->author }}</p>
                    </div>
                    <div class="mb-3">
                        <strong style="color: #2a4a54;">Kategori:</strong>
                        <p class="text-muted">{{ $book->category->name }}</p>
                    </div>
                    <div class="mb-3">
                        <strong style="color: #2a4a54;">ISBN:</strong>
                        <p class="text-muted">{{ $book->isbn }}</p>
                    </div>
                    <div>
                        <strong style="color: #2a4a54;">Stok Tersedia:</strong>
                        <p class="text-muted">{{ $book->stock }} buku</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-truck"></i> Pengiriman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong style="color: #2a4a54;">Pengiriman dari:</strong>
                        <p class="text-muted">Bali, Indonesia</p>
                    </div>
                    <div class="mb-3">
                        <strong style="color: #2a4a54;">Estimasi:</strong>
                        <p class="text-muted">2-5 hari kerja</p>
                    </div>
                    <div>
                        <strong style="color: #2a4a54;">Garansi:</strong>
                        <p class="text-muted">Uang kembali 100% jika tidak sesuai</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Books -->
    @if($relatedBooks->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="fw-bold mb-4" style="color: #2a4a54;">
                    <i class="fas fa-book"></i> Buku Terkait Lainnya
                </h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    @foreach($relatedBooks as $relatedBook)
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                @php
    $relatedBookImage = strtolower(str_replace(' ', '_', $relatedBook->title));
    $relatedImagePath = file_exists(public_path("books/{$relatedBookImage}.jpg")) 
        ? "/books/{$relatedBookImage}.jpg" 
        : (file_exists(public_path("books/{$relatedBookImage}.jpeg")) 
            ? "/books/{$relatedBookImage}.jpeg" 
            : null);
@endphp

@if($relatedImagePath)
    <img src="{{ $relatedImagePath }}"
                                    <img src="/books/{{ strtolower(str_replace(' ', '_', $relatedBook->title)) }}.jpg" class="card-img-top" alt="{{ $relatedBook->title }}" style="max-height: 280px; object-fit: contain; padding: 10px; background-color: #f8f9fa;">
                                @else
                                    <div style="width: 100%; height: 280px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="font-size: 2rem; color: #adb5bd;"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title" style="color: #2a4a54;">
                                        {{ $relatedBook->title }}
                                    </h6>
                                    <p class="card-text text-muted mb-2">
                                        <small>{{ $relatedBook->author }}</small>
                                    </p>
                                    <p class="card-text fw-bold mb-3" style="color: #335c67;">
                                        Rp {{ number_format($relatedBook->price, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('books.show', $relatedBook->id) }}" class="btn btn-sm mt-auto" style="background-color: #335c67; color: white;">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mb-5 text-center">
        <a href="{{ route('books.index') }}" class="btn btn-outline-primary" style="border-color: #335c67; color: #335c67;">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Buku
        </a>
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
</style>
@endsection