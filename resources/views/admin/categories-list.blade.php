@extends('layouts.app')

@section('title', 'Kelola Kategori - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        <i class="fas fa-list"></i> Kelola Kategori
                    </h2>
                    <p class="text-muted">Tambah, edit, dan hapus kategori buku</p>
                </div>
                <button type="button" class="btn fw-bold" style="background-color: #335c67; color: white;" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </button>
            </div>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="row">
        <div class="col-12">
            @if($categories->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Daftar Kategori ({{ $categories->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No</th>
                                        <th style="color: #2a4a54;">Nama Kategori</th>
                                        <th style="color: #2a4a54;">Deskripsi</th>
                                        <th class="text-center" style="color: #2a4a54;">Jumlah Buku</th>
                                        <th class="text-center" style="color: #2a4a54;">Status</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $category)
                                        <tr>
                                            <td>
                                                <strong>{{ $index + 1 }}</strong>
                                            </td>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $category->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ Str::limit($category->description, 50) }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info">{{ $category->books()->count() }} buku</span>
                                            </td>
                                            <td class="text-center">
                                                @if($category->is_active)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times-circle"></i> Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="editCategory({{ $category->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
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
                        <i class="fas fa-folder-open" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada Kategori</h3>
                        <p class="text-muted mb-4">
                            Mulai buat kategori baru untuk mengorganisir koleksi buku Anda.
                        </p>
                        <button type="button" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;" data-bs-toggle="modal" data-bs-target="#categoryModal">
                            <i class="fas fa-plus"></i> Buat Kategori Pertama
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Kategori -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header" style="background-color: #335c67; color: white; border: none;">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus"></i> Tambah Kategori
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm" method="POST" novalidate>
                @csrf
                <input type="hidden" id="categoryId" name="category_id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Kategori</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama kategori" required>
                        <div class="invalid-feedback d-block" id="nameError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukkan deskripsi kategori" required></textarea>
                        <div class="invalid-feedback d-block" id="descriptionError"></div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Aktifkan kategori ini
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn fw-bold" style="background-color: #335c67; color: white;">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Reset form untuk tambah baru
document.getElementById('categoryModal').addEventListener('show.bs.modal', function (e) {
    if (!e.relatedTarget || !e.relatedTarget.onclick) {
        // Ini adalah tombol tambah, bukan edit
        document.getElementById('categoryForm').reset();
        document.getElementById('categoryId').value = '';
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus"></i> Tambah Kategori';
        document.getElementById('categoryForm').action = '{{ route("admin.categories.store") }}';
        document.getElementById('categoryForm').method = 'POST';
        document.querySelector('input[name="_method"]')?.remove();
    }
});

// Fungsi edit kategori
function editCategory(categoryId) {
    // Fetch kategori data
    fetch(`/admin/categories/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('categoryId').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('is_active').checked = data.is_active;
            
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Kategori';
            
            // Update form action
            let form = document.getElementById('categoryForm');
            form.action = `/admin/categories/${categoryId}`;
            
            // Add PUT method
            let methodInput = document.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
        });
}

// Submit form
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let form = this;
    let formData = new FormData(form);
    
    fetch(form.action, {
        method: form.method === 'POST' ? 'POST' : 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
            location.reload();
        } else {
            // Show errors
            if (data.errors.name) {
                document.getElementById('nameError').textContent = data.errors.name[0];
            }
            if (data.errors.description) {
                document.getElementById('descriptionError').textContent = data.errors.description[0];
            }
        }
    });
});
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