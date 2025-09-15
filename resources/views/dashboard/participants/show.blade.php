@extends('layout.main')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Profile Card -->
            <div class="profile-header-card mb-4">
                <div class="profile-background"></div>
                <div class="profile-content">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar">
                                <div class="avatar-circle">
                                    <i class="fas fa-user fa-3x text-white"></i>
                                </div>
                                <div class="online-indicator"></div>
                            </div>
                            <h4 class="profile-name mt-3 mb-1">{{ $peserta->nama }}</h4>
                            <span class="participant-badge">{{ $peserta->jenis_peserta }}</span>
                            <div class="participant-id">ID: {{ $peserta->id }}</div>
                        </div>
                        <div class="col-md-9">
                            <div class="event-info-card">
                                <h5 class="event-title">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    {{ $peserta['nama_event'] ?? 'Event tidak tersedia' }}
                                </h5>
                                <div class="event-meta">
                                    <span class="event-date">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ isset($peserta['tanggal_mulai']) ? \Carbon\Carbon::parse($peserta['tanggal_mulai'])->format('d M Y') : '-' }}
                                        -
                                        {{ isset($peserta['tanggal_selesai']) ? \Carbon\Carbon::parse($peserta['tanggal_selesai'])->format('d M Y') : '-' }}
                                    </span>
                                </div>
                                <div class="status-badges mt-3">
                                    <span class="status-badge {{ $peserta['status_pendaftaran'] == 'approved' ? 'status-approved' : 'status-confirmed' }}">
                                        <i class="fas fa-user-check me-1"></i>
                                        {{ ucfirst($peserta['status_pendaftaran']) }}
                                    </span>

                                    @if($peserta['status'] == 'registered')
                                    <span class="status-badge status-registered">
                                        <i class="fas fa-ticket-alt me-1"></i>
                                        Registered
                                    </span>
                                    @elseif($peserta['status'] == 'confirmed')
                                    <span class="status-badge status-confirmed">
                                        <i class="fas fa-ticket-alt me-1"></i>
                                        Confirmed
                                    </span>
                                    @elseif($peserta['status'] == 'cancelled')
                                    <span class="status-badge status-cancelled">
                                        <i class="fas fa-ticket-alt me-1"></i>
                                        Cancelled
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="modern-tabs">
                <nav class="nav nav-pills nav-fill mb-4">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#personal-info">
                        <i class="fas fa-user me-2"></i>Informasi Personal
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#event-details">
                        <i class="fas fa-calendar me-2"></i>Detail Event
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#registration-status">
                        <i class="fas fa-cogs me-2"></i>Status & Pengaturan
                    </button>
                </nav>

                <div class="tab-content">
                    <!-- Personal Information Tab -->
                    <div class="tab-pane fade show active" id="personal-info">
                        <div class="info-grid">
                            <div class="info-card">
                                <style>
                                    .info-grid {
                                        display: grid;
                                        grid-template-columns: 1fr 1fr;
                                        gap: 1.5rem;
                                    }

                                    @media (max-width: 768px) {
                                        .info-grid {
                                            grid-template-columns: 1fr;
                                        }
                                    }
                                </style>
                                <div class="info-header">
                                    <i class="fas fa-id-card text-primary"></i>
                                    <h6>Identitas & Personal</h6>
                                </div>
                                <div class="info-content">
                                    <div class="info-item">
                                        <label>NIK</label>
                                        <span>{{ $peserta['nik'] ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>NIM</label>
                                        <span>{{ $peserta['nim'] ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Jenis Kelamin</label>
                                        <span>{{ $peserta['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Asal</label>
                                        <span>{{ $peserta['asal'] ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-header">
                                    <i class="fas fa-address-book text-success"></i>
                                    <h6>Kontak & Alamat</h6>
                                </div>
                                <div class="info-content">
                                    <div class="info-item">
                                        <label>Email</label>
                                        <span>{{ $peserta['email'] ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>No Telepon</label>
                                        <span>{{ $peserta['no_telepon'] ?? '-' }}</span>
                                    </div>
                                    <div class="info-item">
                                        <label>Alamat</label>
                                        <span>{{ $peserta['alamat'] ?? 'Alamat tidak tersedia' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card full-width">
                                <div class="info-header">
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                    <h6>Alamat</h6>
                                </div>
                                <div class="info-content">
                                    <div class="info-item">
                                        <span>{{ $peserta['alamat'] ?? 'Alamat tidak tersedia' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Event Details Tab -->
                    <div class="tab-pane fade" id="event-details">
                        <div class="timeline-container">
                            <div class="timeline-item">
                                <div class="timeline-marker timeline-start"></div>
                                <div class="timeline-content">
                                    <h6>Event Dimulai</h6>
                                    <p>{{ isset($peserta['tanggal_mulai']) ? \Carbon\Carbon::parse($peserta['tanggal_mulai'])->format('d M Y') : 'Tanggal belum tersedia' }}</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker timeline-register"></div>
                                <div class="timeline-content">
                                    <h6>Pendaftaran Event</h6>
                                    <p>{{ isset($peserta['tanggal_pendaftaran']) ? \Carbon\Carbon::parse($peserta['tanggal_pendaftaran'])->format('d M Y H:i') : 'Belum terdaftar' }}</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker {{ isset($peserta['tanggal_konfirmasi']) && $peserta['tanggal_konfirmasi'] ? 'timeline-confirmed' : 'timeline-confirmed' }}"></div>
                                <div class="timeline-content">
                                    <h6>Konfirmasi</h6>
                                    <p class="{{ !isset($peserta['tanggal_konfirmasi']) || !$peserta['tanggal_konfirmasi'] ? 'text-danger' : '' }}">
                                        {{ isset($peserta['tanggal_konfirmasi']) && $peserta['tanggal_konfirmasi'] ? \Carbon\Carbon::parse($peserta['tanggal_konfirmasi'])->format('d M Y H:i') : 'Belum dikonfirmasi' }}
                                    </p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker timeline-end"></div>
                                <div class="timeline-content">
                                    <h6>Event Selesai</h6>
                                    <p>{{ isset($peserta['tanggal_selesai']) ? \Carbon\Carbon::parse($peserta['tanggal_selesai'])->format('d M Y') : 'Tanggal belum tersedia' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Status Tab -->
                    <div class="tab-pane fade" id="registration-status">
                        <div class="status-management-card">
                            <h5 class="mb-4">
                                <i class="fas fa-cogs me-2"></i>
                                Manajemen Status Peserta
                            </h5>

                            <div class="current-status mb-4">
                                <h6>Status Saat Ini:</h6>
                                <div class="status-display">
                                    <span class="current-status-badge {{ $peserta['status'] == 'registered' ? 'status-registered' : ($peserta['status'] == 'confirmed' ? 'status-confirmed' : 'status-cancelled') }}">
                                        {{ ucfirst($peserta['status']) }}
                                    </span>
                                </div>
                            </div>

                            <form action="{{ route('participants.update', $peserta['id']) }}" method="POST" class="status-update-form">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="status" class="form-label">Ubah Status Registrasi:</label>
                                    <div class="status-options">
                                        <div class="status-option">
                                            <input type="radio" id="registered" name="status" value="registered" {{ $peserta['status'] == 'registered' ? 'checked' : '' }}>
                                            <label for="registered" class="status-option-label status-registered">
                                                <i class="fas fa-check-circle me-2"></i>
                                                <div>
                                                    <strong>Registered</strong>
                                                    <small>Peserta telah terdaftar</small>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="status-option">
                                            <input type="radio" id="confirmed" name="status" value="confirmed" {{ $peserta['status'] == 'confirmed' ? 'checked' : '' }}>
                                            <label for="confirmed" class="status-option-label status-confirmed">
                                                <i class="fas fa-clock me-2"></i>
                                                <div>
                                                    <strong>Confirmed</strong>
                                                    <small>Melakukan Verifikasi Peserta</small>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="status-option">
                                            <input type="radio" id="cancelled" name="status" value="cancelled" {{ $peserta['status'] == 'cancelled' ? 'checked' : '' }}>
                                            <label for="cancelled" class="status-option-label status-cancelled">
                                                <i class="fas fa-times-circle me-2"></i>
                                                <div>
                                                    <strong>Cancelled</strong>
                                                    <small>Registrasi Di Tolak</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-update">
                                    <i class="fas fa-save me-2"></i>
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    :root {
        --primary-color: #667eea;
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --background-light: #f8fafc;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 12px;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* Profile Header Card */
    .profile-header-card {
        position: relative;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .profile-background {
        height: 120px;
        background: var(--primary-gradient);
        position: relative;
    }

    .profile-background::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,100 1000,0 1000,100"/></svg>');
        background-size: cover;
    }

    .profile-content {
        position: relative;
        padding: 2rem;
        margin-top: -60px;
    }

    .profile-avatar {
        position: relative;
        display: inline-block;
    }

    .avatar-circle {
        width: 120px;
        height: 120px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid white;
        box-shadow: var(--shadow-lg);
        position: relative;
    }

    .online-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 20px;
        height: 20px;
        background: var(--success-color);
        border-radius: 50%;
        border: 3px solid white;
    }

    .profile-name {
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
    }

    .participant-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: var(--primary-gradient);
        color: white;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        margin: 0.5rem 0;
    }

    .participant-id {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .event-info-card {
        background: var(--background-light);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
    }

    .event-title {
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .event-meta {
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .status-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    .status-approved {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-confirmed {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-registered {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-cancelled {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* Modern Tabs */
    .modern-tabs .nav-pills .nav-link {
        background: white;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        margin: 0 0.25rem;
        padding: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .modern-tabs .nav-pills .nav-link:hover {
        background: var(--background-light);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .modern-tabs .nav-pills .nav-link.active {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .info-card.full-width {
        grid-column: 1 / -1;
    }

    .info-header {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        background: var(--background-light);
        border-bottom: 1px solid var(--border-color);
    }

    .info-header i {
        font-size: 1.25rem;
        margin-right: 0.5rem;
    }

    .info-header h6 {
        margin: 0;
        font-weight: 600;
        color: var(--text-primary);
    }

    .info-content {
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item label {
        font-weight: 500;
        color: var(--text-secondary);
        margin: 0;
        min-width: 100px;
    }

    .info-item span {
        color: var(--text-primary);
        font-weight: 500;
    }

    /* Timeline */
    .timeline-container {
        position: relative;
        padding: 2rem;
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        left: 2rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--border-color);
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }

    .timeline-marker {
        position: absolute;
        left: -8px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: var(--shadow-sm);
    }

    .timeline-start {
        background: var(--success-color);
    }

    .timeline-register {
        background: var(--info-color);
    }

    .timeline-confirmed {
        background: var(--success-color);
    }

    .timeline-confirmed {
        background: var(--warning-color);
    }

    .timeline-end {
        background: var(--danger-color);
    }

    .timeline-content h6 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .timeline-content p {
        color: var(--text-secondary);
        margin: 0;
    }

    /* Status Management */
    .status-management-card {
        background: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
    }

    .current-status-badge {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        display: inline-block;
    }

    .status-options {
        display: grid;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .status-option {
        position: relative;
    }

    .status-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .status-option-label {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .status-option input[type="radio"]:checked+.status-option-label {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .status-option-label:hover {
        background: var(--background-light);
        transform: translateY(-2px);
    }

    .status-option-label div {
        margin-left: 0.5rem;
    }

    .status-option-label strong {
        display: block;
        color: var(--text-primary);
        font-weight: 600;
    }

    .status-option-label small {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Buttons */
    .btn-update {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-back {
        background: white;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: var(--background-light);
        color: var(--text-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        text-decoration: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-content {
            text-align: center;
        }

        .profile-content .row {
            flex-direction: column;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .modern-tabs .nav-pills .nav-link {
            margin: 0.25rem 0;
            padding: 0.75rem;
        }

        .status-options {
            grid-template-columns: 1fr;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .tab-pane.show {
        animation: fadeInUp 0.5s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add smooth transitions and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Status update form animation
        const statusForm = document.querySelector('.status-update-form');
        if (statusForm) {
            statusForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('.btn-update');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
                submitBtn.disabled = true;
            });
        }

        // Tab switching animation
        const tabTriggers = document.querySelectorAll('[data-bs-toggle="pill"]');
        tabTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                // Remove active state from all triggers
                tabTriggers.forEach(t => t.classList.remove('active'));
                // Add active state to clicked trigger
                this.classList.add('active');
            });
        });
    });
</script>
@endpush