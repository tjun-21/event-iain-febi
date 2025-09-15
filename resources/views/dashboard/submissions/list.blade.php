@extends('layout.main')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill px-4 py-2 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>
    <div class="event-info-card mb-4 p-4 rounded-4 shadow-sm bg-white">
        <div class="row g-3 align-items-center">
            <div class="col-md-2 text-center">
                @if(!empty($event['banner_image']))
                <img src="/{{ $event['banner_image'] }}" alt="{{ $event['nama_event'] ?? '-' }}" class="img-fluid rounded-3 shadow-sm" style="max-height:120px;object-fit:cover;">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded-3" style="height:120px;">
                    <i class="fas fa-image fa-2x text-muted"></i>
                </div>
                @endif
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold mb-2 text-warning"><i class="fas fa-calendar-alt me-2"></i>{{ $event['nama_event'] ?? '-' }}</h2>
                <div class="mb-2 text-muted">
                    <i class="fas fa-tag me-1"></i> {{ $event['nama_kategori'] ?? '-' }}
                    &nbsp;|&nbsp;
                    <i class="fas fa-globe me-1"></i> {{ $event['nama_range'] ?? '-' }}
                </div>
                <div class="mb-2">
                    <i class="fas fa-calendar me-1 text-secondary"></i>
                    {{ \Carbon\Carbon::parse($event['tanggal_mulai'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($event['tanggal_selesai'])->format('d M Y') }}
                </div>
                <div class="mb-2">
                    <span class="badge bg-primary">Status: {{ ucfirst($event['status'] ?? '-') }}</span>
                    <span class="badge bg-light text-primary ms-2"><i class="fas fa-users me-1"></i> Total Submissions: <strong>{{ count($list) }}</strong></span>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm rounded">
            <thead class="table-warning">
                <tr>
                    <th>#</th>
                    <th>Participant Name</th>
                    <th>Confirmation Date</th>
                    <th>Uploaded At</th>
                    <th>File Name</th>
                    <th>File Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($list as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><i class=" me-1 text-primary"></i> {{ $item['nama_peserta'] ?? '-' }}</td>

                    <td><i class="fas fa-calendar-alt me-1 text-secondary"></i> {{ $item['tanggal_konfirmasi'] ?? '-' }}</td>
                    <td>{{ $item['file_uploaded_at'] ?? '-' }}</td>
                    <td><i class="fas fa-file me-1 text-secondary"></i> {{ $item['original_name'] ?? '-' }}</td>
                    <td>
                        @if($item['file_status'])
                        <span class="badge bg-info text-dark">{{ ucfirst($item['file_status']) }}</span>
                        @else
                        <span class="text-muted">No File</span>
                        @endif
                    </td>
                    <td>

                        @if($item['id_file'] && $item['file_status'])
                        <a href="/{{ $item['file_path'] }}" target="_blank" class="btn btn-sm btn-gradient-primary px-3"><i class="fas fa-download me-1"></i>Download</a>
                        @else
                        <span class="text-muted">No Download</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No submissions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('styles')
<style>
    .btn-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-gradient-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .table thead th {
        vertical-align: middle;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .table-bordered {
        border-radius: 12px;
        overflow: hidden;
    }
</style>
@endpush
@endsection