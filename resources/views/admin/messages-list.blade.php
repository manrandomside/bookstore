@extends('layouts.app')

@section('title', 'Kelola Pesan - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        <i class="fas fa-envelope"></i> Kelola Pesan
                    </h2>
                    <p class="text-muted">Kelola dan balas pesan dari pengguna</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" 
                       href="{{ route('admin.messages.index') }}"
                       style="{{ !request('status') ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-inbox"></i> Semua ({{ $totalMessages }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'unreplied' ? 'active' : '' }}" 
                       href="{{ route('admin.messages.index', ['status' => 'unreplied']) }}"
                       style="{{ request('status') == 'unreplied' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-hourglass-half"></i> Belum Dibalas ({{ $unrepliedMessages }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'replied' ? 'active' : '' }}" 
                       href="{{ route('admin.messages.index', ['status' => 'replied']) }}"
                       style="{{ request('status') == 'replied' ? 'background-color: #335c67; color: white;' : 'color: #335c67;' }}">
                        <i class="fas fa-check-circle"></i> Sudah Dibalas ({{ $repliedMessages }})
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="row">
        <div class="col-12">
            @if($messages->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Daftar Pesan
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No</th>
                                        <th style="color: #2a4a54;">Pengirim</th>
                                        <th style="color: #2a4a54;">Subjek</th>
                                        <th style="color: #2a4a54;">Email</th>
                                        <th class="text-center" style="color: #2a4a54;">Status</th>
                                        <th class="text-center" style="color: #2a4a54;">Tanggal</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $index => $message)
                                        <tr>
                                            <td>
                                                <strong>{{ $index + 1 }}</strong>
                                            </td>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $message->first_name }} {{ $message->last_name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ Str::limit($message->subject, 40) }}</span>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $message->email }}" style="color: #335c67; text-decoration: none;">
                                                    {{ $message->email }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if($message->admin_reply)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Dibalas
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="fas fa-hourglass-half"></i> Belum Dibalas
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $message->created_at->format('d M Y H:i') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.messages.show', $message->id) }}" class="btn btn-sm" style="background-color: #335c67; color: white;">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <p class="text-muted mb-0">
                            Pesan dari pengguna akan muncul di sini.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .nav-pills .nav-link {
        border-radius: 8px;
        margin-right: 8px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link:hover {
        background-color: #335c67 !important;
        color: white !important;
    }

    .card {
        border-radius: 8px;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection