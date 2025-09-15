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
        <i class="fas fa-calendar-alt me-2"></i>
        {{ $title ?? '' }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Event
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
                        <h5 class="card-title">Total Event</h5>
                        <h2>{{ $statistics['total_events'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
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
                        <h5 class="card-title">Event Aktif</h5>
                        <h2>{{ $statistics['events_aktif'] }}</h2>
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
                        <h5 class="card-title">Event Draft</h5>
                        <h2>{{ $statistics['events_draft'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-draft2digital fa-2x opacity-75"></i>
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
                        <h5 class="card-title">Event Bulan Ini</h5>
                        <h2>{{ $statistics['events_bulan_ini'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-check fa-2x opacity-75"></i>
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
                    Daftar Event
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Banner</th>
                                <th>Nama Event</th>
                                <th>Kategori</th>
                                <th>Lingkup</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $index => $event)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($event->banner_image)
                                    <img src="{{ asset($event->banner_image) }}" alt="Banner" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                    @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 40px; border-radius: 4px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $event->nama_event }}</strong>
                                    @if($event->deskripsi_singkat)
                                    <br><small class="text-muted">{{ Str::limit($event->deskripsi_singkat, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $event->nama_kategori ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $event->nama_range ?? '-' }}</span>
                                </td>
                                <td>
                                    <small>
                                        <i class="fas fa-calendar me-1"></i>{{ $event->tanggal_mulai ? $event->tanggal_mulai->format('d M Y') : '-' }} - </i>{{ $event->tanggal_selesai ? $event->tanggal_selesai->format('d M Y') : '-' }}<br>
                                        <!-- <i class="fas fa-clock me-1"></i>{{ $event->jam_mulai ? $event->jam_mulai->format('H:i') : '-' }} WIB -->
                                    </small>
                                </td>
                                <td>
                                    @if($event->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                    @elseif($event->status === 'draft')
                                    <span class="badge bg-secondary">Draft</span>
                                    @else
                                    <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-success" title="Kelola Requirements">
                                            <i class="fas fa-tasks"></i>
                                        </a>
                                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(this, '{{ $event->nama_event }}')">
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
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                        <p>Belum ada event yang tersedia</p>
                                        <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i>
                                            Tambah Event Pertama
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
    function confirmDelete(form, namaEvent) {
        const result = confirm(`Apakah Anda yakin ingin menghapus event "${namaEvent}"?\n\nTindakan ini tidak dapat dibatalkan.`);
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
                'Menghapus event "' + namaEvent + '"...' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            document.body.appendChild(alertDiv);

            return true;
        }
        return false;
    }
</script>
@endpush