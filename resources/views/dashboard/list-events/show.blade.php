@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>
        {{ $title }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('list-events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke List Events
            </a>
        </div>

        <!-- Registration Button -->
        @php
        $deadline = \Carbon\Carbon::parse($event->batas_pendaftaran);
        $canRegister = $event->status === 'published' && $deadline->isFuture() && !$isRegistered;

        @endphp


    </div>
</div>

<!-- Event Detail Card -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <!-- Event Banner -->
            @if($event->banner_image)
            <div class="position-relative">
                <img src="{{ asset($event->banner_image) }}"
                    alt="{{ $event->nama_event }}"
                    class="card-img-top"
                    style="height: 300px; object-fit: cover;">

                <!-- Status Badge Overlay -->
                <div class="position-absolute top-0 end-0 m-3">
                    @if($event->status === 'published')
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-check-circle me-1"></i>
                        Published
                    </span>
                    @elseif($event->status === 'draft')
                    <span class="badge bg-warning fs-6">
                        <i class="fas fa-edit me-1"></i>
                        Draft
                    </span>
                    @else
                    <span class="badge bg-danger fs-6">
                        <i class="fas fa-times-circle me-1"></i>
                        Cancelled
                    </span>
                    @endif
                </div>
            </div>
            @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center position-relative" style="height: 300px;">
                <div class="text-center text-muted">
                    <i class="fas fa-image fa-5x mb-3"></i>
                    <h4>No Banner Image</h4>
                </div>

                <!-- Status Badge Overlay -->
                <div class="position-absolute top-0 end-0 m-3">
                    @if($event->status === 'published')
                    <span class="badge bg-success fs-6">
                        <i class="fas fa-check-circle me-1"></i>
                        Published
                    </span>
                    @elseif($event->status === 'draft')
                    <span class="badge bg-warning fs-6">
                        <i class="fas fa-edit me-1"></i>
                        Draft
                    </span>
                    @else
                    <span class="badge bg-danger fs-6">
                        <i class="fas fa-times-circle me-1"></i>
                        Cancelled
                    </span>
                    @endif
                </div>
            </div>
            @endif

            <div class="card-body p-4">
                <!-- Event Title -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="card-title mb-2">{{ $event->nama_event }}</h2>
                        <p class="text-muted">
                            <i class="fas fa-tag me-1"></i>
                            <strong>Kategori:</strong> {{ $event->kategori->nama ?? 'Tidak ada kategori' }}
                        </p>
                    </div>
                </div>

                <!-- Event Info Grid -->
                <div class="row mb-4">
                    <!-- Date Information -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Tanggal Event
                                </h6>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Mulai</small>
                                        <strong>{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('l') }}</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Selesai</small>
                                        <strong>{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('l') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Info -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body">
                                <h6 class="card-title text-warning">
                                    <i class="fas fa-clock me-2"></i>
                                    Batas Pendaftaran
                                </h6>
                                <strong class="text-danger">{{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('l, H:i') }}</small>
                                <br>
                                @php
                                $deadline = \Carbon\Carbon::parse($event->batas_pendaftaran);
                                $now = \Carbon\Carbon::now();
                                $diff = $deadline->diffForHumans($now);
                                @endphp
                                <small class="text-muted">
                                    @if($deadline->isFuture())
                                    <span class="text-success">{{ $diff }}</span>
                                    @else
                                    <span class="text-danger">Sudah berakhir {{ $diff }}</span>
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information -->
                @if($event->lokasi)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title text-success">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Lokasi Event
                                </h6>
                                <p class="mb-0">{{ $event->lokasi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Event Description -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Deskripsi Event
                        </h5>
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                @if($event->deskripsi)
                                <div class="text-muted">
                                    {!! nl2br(e($event->deskripsi)) !!}
                                </div>
                                @else
                                <em class="text-muted">Tidak ada deskripsi untuk event ini.</em>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Requirements (if any) -->
                @if($event->requirements && $event->requirements->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3">
                            <i class="fas fa-list-check me-2"></i>
                            Requirements Event
                        </h5>
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                @foreach($event->requirements as $requirement)
                                <div class="mb-3 p-3 bg-white rounded border-start border-primary border-4">
                                    {!! $requirement->deskripsi !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Additional Event Meta -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title text-info">
                                    <i class="fas fa-info me-2"></i>
                                    Informasi Tambahan
                                </h6>
                                <small class="text-muted d-block">Event dibuat: {{ $event->created_at->format('d M Y, H:i') }}</small>
                                <small class="text-muted d-block">Terakhir diupdate: {{ $event->updated_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="card-title text-secondary">
                                    <i class="fas fa-users me-2"></i>
                                    Status Pendaftaran
                                </h6>
                                @php
                                $deadline = \Carbon\Carbon::parse($event->batas_pendaftaran);
                                $now = \Carbon\Carbon::now();
                                @endphp
                                @if($event->status === 'published' && $deadline->isFuture())
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-door-open me-1"></i>
                                    Pendaftaran Terbuka
                                </span>
                                @elseif($event->status === 'published' && $deadline->isPast())
                                <span class="badge bg-danger fs-6">
                                    <i class="fas fa-door-closed me-1"></i>
                                    Pendaftaran Ditutup
                                </span>
                                @elseif($event->status === 'draft')
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-hourglass-half me-1"></i>
                                    Belum Dipublikasi
                                </span>
                                @else
                                <span class="badge bg-secondary fs-6">
                                    <i class="fas fa-ban me-1"></i>
                                    Event Dibatalkan
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isUserLoggedIn())
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-4">
                @if($isRegistered)
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h4 class="text-success">Anda Sudah Terdaftar!</h4>
                <p class="text-muted">Selamat! Anda sudah terdaftar untuk event ini. Pantau terus informasi update event melalui dashboard.</p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <span class="badge bg-success px-3 py-2 fs-6">
                        <i class="fas fa-calendar-check me-1"></i>
                        Terdaftar pada {{ \Carbon\Carbon::now()->format('d M Y') }}
                    </span>
                </div>
                @elseif($canRegister)
                <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                <h4 class="text-primary">Tertarik dengan Event Ini?</h4>
                <p class="text-muted">Jangan lewatkan kesempatan untuk mengikuti event yang menarik ini. Daftar sekarang sebelum kuota penuh!</p>

                <div class="row justify-content-center mb-3">
                    <div class="col-md-8">
                        <div class="row text-center">
                            <div class="col-md-6 mb-2">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Tanggal Event</small>
                                    <strong>{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Batas Pendaftaran</small>
                                    <strong class="text-danger">{{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg px-5" data-bs-toggle="modal" data-bs-target="#registrationModal">
                    <i class="fas fa-user-plus me-2"></i>
                    Daftar Event Sekarang
                </button>
                @elseif($event->status !== 'published')
                <i class="fas fa-hourglass-half fa-3x text-warning mb-3"></i>
                <h4 class="text-warning">Event Belum Dipublikasi</h4>
                <p class="text-muted">Event ini masih dalam tahap persiapan dan belum dipublikasi. Silakan cek kembali nanti.</p>
                @elseif($deadline->isPast())
                <i class="fas fa-door-closed fa-3x text-danger mb-3"></i>
                <h4 class="text-danger">Pendaftaran Ditutup</h4>
                <p class="text-muted">Maaf, periode pendaftaran untuk event ini sudah berakhir pada {{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y, H:i') }}.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body text-center py-4">
                <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                <h4 class="text-primary">Login untuk Mendaftar</h4>
                <p class="text-muted">Untuk mendaftar event ini, Anda perlu login terlebih dahulu ke akun Anda.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Login Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Registration Confirmation Modal -->
@if(isUserLoggedIn() && $canRegister)
<div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registrationModalLabel">
                    <i class="fas fa-user-plus me-2"></i>
                    Konfirmasi Pendaftaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-question-circle fa-4x text-primary mb-3"></i>
                    <h4>Daftar Event Ini?</h4>
                </div>

                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <h6 class="card-title">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $event->nama_event }}
                        </h6>
                        <p class="card-text mb-2">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                            </small>
                        </p>
                        <p class="card-text">
                            <small class="text-muted">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Batas pendaftaran: <strong>{{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y, H:i') }}</strong>
                            </small>
                        </p>
                    </div>
                </div>

                <!-- <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Pastikan:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Anda dapat menghadiri event pada tanggal yang telah ditentukan</li>
                        <li>Anda telah membaca semua requirements event</li>
                        <li>Data profil Anda sudah lengkap dan benar</li>
                    </ul>
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Batal
                </button>
                <button type="button" class="btn btn-primary" id="confirmRegistration">
                    <i class="fas fa-check me-1"></i>
                    Ya, Daftar Sekarang!
                </button>
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .border-start {
        border-left-width: 4px !important;
    }

    .fs-6 {
        font-size: 0.875rem;
    }

    /* Modal customizations */
    .modal-content {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }

    /* Registration button states */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card:hover {
            transform: none;
        }

        .card-img-top {
            height: 200px !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('confirmRegistration');
        const modal = new bootstrap.Modal(document.getElementById('registrationModal'));

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                // Add loading state
                const originalHtml = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mendaftar...';
                this.disabled = true;
                this.classList.add('btn-loading');

                // Make AJAX request
                fetch('{{ route("list-events.register", $event->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showAlert('success', data.message);

                            // Close modal
                            modal.hide();

                            // Reload page after short delay to update registration status
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            // Show error message
                            showAlert('danger', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('danger', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
                    })
                    .finally(() => {
                        // Reset button state
                        this.innerHTML = originalHtml;
                        this.disabled = false;
                        this.classList.remove('btn-loading');
                    });
            });
        }

        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.registration-alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show registration-alert`;
            alertDiv.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

            // Insert alert at the top of the content
            const content = document.querySelector('.container-fluid');
            content.insertBefore(alertDiv, content.firstChild);

            // Auto dismiss after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            }
        }
    });
</script>
@endpush

@endsection