@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <i class="fas fa-users me-2"></i>
        {{ $title ?? 'Daftar Event' }}
    </h2>
</div>

<div class="row">
    @forelse($events as $event)
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="row g-0 align-items-center">
                <div class="col-md-2">
                    @if($event->banner_image)
                    <img src="{{ asset($event->banner_image) }}" alt="{{ $event->nama_event }}" class="img-fluid rounded" style="height:80px;object-fit:cover;">
                    @else
                    <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height:80px;">
                        <i class="fas fa-image text-muted fa-2x"></i>
                    </div>
                    @endif
                </div>
                <div class="col-md-7">
                    <h5 class="mb-1">{{ $event->nama_event }}</h5>
                    <div class="text-muted small mb-1">
                        <i class="fas fa-tag me-1"></i> {{ $event->nama_kategori ?? '-' }}
                        &nbsp;|&nbsp;
                        <i class="fas fa-globe me-1"></i> {{ $event->nama_range ?? '-' }}
                    </div>
                    <div class="text-muted small">
                        <i class="fas fa-calendar me-1"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <span class="badge {{ $event->status === 'published' ? 'bg-success' : ($event->status === 'draft' ? 'bg-warning' : 'bg-secondary') }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    <a href="{{ route('participants.list', $event->slug) }}" class="btn btn-outline-primary btn-sm mt-2">
                        <i class="fas fa-users"></i> Lihat Peserta
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center text-muted py-5">
        <i class="fas fa-calendar-times fa-3x mb-2"></i>
        <div>Belum ada event tersedia.</div>
    </div>
    @endforelse
</div>
@endsection