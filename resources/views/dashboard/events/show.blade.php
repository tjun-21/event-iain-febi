@extends('layout.main')

@section('content')
@if(!$event)
<div class="alert alert-danger">
    <h4>Event tidak ditemukan!</h4>
    <p>Event yang Anda cari tidak ditemukan atau mungkin telah dihapus.</p>
    <a href="{{ route('events.index') }}" class="btn btn-primary">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali ke Daftar Event
    </a>
</div>
@else
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>
        Detail Event
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>

        </div>
    </div>
</div>

<div class="row">
    <!-- Main Content -->
    <div class="col-md-8">
        <!-- Banner Image -->
        @if(isset($event->banner_image) && $event->banner_image)
        <div class="card mb-4">
            <div class="card-body p-0">
                <img src="{{ asset($event->banner_image) }}"
                    alt="Banner {{ $event->nama_event ?? 'Event' }}"
                    class="img-fluid w-100"
                    style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
        @endif

        <!-- Event Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Event
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h3 class="text-primary mb-3">{{ $event->nama_event }}</h3>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-tag me-2 text-primary"></i>
                                    <strong>Kategori:</strong>
                                    <span class="badge bg-primary">{{ $event->nama_kategori ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="fas fa-globe me-2 text-info"></i>
                                    <strong>Lingkup:</strong>
                                    <span class="badge bg-info">{{ $event->nama_range ?? '-' }}</span>
                                </p>
                            </div>
                        </div>

                        @if($event->deskripsi)
                        <div class="mb-3">
                            <h6><i class="fas fa-file-text me-2"></i>Deskripsi Event</h6>
                            <div class="border-start border-3 border-secondary ps-3">
                                {!! nl2br(e($event->deskripsi)) !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Jadwal Event
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tanggal Mulai</h6>
                                <p class="mb-0 text-muted">
                                    {{ $event->tanggal_mulai ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Batas Pendaftaran</h6>
                                <p class="mb-0 text-muted">
                                    {{ $event->batas_pendaftaran ? \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        @if($event->tanggal_selesai)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tanggal Selesai</h6>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($event->batas_submission)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Batas Submission</h6>
                                <p class="mb-0 text-muted">
                                    {{ \Carbon\Carbon::parse($event->batas_submission)->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                @php
                $duration = '';
                if($event->tanggal_mulai && $event->tanggal_selesai) {
                $tanggalMulai = \Carbon\Carbon::parse($event->tanggal_mulai);
                $tanggalSelesai = \Carbon\Carbon::parse($event->tanggal_selesai);
                $diff = $tanggalMulai->diffInDays($tanggalSelesai);
                if($diff == 0) {
                $duration = 'Satu hari';
                } else {
                $duration = ($diff + 1) . ' hari';
                }
                }
                @endphp

                @if($duration)
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Durasi Event:</strong> {{ $duration }}
                </div>
                @endif
            </div>
        </div>

        <!-- Additional Information -->
        @if($event->id_created_by)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Tambahan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <i class="fas fa-user me-2 text-primary"></i>
                            <strong>Dibuat oleh ID:</strong> {{ $event->user }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-2">
                            <i class="fas fa-link me-2 text-info"></i>
                            <strong>Slug:</strong>
                            <code>{{ $event->slug }}</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Requirements Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Requirements Event
                </h5>
                <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-cog me-1"></i>
                    Kelola Requirements
                </a>
            </div>
            <div class="card-body">
                @if($requirements && $requirements->count() > 0)
                <div class="mb-4">
                    <ul class="list-unstyled requirements-list">
                        @foreach($requirements as $index => $requirement)
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3 mt-1">
                                    <span class="badge bg-primary rounded-circle" style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">
                                        {{ $index + 1 }}
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="requirement-content p-3 bg-light rounded border">
                                        {!! $requirement->deskripsi !!}
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Dibuat {{ $requirement->created_at->diffForHumans() }}
                                            @if($requirement->updated_at != $requirement->created_at)
                                            • Diperbarui {{ $requirement->updated_at->diffForHumans() }}
                                            @endif
                                        </small>
                                        <a href="{{ route('event-requirements.show', [$event->id, $requirement->id]) }}" class="btn btn-sm btn-outline-info ms-2">
                                            <i class="fas fa-eye me-1"></i>
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="text-center mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total {{ $requirements->count() }} requirements untuk event ini
                    </small>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">Belum Ada Requirements</h6>
                    <p class="text-muted small mb-3">Event ini belum memiliki requirements yang ditetapkan.</p>
                    <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Requirements
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Status Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-flag me-2"></i>
                    Status Event
                </h6>
            </div>
            <div class="card-body text-center">
                @if($event->status === 'published')
                <div class="text-success mb-2">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
                <h5 class="text-success mb-0">Published</h5>
                <p class="text-muted small">Event sudah dipublikasikan</p>
                @elseif($event->status === 'draft')
                <div class="text-warning mb-2">
                    <i class="fas fa-edit fa-3x"></i>
                </div>
                <h5 class="text-warning mb-0">Draft</h5>
                <p class="text-muted small">Event masih dalam tahap draft</p>
                @else
                <div class="text-danger mb-2">
                    <i class="fas fa-times-circle fa-3x"></i>
                </div>
                <h5 class="text-danger mb-0">Cancelled</h5>
                <p class="text-muted small">Event telah dibatalkan</p>
                @endif
            </div>
        </div>

        <!-- Event Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info me-2"></i>
                    Detail Event
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2 p-2 bg-light rounded">
                    <div>
                        <i class="fas fa-calendar-plus me-2 text-muted"></i>
                        <strong>Dibuat</strong>
                    </div>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($event->created_at)->format('d M Y H:i') }}</small>
                </div>

                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                    <div>
                        <i class="fas fa-calendar-edit me-2 text-muted"></i>
                        <strong>Diupdate</strong>
                    </div>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($event->updated_at)->format('d M Y H:i') }}</small>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Event
                    </a>

                    <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-success">
                        <i class="fas fa-tasks me-1"></i>
                        Kelola Requirements
                    </a>

                    @if($event->status === 'draft')
                    <form action="{{ route('events.update', $event->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="published">
                        <input type="hidden" name="quick_action" value="publish">
                        <button type="submit" class="btn btn-success w-100" onclick="return confirm('Publikasikan event ini?')">
                            <i class="fas fa-upload me-1"></i>
                            Publikasikan
                        </button>
                    </form>
                    @endif

                    @if($event->status === 'published')
                    <form action="{{ route('events.update', $event->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="draft">
                        <input type="hidden" name="quick_action" value="unpublish">
                        <button type="submit" class="btn btn-warning w-100" onclick="return confirm('Kembalikan ke draft?')">
                            <i class="fas fa-undo me-1"></i>
                            Jadikan Draft
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete('{{ $event->nama_event }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .requirements-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .requirements-list li:last-child {
        border-bottom: none;
    }

    .requirement-content {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        min-height: 100px;
    }

    .requirement-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.375rem;
        margin: 10px 0;
    }

    .requirement-content table {
        width: 100%;
        margin: 15px 0;
        border-collapse: collapse;
    }

    .requirement-content table td,
    .requirement-content table th {
        border: 1px solid #dee2e6;
        padding: 8px;
    }

    .requirement-content blockquote {
        border-left: 4px solid #007bff;
        padding-left: 15px;
        margin: 15px 0;
        font-style: italic;
        background-color: #f8f9fa;
        padding: 10px 15px;
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .requirement-content pre {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 15px;
        overflow-x: auto;
    }

    .requirement-content code {
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 0.25rem;
        font-family: 'Courier New', monospace;
    }

    .requirement-content ul,
    .requirement-content ol {
        padding-left: 20px;
        margin: 10px 0;
    }

    .requirement-content li {
        margin-bottom: 5px;
    }

    .requirement-bullet {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-top: 0.4rem;
    }

    .requirement-bullet.mandatory {
        background-color: #dc3545;
    }

    .requirement-bullet.optional {
        background-color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(namaEvent) {
        return confirm(`Apakah Anda yakin ingin menghapus event "${namaEvent}"?\n\nTindakan ini tidak dapat dibatalkan.`);
    }

    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert:not(.alert-light):not(.alert-info)');

        alerts.forEach(function(alert) {
            if (alert.classList.contains('alert-success')) {
                setTimeout(function() {
                    const alertInstance = new bootstrap.Alert(alert);
                    alertInstance.close();
                }, 5000);
            }
        });
    });
</script>
@endpush

@endif
@endsection