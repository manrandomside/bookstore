@extends('layouts.app')

@section('title', 'Kelola User - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        <i class="fas fa-users"></i> Kelola User
                    </h2>
                    <p class="text-muted">Kelola dan monitor akun pengguna</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            @if($users->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Daftar User ({{ $users->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No</th>
                                        <th style="color: #2a4a54;">Nama</th>
                                        <th style="color: #2a4a54;">Email</th>
                                        <th class="text-center" style="color: #2a4a54;">Role</th>
                                        <th class="text-center" style="color: #2a4a54;">Total Pesanan</th>
                                        <th class="text-center" style="color: #2a4a54;">Status</th>
                                        <th class="text-center" style="color: #2a4a54;">Tanggal Daftar</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $index => $user)
                                        <tr>
                                            <td>
                                                <strong>{{ $index + 1 }}</strong>
                                            </td>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $user->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $user->email }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($user->role === 'admin')
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-crown"></i> Admin
                                                    </span>
                                                @else
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-user"></i> User
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $user->orders()->count() }} pesanan</span>
                                            </td>
                                            <td class="text-center">
                                                @if($user->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times-circle"></i> Nonaktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-info me-2" data-bs-toggle="modal" data-bs-target="#userModal" onclick="viewUser({{ $user->id }})">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                                @if($user->role !== 'admin')
                                                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        @if($user->is_active)
                                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Nonaktifkan user ini?')">
                                                                <i class="fas fa-lock"></i> Nonaktif
                                                            </button>
                                                        @else
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan user ini?')">
                                                                <i class="fas fa-unlock"></i> Aktif
                                                            </button>
                                                        @endif
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0 text-center py-5">
                    <div class="card-body">
                        <i class="fas fa-user-friends" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada User</h3>
                        <p class="text-muted mb-0">
                            Pengguna akan muncul di sini setelah melakukan registrasi.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Lihat Detail User -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header" style="background-color: #335c67; color: white; border: none;">
                <h5 class="modal-title">
                    <i class="fas fa-user-circle"></i> Detail User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="userDetails">
                <!-- User details akan diisi via JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function viewUser(userId) {
    fetch(`/admin/users/${userId}`)
        .then(response => response.json())
        .then(data => {
            let html = `
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Nama</small>
                    <p class="mb-0" style="color: #2a4a54;">${data.name}</p>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Email</small>
                    <p class="mb-0" style="color: #2a4a54;">
                        <a href="mailto:${data.email}" style="color: #335c67; text-decoration: none;">
                            ${data.email}
                        </a>
                    </p>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Role</small>
                    <p class="mb-0">
                        ${data.role === 'admin' ? 
                            '<span class="badge bg-danger"><i class="fas fa-crown"></i> Admin</span>' : 
                            '<span class="badge bg-primary"><i class="fas fa-user"></i> User</span>'}
                    </p>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Status</small>
                    <p class="mb-0">
                        ${data.is_active ? 
                            '<span class="badge bg-success"><i class="fas fa-check-circle"></i> Aktif</span>' : 
                            '<span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Nonaktif</span>'}
                    </p>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Tanggal Daftar</small>
                    <p class="mb-0" style="color: #2a4a54;">${new Date(data.created_at).toLocaleDateString('id-ID', {year: 'numeric', month: 'long', day: 'numeric'})}</p>
                </div>
                <hr>
                <div class="mb-3">
                    <small class="text-muted fw-bold d-block mb-2">Total Pesanan</small>
                    <p class="mb-0" style="color: #2a4a54;">${data.orders_count} pesanan</p>
                </div>
                <hr>
                <div>
                    <small class="text-muted fw-bold d-block mb-2">Total Belanja</small>
                    <p class="mb-0" style="color: #335c67; font-size: 1.1rem;">
                        <strong>Rp ${data.total_spent.toLocaleString('id-ID')}</strong>
                    </p>
                </div>
            `;
            document.getElementById('userDetails').innerHTML = html;
        });
}
</script>

<style>
    .card {
        border-radius: 8px;
    }

    .badge {
        padding: 6px 10px;
        font-weight: 500;
    }

    .modal-content {
        border-radius: 8px;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection