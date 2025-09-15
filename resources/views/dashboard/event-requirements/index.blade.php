@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tasks me-2"></i>
        {{ $title ?? 'Requirements Event' }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Events
            </a>
            <a href="{{ route('event-requirements.create', $event->id) }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Tambah Requirement
            </a>
        </div>
    </div>
</div>

<!-- Event Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Informasi Event
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6><strong>{{ $event->nama_event }}</strong></h6>
                        <p class="text-muted mb-2">{!! $event->deskripsi ?? 'Tidak ada deskripsi' !!}</p>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $event->tanggal_mulai ? $event->tanggal_mulai->format('d M Y') : 'Tanggal belum ditentukan' }} -
                            {{ $event->tanggal_selesai ? $event->tanggal_selesai->format('d M Y') : 'Tanggal belum ditentukan' }}
                        </small>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-{{ $event->status === 'active' ? 'success' : ($event->status === 'draft' ? 'secondary' : 'danger') }} fs-6">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Requirements List -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Daftar Requirements ({{ $requirements->count() }} item)
                </h5>
            </div>
            <div class="card-body">
                @if($requirements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="65%">Deskripsi</th>
                                <th width="15%">Dibuat</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requirements as $index => $requirement)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div style="max-width: 400px; overflow: hidden; text-overflow: ellipsis;">
                                        {!! Str::limit(strip_tags($requirement->deskripsi), 100) !!}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $requirement->created_at->format('d M Y') }}
                                        <br>
                                        {{ $requirement->created_at->format('H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('event-requirements.show', [$event->id, $requirement->id]) }}"
                                            class="btn btn-outline-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('event-requirements.edit', [$event->id, $requirement->id]) }}"
                                            class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('event-requirements.destroy', [$event->id, $requirement->id]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirmDelete(this, 'requirement ini')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada Requirements</h5>
                    <p class="text-muted">Silakan tambahkan requirement pertama untuk event ini.</p>
                    <a href="{{ route('event-requirements.create', $event->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Requirement Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(form, itemName) {
        if (confirm(`Apakah Anda yakin ingin menghapus ${itemName}?\n\nPerubahan ini tidak dapat dibatalkan.`)) {
            return true;
        }
        return false;
    }
</script>
@endpush
@endsection