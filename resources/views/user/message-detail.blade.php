@extends('layouts.app')

@section('title', 'Detail Pesan - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/" style="color: #335c67;">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('messages.index') }}" style="color: #335c67;">Pesan Saya</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $message->subject }}</li>
        </ol>
    </nav>

    <!-- Page Title -->
    <div class="mb-5">
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
                        <i class="fas fa-hourglass-half"></i> Menunggu Balasan
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <!-- User Message -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user"></i> Pesan Anda
                        </h5>
                        <small>{{ $message->created_at->format('d M Y H:i') }}</small>
                    </div>
                </div>
                <div class="card-body p-4" style="background-color: #f8f9fa;">
                    <p style="line-height: 1.8; color: #555; white-space: pre-wrap;">
                        {{ $message->message }}
                    </p>
                </div>
            </div>

            <!-- Admin Reply -->
            @if($message->admin_reply)
                <div class="card shadow-sm border-0">
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
            @else
                <div class="alert alert-info alert-sm" role="alert">
                    <i class="fas fa-info-circle"></i>
                    <strong>Menunggu Balasan</strong>
                    <p class="mb-0 mt-2">Admin kami akan merespons pesan Anda dalam waktu 1-2 hari kerja. Terima kasih atas kesabarannya.</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Message Information -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Informasi Pesan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Nama</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->first_name }} {{ $message->last_name }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Email</small>
                        <p class="mb-0" style="color: #2a4a54;">
                            <a href="mailto:{{ $message->email }}" style="color: #335c67; text-decoration: none;">
                                {{ $message->email }}
                            </a>
                        </p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-2">Telepon</small>
                        <p class="mb-0" style="color: #2a4a54;">
                            @if($message->phone)
                                <a href="tel:{{ $message->phone }}" style="color: #335c67; text-decoration: none;">
                                    {{ $message->phone }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div>
                        <small class="text-muted fw-bold d-block mb-2">Tanggal Pengiriman</small>
                        <p class="mb-0" style="color: #2a4a54;">{{ $message->created_at->format('d M Y H:i') }}</p>
                    </div>
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
                        <a href="{{ route('messages.index') }}" class="btn btn-outline-primary btn-sm fw-bold" style="border-color: #335c67; color: #335c67;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                        <a href="{{ route('messages.create') }}" class="btn btn-sm fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-paper-plane"></i> Pesan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-headset"></i> Butuh Bantuan?
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Hubungi kami melalui saluran lain:</p>
                    <div class="mb-3">
                        <p class="mb-2">
                            <i class="fas fa-phone" style="color: #335c67; width: 20px;"></i>
                            <a href="tel:+62821447158_31" style="color: #335c67; text-decoration: none;">+62 821-447-158-31</a>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-2">
                            <i class="fas fa-envelope" style="color: #335c67; width: 20px;"></i>
                            <a href="mailto:firmanfdlh1@gmail.com" style="color: #335c67; text-decoration: none;">firmanfdlh1@gmail.com</a>
                        </p>
                    </div>
                    <div>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt" style="color: #335c67; width: 20px;"></i>
                            <span>Bali, Indonesia</span>
                        </p>
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

    .badge {
        padding: 8px 12px;
    }
</style>
@endsection