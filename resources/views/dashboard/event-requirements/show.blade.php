@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-eye me-2"></i>
        {{ $title ?? 'Detail Requirement' }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
            <a href="{{ route('event-requirements.edit', [$event->id, $requirement->id]) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>
                Edit
            </a>
        </div>
    </div>
</div>

<!-- Event Info -->
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-info">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <h6 class="mb-1">Event: <strong>{{ $event->nama_event }}</strong></h6>
                    <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        {{ $event->tanggal_mulai ? $event->tanggal_mulai->format('d M Y') : 'Tanggal belum ditentukan' }} -
                        {{ $event->tanggal_selesai ? $event->tanggal_selesai->format('d M Y') : 'Tanggal belum ditentukan' }}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Requirement Detail -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Detail Requirement
                </h5>
            </div>
            <div class="card-body">
                <!-- Requirement Content -->
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">
                            <i class="fas fa-align-left me-1"></i>
                            Deskripsi Requirement:
                        </label>
                        <div class="requirement-content p-3 bg-light rounded">
                            {!! $requirement->deskripsi !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('event-requirements.edit', [$event->id, $requirement->id]) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit Requirement
                    </a>

                    <form action="{{ route('event-requirements.destroy', [$event->id, $requirement->id]) }}"
                        method="POST" class="d-inline"
                        onsubmit="return confirmDelete()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Requirement
                        </button>
                    </form>

                    <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-list me-1"></i>
                        Daftar Requirements
                    </a>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi
                </h6>
            </div>
            <div class="card-body">
                <div class="small text-muted">
                    <div class="mb-3">
                        <strong class="text-dark">ID Requirement:</strong><br>
                        <span class="badge bg-secondary">#{{ $requirement->id }}</span>
                    </div>

                    <div class="mb-3">
                        <strong class="text-dark">Dibuat:</strong><br>
                        {{ $requirement->created_at->format('d M Y, H:i') }} WIB
                        <br>
                        <small>({{ $requirement->created_at->diffForHumans() }})</small>
                    </div>

                    @if($requirement->updated_at != $requirement->created_at)
                    <div class="mb-3">
                        <strong class="text-dark">Terakhir diperbarui:</strong><br>
                        {{ $requirement->updated_at->format('d M Y, H:i') }} WIB
                        <br>
                        <small>({{ $requirement->updated_at->diffForHumans() }})</small>
                    </div>
                    @endif

                    <div class="mb-0">
                        <strong class="text-dark">Event:</strong><br>
                        <a href="{{ route('events.show', $event->id) }}" class="text-decoration-none">
                            {{ $event->nama_event }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .requirement-content {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        min-height: 200px;
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

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .text-dark {
        color: #495057 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Apakah Anda yakin ingin menghapus requirement ini?\n\nPerubahan ini tidak dapat dibatalkan.');
    }

    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush