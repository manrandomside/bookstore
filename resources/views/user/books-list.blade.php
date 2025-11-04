@extends('layouts.app')

@section('title', 'Daftar Buku - Bookstoreside')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Filter -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-filter"></i> Filter Buku
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('books.index') }}" method="GET" id="filterForm">
                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #2a4a54;">Kategori</label>
                            <div class="list-group list-group-flush">
                                <a href="{{ route('books.index') }}" class="list-group-item list-group-item-action {{ !request('category_id') ? 'active' : '' }}" style="{{ !request('category_id') ? 'background-color: #335c67; color: white;' : '' }}">
                                    Semua Kategori
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('books.index', ['category_id' => $category->id]) }}" class="list-group-item list-group-item-action {{ request('category_id') == $category->id ? 'active' : '' }}" style="{{ request('category_id') == $category->id ? 'background-color: #335c67; color: white;' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold" style="color: #2a4a54;">Cari Buku</label>
                            <input type="text" class="form-control" name="search" placeholder="Judul atau penulis..." value="{{ request('search') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="color: #2a4a54;">Urutkan</label>
                            <select class="form-select" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <button type="submit" class="btn w-100 fw-bold" style="background-color: #335c67; color: white;">
                            <i class="fas fa-search"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100 fw-bold mt-2">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <!-- Header -->
            <div class="mb-4">
                <h2 class="fw-bold" style="color: #2a4a54;">
                    <i class="fas fa-book"></i> Koleksi Buku
                </h2>
                <p class="text-muted">
                    Temukan buku favorit Anda dari koleksi lengkap kami
                </p>
            </div>

            <!-- Info Results -->
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle"></i> 
                Menampilkan <strong>{{ $books->count() }}</strong> dari <strong>{{ $totalBooks }}</strong> buku
                @if(request('search'))
                    yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('category_id'))
                    di kategori "<strong>{{ $selectedCategory->name ?? 'Tidak diketahui' }}</strong>"
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <!-- Books Grid -->
            @if($books->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-5">
                    @foreach($books as $book)
                        <div class="col">
                            <div class="card shadow-sm h-100">
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
                                    <img src="/books/{{ strtolower(str_replace(' ', '_', $book->title)) }}.jpg" class="card-img-top" alt="{{ $book->title }}" style="width: 100%; max-height: 350px; object-fit: contain; object-position: top; padding: 10px; background-color: #f8f9fa;">
                                @else
                                    <div style="width: 100%; height: 300px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="font-size: 3rem; color: #adb5bd;"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title" style="color: #2a4a54;">
                                        {{ $book->title }}
                                    </h5>
                                    
                                    <p class="card-text text-muted mb-2">
                                        <small>
                                            <i class="fas fa-pen"></i> {{ $book->author }}
                                        </small>
                                    </p>

                                    <p class="card-text text-muted mb-2">
                                        <small>
                                            <i class="fas fa-tag"></i> {{ $book->category->name }}
                                        </small>
                                    </p>

                                    <p class="card-text flex-grow-1">
                                        {{ Str::limit($book->description, 100) }}
                                    </p>

                                    <div class="mb-3">
                                        @if($book->stock > 0)
                                            <span class="badge bg-success">Stok: {{ $book->stock }}</span>
                                        @else
                                            <span class="badge bg-danger">Habis</span>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <span class="fw-bold" style="color: #335c67; font-size: 1.1rem;">
                                            Rp {{ number_format($book->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="btn-group w-100 mt-3">
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm" style="background-color: #335c67; color: white;">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        @auth
                                            @if(auth()->user()->role === 'user')
                                                @if($book->stock > 0)
                                                    <form action="{{ route('cart.add', $book->id) }}" method="POST" style="flex: 1;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary w-100" style="border-color: #2a4a54; color: #2a4a54;">
                                                            <i class="fas fa-shopping-cart"></i> Keranjang
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-outline-secondary w-100" disabled style="border-color: #2a4a54; color: #2a4a54;">
                                                        <i class="fas fa-times"></i> Habis
                                                    </button>
                                                @endif
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary w-100" style="border-color: #2a4a54; color: #2a4a54;">
                                                <i class="fas fa-shopping-cart"></i> Keranjang
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mb-5">
                    {{ $books->links() }}
                </div>
            @else
                <div class="alert alert-warning text-center" role="alert">
                    <i class="fas fa-search"></i>
                    <h5 class="mt-2">Buku tidak ditemukan</h5>
                    <p class="text-muted mb-0">Coba ubah filter pencarian Anda atau lihat semua buku.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .list-group-item {
        border: 1px solid #ddd;
    }

    .list-group-item.active {
        background-color: #335c67 !important;
        border-color: #335c67 !important;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection