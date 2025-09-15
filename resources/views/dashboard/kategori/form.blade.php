@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-tags me-2 text-primary"></i>
                        {{ isset($kategori) ? 'Edit Kategori' : 'Tambah Kategori' }}
                    </h1>
                    <p class="text-muted mb-0">{{ isset($kategori) ? 'Ubah data kategori event' : 'Tambahkan kategori event baru' }}</p>
                </div>
                <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Form Kategori Event
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ isset($kategori) ? route('kategori.update', $kategori->id) : route('kategori.store') }}" method="POST">
                        @csrf
                        @if(isset($kategori))
                        @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Nama Kategori -->
                            <div class="col-md-6 my-3">
                                <label for="nama_kategori" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-1 text-primary"></i>
                                    Nama Kategori <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('nama_kategori') is-invalid @enderror"
                                    id="nama_kategori"
                                    name="nama_kategori"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                                    placeholder="Masukkan nama kategori"
                                    required>
                                @error('nama_kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Contoh: Workshop, Seminar, Pelatihan, dll.
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="col-md-6  my-3">
                                <label for="slug" class="form-label fw-semibold">
                                    <i class="fas fa-link me-1 text-primary"></i>
                                    Slug <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    id="slug"
                                    name="slug"
                                    value="{{ old('slug', $kategori->slug ?? '') }}"
                                    placeholder="slug-kategori"
                                    required>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    URL-friendly name (huruf kecil, tanpa spasi, gunakan tanda -)
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="my-3">
                            <label for="deskripsi" class="form-label fw-semibold">
                                <i class="fas fa-align-left me-1 text-primary"></i>
                                Deskripsi
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Masukkan deskripsi kategori (opsional)">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Jelaskan tentang kategori ini untuk memudahkan pengelolaan event
                            </div>
                        </div>
                        <hr>
                        <!-- Status -->
                        <div class="my-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-toggle-on me-1 text-primary"></i>
                                Status
                            </label>
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="is_active"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', $kategori->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <span class="badge bg-success me-2">Aktif</span>
                                    Kategori ini dapat digunakan untuk event
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 pt-3 border-top my-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                {{ isset($kategori) ? 'Update Kategori' : 'Simpan Kategori' }}
                            </button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto generate slug from nama kategori
    document.getElementById('nama_kategori').addEventListener('input', function() {
        const namaKategori = this.value;
        const slug = namaKategori
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with dashes
            .replace(/-+/g, '-') // Replace multiple dashes with single dash
            .trim('-'); // Remove leading/trailing dashes

        document.getElementById('slug').value = slug;
    });

    // Toggle status badge
    document.getElementById('is_active').addEventListener('change', function() {
        const badge = this.parentElement.querySelector('.badge');
        const label = this.parentElement.querySelector('label');

        if (this.checked) {
            badge.className = 'badge bg-success me-2';
            badge.textContent = 'Aktif';
            label.innerHTML = badge.outerHTML + 'Kategori ini dapat digunakan untuk event';
        } else {
            badge.className = 'badge bg-secondary me-2';
            badge.textContent = 'Nonaktif';
            label.innerHTML = badge.outerHTML + 'Kategori ini tidak dapat digunakan untuk event';
        }
    });

    // Form validation feedback
    document.querySelector('form').addEventListener('submit', function(e) {
        const namaKategori = document.getElementById('nama_kategori').value.trim();
        const slug = document.getElementById('slug').value.trim();

        if (!namaKategori) {
            e.preventDefault();
            document.getElementById('nama_kategori').focus();
            return false;
        }

        if (!slug) {
            e.preventDefault();
            document.getElementById('slug').focus();
            return false;
        }

        // Show loading alert and disable submit button
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalContent = submitBtn.innerHTML;
        const isUpdate = submitBtn.textContent.includes('Update');

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>' + (isUpdate ? 'Mengupdate...' : 'Menyimpan...');
        submitBtn.disabled = true;

        // Show loading alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-info alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML =
            '<i class="fas fa-spinner fa-spin me-2"></i>' +
            (isUpdate ? 'Mengupdate' : 'Menyimpan') + ' kategori "' + namaKategori + '"...' +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        document.body.appendChild(alertDiv);

        // Re-enable button and restore content if form submission fails
        setTimeout(function() {
            if (submitBtn.disabled) {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }
        }, 10000); // 10 seconds timeout
    });
</script>
@endpush

@push('styles')
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
        padding: 1.25rem 1.5rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .text-primary {
        color: #007bff !important;
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .invalid-feedback {
        display: block;
    }

    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>
@endpush