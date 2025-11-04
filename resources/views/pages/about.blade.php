@extends('layouts.app')

@section('title', 'Tentang Kami - Bookstoreside')

@section('content')
<div class="container-fluid px-0">
    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4" style="color: #2a4a54;">
                        Tentang Bookstoreside
                    </h1>
                    <p class="lead mb-4" style="color: #555;">
                        Kami adalah toko buku online terpercaya yang menyediakan koleksi lengkap novel dan buku berkualitas dari penulis-penulis terbaik Indonesia.
                    </p>
                    <a href="{{ route('books.index') }}" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                        <i class="fas fa-book"></i> Mulai Belanja
                    </a>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <i class="fas fa-book-open" style="font-size: 8rem; color: #335c67; opacity: 0.2;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Vision & Mission Section -->
    <div class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold mb-3" style="color: #2a4a54;">Visi & Misi Kami</h2>
                    <p class="text-muted">Komitmen kami terhadap pembaca Indonesia</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-5 text-center">
                            <i class="fas fa-eye" style="font-size: 3rem; color: #335c67; margin-bottom: 20px;"></i>
                            <h4 class="fw-bold mb-3" style="color: #2a4a54;">Visi</h4>
                            <p class="text-muted" style="line-height: 1.8;">
                                Menjadi toko buku online terdepan di Indonesia yang menyediakan akses mudah ke koleksi buku berkualitas untuk semua kalangan pembaca.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-5 text-center">
                            <i class="fas fa-target" style="font-size: 3rem; color: #335c67; margin-bottom: 20px;"></i>
                            <h4 class="fw-bold mb-3" style="color: #2a4a54;">Misi</h4>
                            <p class="text-muted" style="line-height: 1.8;">
                                Memberikan pengalaman berbelanja buku yang menyenangkan dengan harga terjangkau, layanan cepat, dan dukungan pelanggan yang responsif.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold mb-3" style="color: #2a4a54;">Keunggulan Kami</h2>
                    <p class="text-muted">Mengapa memilih Bookstoreside?</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-book" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Koleksi Lengkap</h5>
                            <p class="text-muted small">
                                Ribuan judul buku dari penulis-penulis terbaik Indonesia tersedia di toko kami.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-money-bill-wave" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Harga Terjangkau</h5>
                            <p class="text-muted small">
                                Kami menawarkan harga kompetitif dengan berbagai pilihan metode pembayaran yang fleksibel.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-truck" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Pengiriman Cepat</h5>
                            <p class="text-muted small">
                                Pengiriman ke seluruh Indonesia dengan estimasi 2-5 hari kerja ke alamat Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-headset" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Dukungan 24/7</h5>
                            <p class="text-muted small">
                                Tim customer service kami siap membantu Anda melalui berbagai saluran komunikasi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Aman & Terpercaya</h5>
                            <p class="text-muted small">
                                Transaksi aman dengan enkripsi tingkat tinggi dan garansi uang kembali 100%.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-tags" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Promo & Diskon</h5>
                            <p class="text-muted small">
                                Dapatkan penawaran spesial, diskon menarik, dan program loyalitas untuk pelanggan setia.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold mb-3" style="color: #2a4a54;">Tim Kami</h2>
                    <p class="text-muted">Orang-orang berbakat di balik Bookstoreside</p>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="card shadow-sm border-0">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Firman Fadilah" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-1" style="color: #2a4a54;">Firman Fadilah</h5>
                            <p class="text-muted small mb-3">Founder & Developer</p>
                            <p class="text-muted small">
                                Mahasiswa dengan antusiasme terhadap Fullstack Web Dev, membangun Bookstoreside dengan passion.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-linkedin"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-github"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm border-0">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Developer" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-1" style="color: #2a4a54;">Developer 2</h5>
                            <p class="text-muted small mb-3">Backend Developer</p>
                            <p class="text-muted small">
                                Profesional berpengalaman dalam pengembangan backend dan sistem database yang robust.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-linkedin"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-github"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm border-0">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Designer" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-1" style="color: #2a4a54;">Designer</h5>
                            <p class="text-muted small mb-3">UI/UX Designer</p>
                            <p class="text-muted small">
                                Desainer kreatif yang menciptakan pengalaman pengguna yang intuitif dan menarik.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-linkedin"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-dribbble"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm border-0">
                        <img src="/team/kelaz.jpg" class="card-img-top" alt="Manager" style="height: 250px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-1" style="color: #2a4a54;">Manager</h5>
                            <p class="text-muted small mb-3">Project Manager</p>
                            <p class="text-muted small">
                                Manajer proyek berpengalaman memastikan setiap aspek bisnis berjalan dengan lancar.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mt-3">
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fab fa-linkedin"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary" style="border-color: #335c67; color: #335c67;">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="py-5 bg-light">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center mb-5">
                    <h2 class="fw-bold mb-3" style="color: #2a4a54;">Hubungi Kami</h2>
                    <p class="text-muted">Kami siap membantu Anda</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-map-marker-alt" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Lokasi</h5>
                            <p class="text-muted small mb-0">
                                Jl. Cendrawasih No.3, Tuban,<br>
                                Kec. Kuta, Kabupaten Badung,<br>
                                Bali 80361, Indonesia
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-phone" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Telepon</h5>
                            <p class="text-muted small mb-0">
                                <a href="tel:+62821447158_31" style="color: #335c67; text-decoration: none;">
                                    +62 821-447-158-31
                                </a><br>
                                Senin-Jumat: 08.00-17.00 WITA
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4 text-center">
                            <i class="fas fa-envelope" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold mb-3" style="color: #2a4a54;">Email</h5>
                            <p class="text-muted small mb-0">
                                <a href="mailto:firmanfdlh1@gmail.com" style="color: #335c67; text-decoration: none;">
                                    firmanfdlh1@gmail.com
                                </a><br>
                                Respon cepat, bantuan profesional
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="py-5" style="background-color: #335c67; color: white;">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Siap Memulai Perjalanan Membaca Anda?</h2>
            <p class="lead mb-4">Jelajahi koleksi lengkap buku dan temukan favorit Anda hari ini.</p>
            <a href="{{ route('books.index') }}" class="btn btn-light btn-lg fw-bold">
                <i class="fas fa-book"></i> Jelajahi Koleksi Buku
            </a>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection