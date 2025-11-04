@extends('layouts.app')

@section('title', 'Login - Bookstoreside')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-sign-in-alt" style="font-size: 3rem; color: #335c67;"></i>
                        <h2 class="mt-3" style="color: #2a4a54;">Masuk Akun</h2>
                        <p class="text-muted">Masukkan email dan password Anda</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" novalidate>
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email" required>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Masukkan password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                            <i class="fas fa-sign-in-alt"></i> Masuk
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Belum punya akun? 
                            <a href="{{ route('register') }}" style="color: #335c67; text-decoration: none; font-weight: bold;">
                                Daftar di sini
                            </a>
                        </p>
                    </div>

                    <hr class="my-4">



                    <div class="text-center mt-4">
                        <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-book"></i> Lihat Buku tanpa Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 12px;
    }

    .alert-sm {
        padding: 0.5rem;
        margin-bottom: 0.5rem;
    }
</style>
@endsection