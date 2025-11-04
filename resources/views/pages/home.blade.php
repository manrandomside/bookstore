@extends('layouts.app')

@section('title', 'Bookstoreside - Toko Buku Online Terpercaya')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div id="home" class="container my-5">
        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                <h1 class="display-4 fw-bold lh-1" style="color: #2a4a54;">
                    Selamat Datang di Bookstoreside
                </h1>
                <p class="lead">
                    Temukan koleksi novel terbaik Indonesia dengan harga terjangkau. Dari karya-karya legendaris Tere Liye hingga novel-novel inspiratif lainnya. Mulai perjalanan membaca Anda bersama kami.
                </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                    <a href="{{ route('books.index') }}" type="button" class="btn btn-lg px-4 me-md-2 fw-bold" style="background-color: #335c67; border-color: #335c67; color: white;">
                        <i class="fas fa-book"></i> Jelajahi Koleksi Buku
                    </a>
                    <a href="#best-seller" type="button" class="btn btn-outline-secondary btn-lg px-4" style="border-color: #2a4a54; color: #2a4a54;">
                        <i class="fas fa-arrow-down"></i> Best Seller
                    </a>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
                <img class="rounded-lg-3" src="/books/bumi.jpg" alt="Featured Book" style="width: 100%; height: 100%; max-height: 450px; object-fit: cover;">
            </div>
        </div>
    </div>

    <!-- Best Seller Section -->
    <section id="best-seller" class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light" style="color: #2a4a54;">Best Seller</h1>
                <p class="lead text-body-secondary">
                    Temukan koleksi novel terbaik Indonesia yang telah menyentuh jutaan hati pembaca. Dari karya-karya Tere Liye hingga novel-novel inspiratif lainnya.
                </p>
                <p>
                    <a href="{{ route('books.index') }}" class="btn my-2 m-2" style="background-color: #335c67; border-color: #335c67; color: white; text-decoration: none;">
                        <i class="fas fa-eye"></i> Lihat Semua
                    </a>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary my-2" style="border-color: #2a4a54; color: #2a4a54; text-decoration: none;">
                        <i class="fas fa-book-open"></i> Buku Lainnya
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- Product List -->
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @forelse($bestSellerBooks as $book)
                    <div class="col">
                        <div class="card shadow-sm">
                            @php
                                $bookImage = strtolower(str_replace(' ', '_', $book->title));
                                $imagePath = file_exists(public_path("books/{$bookImage}.jpg")) 
                                    ? "/books/{$bookImage}.jpg" 
                                    : (file_exists(public_path("books/{$bookImage}.jpeg")) 
                                        ? "/books/{$bookImage}.jpeg" 
                                        : null);
                            @endphp
                            @if($imagePath)
                                <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $book->title }}" style="width: 100%; max-height: 400px; object-fit: contain; object-position: top; padding: 10px;">
                            @else
                                <div style="width: 100%; height: 300px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="font-size: 3rem; color: #adb5bd;"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title" style="color: #2a4a54;">{{ $book->title }}</h5>
                                <p class="card-text text-muted">
                                    <small>{{ $book->author }}</small>
                                </p>
                                <p class="card-text">
                                    {{ Str::limit($book->description, 80) }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('books.show', $book->id) }}" type="button" class="btn btn-sm" style="background-color: #335c67; color: white;">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        @auth
                                            @if(auth()->user()->role === 'user' && $book->stock > 0)
                                                <form action="{{ route('cart.add', $book->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="border-color: #2a4a54; color: #2a4a54;">
                                                        <i class="fas fa-shopping-cart"></i> Keranjang
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #2a4a54; color: #2a4a54;">
                                                <i class="fas fa-shopping-cart"></i> Keranjang
                                            </a>
                                        @endauth
                                    </div>
                                    <small class="text-body-secondary fw-bold" style="color: #335c67;">Rp {{ number_format($book->price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Belum ada buku tersedia
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        height: 100%;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection