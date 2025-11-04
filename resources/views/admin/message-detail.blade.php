@extends('layouts.app')

@section('title', 'Detail Pesan - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.messages.index') }}" style="color: #335c67;">Pesan</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $message->subject }}</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        {{ $message->subject }}
                    </h2>
                    <p class="text-muted">{{ $message->created_at->format('d MMMM Y H:i') }}</p>
                </div>
                <div>
                    @if($message->admin_reply)
                        <span class="badge bg-success" style="padding: 10px 15px; font-size: 0.95rem;">
                            <i class="fas fa-check-circle"></i> Sudah Dibalas
                        </span>
                    @else
                        <span class="badge bg-warning" style="padding: 10px 15px; font-size: 0.95rem;">
                            <i class="fas fa-hourglass-half"></i> Belum Dibalas
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- Sender Information -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Informasi Pengirim
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted fw-bold d-block mb-2">Nama</small>
                            <p class="mb-0" style="color: #2a4a54;">
                                <strong>{{ $message->first_name }} {{ $message->last_name }}</strong>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted fw-bold d-block mb-2">Email</small>
                            <p class="mb-0">
                                <a href="mailto:{{ $message->email }}" style="color: #335c67; text-decoration: none;">
                                    {{ $message->email }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted fw-bold d-block mb-2">Telepon</small>
                            <p class="mb-0">
                                @if($message->phone)
                                    <a href="tel:{{ $message->phone }}" style="color: #335c67; text-decoration: none;">
                                        {{ $message->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted fw-bold d-block mb-2">Pengguna</small>
                            <p class="mb-0">
                                <a href="#" style="color: #335c67; text-decoration: none;">
                                    {{ $message->user->name }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Message -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope"></i> Pesan dari User
                    </h5>
                </div>
                <div class="card-body p-4" style="background-color: #f8f9fa;">
                    <p style="line-height: 1.8; color: #555; white-space: pre-wrap;">
                        {{ $message->message }}
                    </p>
                </div>
            </div>

            <!-- Admin Reply -->
            @if($message->admin_reply)
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-reply"></i> Balasan Admin
                            </h5>
                            <small>{{ $message->replied_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="card-body p-4" style="background-color: #f8f9fa;">
                        <p style="line-height: 1.8; color: #555; white-space: pre-wrap;">
                            {{ $message->admin_reply }}
                        </p>
                    </div>
                </div>

                <div class="alert alert-success alert-sm" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <strong>Pesan sudah dibalas</strong>
                    <p class="mb-0 mt-2">Balasan telah dikirimkan kepada user pada {{ $message->replied_at->format('d M Y H:i') }}</p>
                </div>
            @else
                <!-- Reply Form -->
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #2a4a54; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-reply"></i> Balas Pesan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="admin_reply" class="form-label fw-bold">Balasan Anda</label>
                                <textarea class="form-control @error('admin_reply') is-invalid @enderror" 
                                          id="admin_reply" name="admin_reply" rows="8" 
                                          placeholder="Ketikan balasan Anda di sini..." required>{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-1">Minimal 10 karakter</small>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                                    <i class="fas fa-paper-plane"></i> Kirim Balasan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Message Summary -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Ringkasan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Subjek</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->subject }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Tanggal Pengiriman</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Status</small>
                        <p class="mb-0">
                            @if($message->admin_reply)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Sudah Dibalas
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-hourglass-half"></i> Belum Dibalas
                                </span>
                            @endif
                        </p>
                    </div>
                    @if($message->admin_reply)
                        <hr>
                        <div>
                            <small class="text-muted fw-bold d-block mb-2">Tanggal Balasan</small>
                            <p class="mb-0" style="color: #2a4a54;">{{ $message->replied_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline-primary btn-sm fw-bold" style="border-color: #335c67; color: #335c67;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        @if(!$message->admin_reply)
                            <button type="button" class="btn btn-sm fw-bold" style="background-color: #335c67; color: white; border: none;" onclick="document.getElementById('admin_reply').focus()">
                                <i class="fas fa-reply"></i> Fokus ke Form Balas
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Profile Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle"></i> Profil Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Nama</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->user->name }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Email</small>
                        <p class="mb-0">
                            <a href="mailto:{{ $message->user->email }}" style="color: #335c67; text-decoration: none;">
                                {{ $message->user->email }}
                            </a>
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Status</small>
                        <p class="mb-0">
                            @if($message->user->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times-circle"></i> Nonaktif
                                </span>
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div>
                        <small class="text-muted fw-bold d-block mb-2">Total Pesanan</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->user->orders()->count() }} pesanan</p>
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

    .alert-sm {
        padding: 0.75rem 1rem;
    }

    textarea.form-control {
        resize: vertical;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .badge {
        padding: 8px 12px;
    }
</style>
@endsection