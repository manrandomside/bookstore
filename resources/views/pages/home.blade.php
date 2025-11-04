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
    <img src="{{ $imagePath }}"
                                <img src="/books/{{ strtolower(str_replace(' ', '_', $book->title)) }}.jpg" class="card-img-top" alt="{{ $book->title }}" style="width: 100%; max-height: 400px; object-fit: contain; object-position: top; padding: 10px;">
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
                                            @if(auth()->user()->role === 'user')
                                                <a href="{{ route('cart.add', $book->id) }}" type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #2a4a54; color: #2a4a54;">
                                                    <i class="fas fa-shopping-cart"></i> Keranjang
                                                </a>
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
                        <div class="alert alert-info text-center" role="alert">
                            <i class="fas fa-info-circle"></i> Belum ada buku tersedia
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <section id="team" class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light" style="color: #2a4a54;">Tim Kami</h1>
                <p class="lead text-body-secondary">
                    Tim kami terdiri dari beberapa orang berdedikasi dengan pengalaman di dunia pengembangan web dan toko buku online.
                </p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Firman Fadilah" style="height: 225px; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <h5 class="card-title text-center" style="color: #2a4a54;">Firman Fadilah</h5>
                            <p class="card-text text-center text-body-secondary">
                                <small>Mahasiswa dengan antusiasme terhadap Fullstack Web Dev, dan sedang ingin membangun usaha toko buku terutama dengan fokus ke Novel.</small>
                            </p>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fas fa-envelope"></i> Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Developer" style="height: 225px; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <h5 class="card-title text-center" style="color: #2a4a54;">Firman Versi 2</h5>
                            <p class="card-text text-center text-body-secondary">
                                <small>Developer berpengalaman dengan minat yang sama terhadap pengembangan web dan ingin memperdalam Python untuk jenjang kedepannya.</small>
                            </p>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fas fa-envelope"></i> Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Designer" style="height: 225px; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <h5 class="card-title text-center" style="color: #2a4a54;">Fadilah</h5>
                            <p class="card-text text-center text-body-secondary">
                                <small>Nama panjang dari karakter utama dalam pembuatan project ini. Salam kenal semua, kenalin kami Firman Fadilah.</small>
                            </p>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fas fa-envelope"></i> Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Team" style="height: 225px; object-fit: cover; object-position: center;">
                        <div class="card-body">
                            <h5 class="card-title text-center" style="color: #2a4a54;">manrandomside</h5>
                            <p class="card-text text-center text-body-secondary">
                                <small>Username yang sering digunakan terutama di GitHub. Intinya ini merupakan username favorit yang suka digunakan dalam berbagai platform.</small>
                            </p>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                        <i class="fas fa-envelope"></i> Email
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="container my-5">
        <h2 class="text-center mb-5" style="color: #2a4a54;">Hubungi Kami</h2>
        <div class="row">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span style="color: #2a4a54;">Informasi Kontak</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0" style="color: #335c67;">Alamat</h6>
                            <small class="text-body-secondary">
                                Jl. Cendrawasih No.3, Tuban,<br>
                                Kec. Kuta, Kabupaten Badung, Bali 80361
                            </small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0" style="color: #335c67;">Telepon</h6>
                            <small class="text-body-secondary">+62 821-447-158-31</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-sm">
                        <div>
                            <h6 class="my-0" style="color: #335c67;">Email</h6>
                            <small class="text-body-secondary">firmanfdlh1@gmail.com</small>
                        </div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            <h6 class="my-0" style="color: #335c67;">Jam Operasional</h6>
                            <small class="text-body-secondary">
                                Senin - Jumat: 08.00 - 17.00 (WITA)<br>
                                Sabtu: 10.00 - 17.00 (WITA)<br>
                                Minggu: Libur
                            </small>
                        </div>
                    </li>
                </ul>

                <div class="card p-3" style="border-color: #335c67;">
                    <div class="card-body p-0">
                        <h6 class="card-title" style="color: #2a4a54;">Ikuti Kami</h6>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                <i class="fab fa-github"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                <i class="fab fa-instagram"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-lg-8">
                <h4 class="mb-4" style="color: #2a4a54;">Form Kontak</h4>
                <form action="{{ route('messages.store') }}" method="POST" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label fw-bold">Nama Depan</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" placeholder="Nama depan" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label fw-bold">Nama Belakang</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Nama belakang" required>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
                        </div>

                        <div class="col-12">
                            <label for="phone" class="form-label fw-bold">Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="+62 821-447-158-31">
                        </div>

                        <div class="col-12">
                            <label for="subject" class="form-label fw-bold">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subjek pesan Anda" required>
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label fw-bold">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Ketikan pesan yang ingin Anda sampaikan di sini..." required></textarea>
                        </div>
                    </div>

                    <hr class="my-4">

                    <button class="w-100 btn btn-lg fw-bold" type="submit" style="background-color: #335c67; border-color: #335c67; color: white;">
                        <i class="fas fa-paper-plane"></i> Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection