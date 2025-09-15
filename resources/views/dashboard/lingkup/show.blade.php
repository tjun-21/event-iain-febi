@extends('layout.main')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-globe me-2 text-primary"></i>
                        Detail Lingkup: {{ $lingkup->nama_range }}
                    </h1>
                    <p class="text-muted mb-0">Informasi detail lingkup event</p>
                </div>
                <div class="btn-group">
                    <a href="{{ route('lingkup.edit', $lingkup->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                    <a href="{{ route('lingkup.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Detail Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Lingkup
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Nama Lingkup</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">
                                    <i class="fas fa-globe me-2 text-primary"></i>
                                    {{ $lingkup->nama_range }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Slug</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">
                                    <i class="fas fa-link me-2 text-primary"></i>
                                    {{ $lingkup->slug }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Status</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">
                                    @if($lingkup->is_active)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Aktif
                                    </span>
                                    @else
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Nonaktif
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Dibuat Pada</label>
                                <div class="form-control-plaintext border rounded p-2 bg-light">
                                    <i class="fas fa-calendar me-2 text-primary"></i>
                                    {{ $lingkup->created_at->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Deskripsi</label>
                        <div class="form-control-plaintext border rounded p-3 bg-light">
                            @if($lingkup->deskripsi)
                            <i class="fas fa-align-left me-2 text-primary"></i>
                            {{ $lingkup->deskripsi }}
                            @else
                            <i class="fas fa-minus me-2 text-muted"></i>
                            <em class="text-muted">Tidak ada deskripsi</em>
                            @endif
                        </div>
                    </div>

                    @if($lingkup->updated_at != $lingkup->created_at)
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Terakhir Diupdate</label>
                        <div class="form-control-plaintext border rounded p-2 bg-light">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            {{ $lingkup->updated_at->format('d F Y, H:i') }} WIB
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Aksi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('lingkup.edit', $lingkup->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>
                            Edit Lingkup
                        </a>

                        <form action="{{ route('lingkup.destroy', $lingkup->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(this, '{{ $lingkup->nama_range }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>
                                Hapus Lingkup
                            </button>
                        </form>

                        <a href="{{ route('lingkup.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-list me-1"></i>
                            Daftar Lingkup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enhanced delete confirmation
    function confirmDelete(form, namaLingkup) {
        const result = confirm(`Apakah Anda yakin ingin menghapus lingkup "${namaLingkup}"?\n\nTindakan ini tidak dapat dibatalkan.`);
        if (result) {
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghapus...';
            submitBtn.disabled = true;

            // Show loading alert
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-info alert-dismissible fade show position-fixed';
            alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alertDiv.innerHTML =
                '<i class="fas fa-spinner fa-spin me-2"></i>' +
                'Menghapus lingkup "' + namaLingkup + '"...' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.body.appendChild(alertDiv);

            return true;
        }
        return false;
    }
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

    .form-control-plaintext {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .text-primary {
        color: #007bff !important;
    }
</style>
@endpush