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
    <div class="col-12 col-md-4 mb-4">
        <div class="card shadow-lg border-0 h-100 p-3 event-card d-flex flex-column">
            @if($event->banner_image)
            <img src="{{ asset($event->banner_image) }}" alt="{{ $event->nama_event }}" class="card-img-top rounded mb-2" style="height:140px;object-fit:cover;">
            @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded mb-2" style="height:140px;">
                <i class="fas fa-image text-muted fa-3x"></i>
            </div>
            @endif
            <div class="card-body p-0 flex-grow-1 d-flex flex-column">
                <h5 class="card-title fw-bold mb-1">{{ $event->nama_event }}</h5>
                <div class="mb-2 text-muted small">
                    <i class="fas fa-calendar me-1"></i>
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                    - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                </div>
                <div class="mb-2 text-muted small">
                    <i class="fas fa-tag me-1"></i> {{ $event->nama_kategori ?? '-' }}
                    &nbsp;|&nbsp;
                    <i class="fas fa-globe me-1"></i> {{ $event->nama_range ?? '-' }}
                </div>
                <div class="mt-auto d-flex justify-content-end">
                    <a href="{{ route('submissions.list', $event->slug) }}" class="btn btn-primary btn-sm px-3" title="Lihat Submission">
                        <i class="fas fa-list-alt me-1"></i> View Submissions
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