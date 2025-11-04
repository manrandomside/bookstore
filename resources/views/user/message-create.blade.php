@extends('layouts.app')

@section('title', 'Kirim Pesan - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('messages.index') }}" style="color: #335c67;">Pesan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kirim Pesan</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-paper-plane"></i> Contact to Admin
        </h2>
        <p class="text-muted">Hubungi admin kami dengan pesan Anda</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope"></i> Form Pesan ke Admin
                    </h5>
                </div>
                <div class="card-body p-5">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf

                        <!-- User Info Display -->
                        <div class="alert alert-light border mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Dari:</small>
                                    <p class="mb-0 fw-bold">{{ auth()->user()->name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Email:</small>
                                    <p class="mb-0">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-bold">Subjek Pesan</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" 
                                   placeholder="Contoh: Pertanyaan tentang pengiriman" required>
                            @error('subject')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1">Jelaskan topik pesan Anda secara singkat</small>
                        </div>

                        <!-- Message -->
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Pesan</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="8" 
                                      placeholder="Ketikan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1">Minimal 10 karakter</small>
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info mb-4" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                Pesan Anda akan kami terima dan admin akan meresponnya dalam waktu 1-2 hari kerja.
                            </small>
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                                <i class="fas fa-paper-plane"></i> Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-phone" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold" style="color: #2a4a54;">Hubungi Kami</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone"></i> +62 821-447-158-31
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-envelope" style="font-size: 2.5rem; color: #335c67; margin-bottom: 15px;"></i>
                            <h5 class="fw-bold" style="color: #2a4a54;">Email</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope"></i> firmanfdlh1@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

    .form-control:focus, .form-select:focus {
        border-color: #335c67;
        box-shadow: 0 0 0 0.2rem rgba(51, 92, 103, 0.25);
    }

    textarea.form-control {
        resize: vertical;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
</style>
@endsection