@extends('layout.main')

@section('content')
<!-- Additional Flash Messages for Validation Errors -->
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <strong>Terjadi kesalahan validasi:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-globe me-2"></i>
        {{ $title ?? '' }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('lingkup.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Lingkup
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Lingkup</h5>
                        <h2>{{ $lingkups->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-globe fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Lingkup Aktif</h5>
                        <h2>{{ $lingkups->where('is_active', true)->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Lingkup Nonaktif</h5>
                        <h2>{{ $lingkups->where('is_active', false)->count() }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-pause-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Rata-rata Lingkup</h5>
                        <h2>{{ $lingkups->count() > 0 ? round($lingkups->count() / max($lingkups->count(), 1), 1) : 0 }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-bar fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row my-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Daftar Lingkup Event
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Lingkup</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lingkups as $index => $lingkup)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <i class="fas fa-globe me-2 text-primary"></i>
                                    {{ $lingkup->nama_range }}
                                </td>
                                <td>{{ $lingkup->deskripsi ?? '-' }}</td>
                                <td>
                                    @if($lingkup->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                    @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>{{ $lingkup->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('lingkup.edit', $lingkup->id) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('lingkup.destroy', $lingkup->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(this, '{{ $lingkup->nama_range }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p>Belum ada lingkup yang tersedia</p>
                                        <a href="{{ route('lingkup.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>
                                            Tambah Lingkup Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert:not(.alert-validation)');

        alerts.forEach(function(alert) {
            // Auto-hide success alerts after 5 seconds
            if (alert.classList.contains('alert-success')) {
                setTimeout(function() {
                    const alertInstance = new bootstrap.Alert(alert);
                    alertInstance.close();
                }, 5000);
            }

            // Auto-hide info and warning alerts after 7 seconds
            if (alert.classList.contains('alert-info') || alert.classList.contains('alert-warning')) {
                setTimeout(function() {
                    const alertInstance = new bootstrap.Alert(alert);
                    alertInstance.close();
                }, 7000);
            }
        });

        // Add smooth animation for alert closing
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.addEventListener('closed.bs.alert', function() {
                alert.style.transition = 'all 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
            });
        });
    });

    // Enhanced delete confirmation
    function confirmDelete(form, namaLingkup) {
        const result = confirm(`Apakah Anda yakin ingin menghapus lingkup "${namaLingkup}"?\n\nTindakan ini tidak dapat dibatalkan.`);
        if (result) {
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
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