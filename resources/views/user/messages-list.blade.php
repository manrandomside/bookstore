@extends('layouts.app')

@section('title', 'Pesan Saya - Bookstoreside')

@section('content')
<div class="container py-5">
    <!-- Page Title -->
    <div class="mb-5">
        <h2 class="fw-bold" style="color: #2a4a54;">
            <i class="fas fa-envelope"></i> Pesan Saya
        </h2>
        <p class="text-muted">Kelola pesan dan percakapan dengan admin</p>
    </div>

    <div class="row">
        <!-- Messages List -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            @if($messages->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-inbox"></i> Daftar Pesan ({{ $messages->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <a href="{{ route('messages.show', $message->id) }}" class="list-group-item list-group-item-action p-4 border-bottom">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="mb-0 fw-bold" style="color: #2a4a54;">
                                                    {{ $message->subject }}
                                                </h6>
                                                @if(!$message->admin_reply)
                                                    <span class="badge bg-info">
                                                        <i class="fas fa-clock"></i> Menunggu Balasan
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Sudah Dibalas
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-muted mb-2 small">
                                                {{ Str::limit($message->message, 100) }}
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar"></i> {{ $message->created_at->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                            <i class="fas fa-chevron-right" style="color: #335c67;"></i>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $messages->links() }}
                </div>
            @else
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-envelope-open" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada Pesan</h3>
                        <p class="text-muted mb-4">
                            Anda belum mengirim pesan apapun kepada kami. Hubungi kami sekarang!
                        </p>
                        <a href="{{ route('messages.create') }}" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;">
                            <i class="fas fa-paper-plane"></i> Kirim Pesan
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i> Statistik
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Pesan</span>
                            <strong style="color: #335c67; font-size: 1.3rem;">{{ $totalMessages }}</strong>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Sudah Dibalas</span>
                            <strong style="color: #335c67; font-size: 1.3rem;">{{ $repliedMessages }}</strong>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Menunggu Balasan</span>
                            <strong style="color: #335c67; font-size: 1.3rem;">{{ $pendingMessages }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action -->
            <div class="card shadow-sm border-0">
                <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt"></i> Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('messages.create') }}" class="btn btn-lg fw-bold w-100" style="background-color: #335c67; color: white; border: none;">
                        <i class="fas fa-paper-plane"></i> Pesan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .list-group-item-action {
        text-decoration: none;
        color: inherit;
    }
</style>
@endsection