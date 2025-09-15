@extends('layout.main')

@section('content')

<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <i class="fas fa-users me-2"></i>
        Daftar Peserta Event
    </h2>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Asal</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Registrasi Akun</th>
                        <th>Status</th>
                        <th>Tgl Pendaftaran</th>
                        <th>Tgl Konfirmasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($list as $index => $peserta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $peserta['nama'] }}</strong></td>
                        <td><span class="badge bg-info">{{ $peserta['asal'] }}</span></td>
                        <td>{{ $peserta['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td><small>{{ \Carbon\Carbon::parse($peserta['tanggal_registrasi_akun'])->format('d M Y H:i') }}</small></td>
                        <td>
                            @if($peserta['status'] == 'registered')
                            <span class="badge bg-success">Registered</span>
                            @else
                            <span class="badge bg-secondary">{{ ucfirst($peserta['status']) }}</span>
                            @endif
                        </td>
                        <td><small>{{ \Carbon\Carbon::parse($peserta['tanggal_pendaftaran'])->format('d M Y H:i') }}</small></td>
                        <td>
                            @if($peserta['tanggal_konfirmasi'])
                            <small>{{ \Carbon\Carbon::parse($peserta['tanggal_konfirmasi'])->format('d M Y H:i') }}</small>
                            @else
                            <span class="text-muted">Belum dikonfirmasi</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('participants.show', ['event' => $peserta['event_slug'], 'participant' => $peserta['id']]) }}" class="btn btn-outline-info btn-sm" title="Detail Peserta">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <p>Belum ada peserta yang terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .table thead th {
        background-color: #f8f9fa;
        color: #343a40;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr:hover {
        background-color: #f1f3f6;
        transition: background 0.2s;
    }

    .badge.bg-success {
        background-color: #28a745 !important;
    }

    .badge.bg-secondary {
        background-color: #6c757d !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .table td,
    .table th {
        vertical-align: middle;
        padding: 0.75rem;
    }
</style>
@endpush