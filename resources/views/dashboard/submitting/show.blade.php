@extends('layout.main')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header Event Card -->
            <div class="profile-header-card mb-4">
                <div class="profile-background"></div>
                <div class="profile-content">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="profile-avatar">
                                <div class="avatar-circle">
                                    <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                </div>
                            </div>
                            <h4 class="profile-name mt-3 mb-1">{{ $event->nama_event ?? '-' }}</h4>
                            <span class="participant-badge">{{ $event->kategori->nama_kategori ?? '-' }}</span>

                        </div>
                        <div class="col-md-9">
                            <div class="event-info-card">
                                <h5 class="event-title">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    {{ $event->nama_event ?? '-' }}
                                </h5>
                                <div class="event-meta">
                                    <span class="event-date">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ isset($event->tanggal_mulai) ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') : '-' }}
                                        -
                                        {{ isset($event->tanggal_selesai) ? \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '-' }}
                                    </span>
                                    <span class="ms-3">
                                        <i class="fas fa-tag me-1"></i> {{ $event->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </div>
                                <div class="status-badges mt-3">
                                    <span class="status-badge {{ $event->status == 'published' ? 'status-approved' : ($event->status == 'draft' ? 'status-registered' : 'status-cancelled') }}">
                                        <i class="fas fa-info-circle me-1"></i>
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements List -->
            <!-- <div class="modern-card shadow mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <i class="fas fa-list-alt me-2"></i> Persyaratan Event
                </div>
                <div class="card-body">
                    @if(isset($event->requirements) && count($event->requirements))
                    <ul class="list-group list-group-flush">
                        @foreach($event->requirements as $req)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $req->nama_requirement }}</span>
                            <span class="badge bg-gradient-primary text-white">{{ $req->jenis_requirement }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="text-muted">Belum ada persyaratan untuk event ini.</div>
                    @endif
                </div>
            </div> -->

            <!-- Upload Form -->
            @if(!isset($alreadySubmitted) || !$alreadySubmitted)
            <div class="card modern-card shadow-lg border-0 mb-5 animate__animated animate__fadeInUp">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                    <i class="fas fa-cloud-upload-alt fa-2x me-3"></i>
                    <div>
                        <h4 class="mb-0">Submit Your File</h4>
                        <small class="text-light">Upload dokumen Anda di sini.</small>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('submitting.store') }}" method="POST" enctype="multipart/form-data" class="modern-upload-form">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">
                        <div class="alert bg-warning mb-3" style="font-size:0.97rem;">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Perhatian:</strong> Anda hanya dapat melakukan submitting file satu kali untuk event ini. Pastikan file yang diupload sudah benar.
                        </div>
                        <div class="mb-4">
                            <label for="file" class="form-label fw-bold">Pilih File</label>
                            <div class="input-group">
                                <span class="input-group-text bg-gradient-primary text-white"><i class="fas fa-file-upload"></i></span>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                            <small class="text-muted">Format yang didukung: PDF, Word, Maksimal 10MB.</small>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-gradient-primary px-4 py-2">
                                <i class="fas fa-paper-plane me-2"></i> Submit File
                            </button>
                            <div class="upload-progress visually-hidden" id="uploadProgress">
                                <div class="progress" style="width:180px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%" id="progressBar"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card modern-card shadow-lg border-0 mb-5 animate__animated animate__fadeInUp">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <h4 class="mb-0">Anda sudah melakukan submitting</h4>
                        <small class="text-light">File Anda sudah terkirim untuk event ini.</small>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="alert bg-success mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Anda sudah melakukan submitting untuk event ini.
                    </div>
                    @if(isset($submittedFile) && $submittedFile)
                    <div class="submitted-file-info p-3 rounded bg-light border">
                        <div class="mb-2">
                            <strong>Nama File:</strong> {{ $submittedFile->original_name }}
                        </div>

                        <div class="mb-2">
                            <strong>Status:</strong>
                            @php
                            $statusClass = 'bg-gradient-primary';
                            if ($submittedFile->status === 'pending') $statusClass = 'bg-warning text-dark';
                            elseif ($submittedFile->status === 'approved') $statusClass = 'bg-success text-white';
                            elseif ($submittedFile->status === 'rejected') $statusClass = 'bg-danger text-white';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($submittedFile->status) }}</span>
                        </div>
                        <div class="mb-2">
                            <strong>Waktu Submit:</strong> {{ \Carbon\Carbon::parse($submittedFile->created_at)->format('d M Y H:i') }}
                        </div>
                        <div class="mb-2">
                            <strong>Download:</strong> <a href="/{{ $submittedFile->file_path }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fas fa-download me-1"></i> Download</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

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
        --border-radius: 18px;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

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

    .profile-content {
        position: relative;
        padding: 2rem;
        margin-top: -60px;
    }

    .profile-avatar .avatar-circle {
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

    .modern-card {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        background: white;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .modern-upload-form .input-group-text {
        border-radius: 12px 0 0 12px;
        background: var(--primary-gradient);
        color: #fff;
        font-size: 1.2rem;
    }

    .modern-upload-form .form-control {
        border-radius: 0 12px 12px 0;
        font-size: 1rem;
    }

    .progress {
        height: 18px;
        border-radius: 12px;
        background: #f3f4f6;
    }

    .progress-bar {
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }

    .btn-gradient-primary {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
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

    @media (max-width: 768px) {
        .profile-content {
            text-align: center;
        }

        .profile-content .row {
            flex-direction: column;
        }

        .modern-card {
            margin-bottom: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Simulasi progress upload (dummy, bisa diintegrasi AJAX jika perlu)
    document.querySelector('.modern-upload-form')?.addEventListener('submit', function(e) {
        const progress = document.getElementById('uploadProgress');
        const bar = document.getElementById('progressBar');
        progress.classList.remove('visually-hidden');
        let percent = 0;
        bar.style.width = '0%';
        const interval = setInterval(() => {
            percent += 10;
            bar.style.width = percent + '%';
            if (percent >= 100) clearInterval(interval);
        }, 100);
    });
</script>
@endpush
@endsection