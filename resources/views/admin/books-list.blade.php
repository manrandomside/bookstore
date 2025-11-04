@extends('layouts.app')

@section('title', 'Kelola Buku - Bookstoreside')

@section('content')
<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold" style="color: #2a4a54;">
                        <i class="fas fa-book"></i> Kelola Buku
                    </h2>
                    <p class="text-muted">Tambah, edit, dan hapus buku dari koleksi</p>
                </div>
                <button type="button" class="btn fw-bold" style="background-color: #335c67; color: white;" data-bs-toggle="modal" data-bs-target="#bookModal" onclick="resetBookForm()">
                    <i class="fas fa-plus"></i> Tambah Buku
                </button>
            </div>
        </div>
    </div>

    <!-- Books Table -->
    <div class="row">
        <div class="col-12">
            @if($books->count() > 0)
                <div class="card shadow-sm border-0">
                    <div class="card-header" style="background-color: #335c67; color: white; border: none;">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Daftar Buku ({{ $books->count() }})
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #2a4a54;">No</th>
                                        <th style="color: #2a4a54;">Gambar</th>
                                        <th style="color: #2a4a54;">Judul</th>
                                        <th style="color: #2a4a54;">Penulis</th>
                                        <th style="color: #2a4a54;">Kategori</th>
                                        <th class="text-center" style="color: #2a4a54;">Harga</th>
                                        <th class="text-center" style="color: #2a4a54;">Stok</th>
                                        <th class="text-center" style="color: #2a4a54;">Status</th>
                                        <th class="text-center" style="color: #2a4a54;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $index => $book)
                                        <tr>
                                            <td>
                                                <strong>{{ $index + 1 }}</strong>
                                            </td>
                                            <td>
                                                @if($book->image && file_exists(public_path($book->image)))
                                                    <img src="/{{ $book->image }}" alt="{{ $book->title }}" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div style="width: 40px; height: 55px; background-color: #e9ecef; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                                        <i class="fas fa-image" style="color: #adb5bd; font-size: 0.8rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong style="color: #2a4a54;">{{ $book->title }}</strong><br>
                                                <small class="text-muted">{{ $book->isbn }}</small>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $book->author }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $book->category->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                <strong style="color: #335c67;">Rp {{ number_format($book->price, 0, ',', '.') }}</strong>
                                            </td>
                                            <td class="text-center">
                                                @if($book->stock > 0)
                                                    <span class="badge bg-success">{{ $book->stock }}</span>
                                                @else
                                                    <span class="badge bg-danger">0</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($book->is_active)
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
                                                <button type="button" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#bookModal" onclick="editBook({{ $book->id }})">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
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
                        <i class="fas fa-book-open" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h3 class="fw-bold mb-2" style="color: #2a4a54;">Belum Ada Buku</h3>
                        <p class="text-muted mb-4">
                            Mulai tambah buku ke koleksi Anda.
                        </p>
                        <button type="button" class="btn btn-lg fw-bold" style="background-color: #335c67; color: white; border: none;" data-bs-toggle="modal" data-bs-target="#bookModal" onclick="resetBookForm()">
                            <i class="fas fa-plus"></i> Tambah Buku Pertama
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah/Edit Buku -->
<div class="modal fade" id="bookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0">
            <div class="modal-header" style="background-color: #335c67; color: white; border: none;">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus"></i> Tambah Buku
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookForm" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" id="bookId" name="book_id">
                <input type="hidden" id="formMethod" name="_method" value="">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-bold">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback d-block" id="category_idError"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label fw-bold">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" placeholder="ISBN buku" required>
                            <div class="invalid-feedback d-block" id="isbnError"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Buku</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul buku" required>
                        <div class="invalid-feedback d-block" id="titleError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="author" class="form-label fw-bold">Penulis</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Masukkan nama penulis" required>
                        <div class="invalid-feedback d-block" id="authorError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Masukkan deskripsi buku (min 20 karakter)" required></textarea>
                        <div class="invalid-feedback d-block" id="descriptionError"></div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold">Gambar Buku <span class="text-danger" id="imageRequired">*</span></label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/webp">
                        <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Max: 2MB</small>
                        <div class="invalid-feedback d-block" id="imageError"></div>
                        <div id="imagePreview" class="mt-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" placeholder="0" required>
                            </div>
                            <div class="invalid-feedback d-block" id="priceError"></div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="0" required>
                            <div class="invalid-feedback d-block" id="stockError"></div>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Aktifkan buku ini
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
function clearErrors() {
    document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
}

document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px; object-fit: contain; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">`;
        }
        reader.readAsDataURL(this.files[0]);
    }
});

function resetBookForm() {
    document.getElementById('bookForm').reset();
    document.getElementById('bookId').value = '';
    document.getElementById('formMethod').value = '';
    document.getElementById('imagePreview').innerHTML = '';
    document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus"></i> Tambah Buku';
    document.getElementById('bookForm').action = '{{ route("admin.books.store") }}';
    document.getElementById('imageRequired').style.display = 'inline';
    clearErrors();
}

function editBook(bookId) {
    clearErrors();
    fetch(`/admin/books/${bookId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('bookId').value = data.id;
            document.getElementById('category_id').value = data.category_id;
            document.getElementById('isbn').value = data.isbn;
            document.getElementById('title').value = data.title;
            document.getElementById('author').value = data.author;
            document.getElementById('description').value = data.description;
            document.getElementById('price').value = data.price;
            document.getElementById('stock').value = data.stock;
            document.getElementById('is_active').checked = data.is_active;
            document.getElementById('formMethod').value = 'PUT';
            
            if (data.image) {
                document.getElementById('imagePreview').innerHTML = `
                    <div>
                        <p class="text-muted mb-2">Gambar saat ini:</p>
                        <img src="/${data.image}" alt="Current" style="max-width: 200px; max-height: 200px; object-fit: contain; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                        <p class="text-muted mt-2"><small>Upload gambar baru untuk mengganti</small></p>
                    </div>
                `;
                document.getElementById('imageRequired').style.display = 'none';
            }
            
            document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit"></i> Edit Buku';
            document.getElementById('bookForm').action = `/admin/books/${bookId}`;
        })
        .catch(error => {
            console.error('Error fetching book:', error);
            alert('Gagal mengambil data buku');
        });
}

document.getElementById('bookForm').addEventListener('submit', function(e) {
    e.preventDefault();
    clearErrors();
    
    let form = this;
    let submitBtn = form.querySelector('button[type="submit"]');
    let originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    
    // Build FormData manually for better control
    let formData = new FormData();
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    formData.append('category_id', document.getElementById('category_id').value);
    formData.append('isbn', document.getElementById('isbn').value);
    formData.append('title', document.getElementById('title').value);
    formData.append('author', document.getElementById('author').value);
    formData.append('description', document.getElementById('description').value);
    formData.append('price', document.getElementById('price').value);
    formData.append('stock', document.getElementById('stock').value);
    formData.append('is_active', document.getElementById('is_active').checked ? '1' : '0');
    
    // Add image if selected
    let imageInput = document.getElementById('image');
    if (imageInput.files && imageInput.files[0]) {
        formData.append('image', imageInput.files[0]);
    }
    
    // Add _method for PUT requests
    let method = document.getElementById('formMethod').value;
    if (method) {
        formData.append('_method', method);
    }
    
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('bookModal')).hide();
            location.reload();
        }
    })
    .catch(error => {
        console.error('Submit error:', error);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        
        if (error.errors) {
            Object.keys(error.errors).forEach(key => {
                const errorElement = document.getElementById(key + 'Error');
                if (errorElement) {
                    errorElement.textContent = error.errors[key][0];
                }
            });
        } else {
            alert('Terjadi kesalahan: ' + (error.message || 'Gagal menyimpan data'));
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