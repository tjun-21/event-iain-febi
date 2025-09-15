@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tasks me-2"></i>
        {{ $title ?? (isset($requirement) ? 'Edit Requirement' : 'Tambah Requirement') }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<!-- Event Info Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Event: {{ $event->nama_event }}
                </h6>
            </div>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-{{ isset($requirement) ? 'edit' : 'plus' }} me-2"></i>
                    {{ isset($requirement) ? 'Edit Requirement' : 'Tambah Requirement Baru' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($requirement) ? route('event-requirements.update', [$event->id, $requirement->id]) : route('event-requirements.store', $event->id) }}"
                    method="POST" id="requirementForm">
                    @csrf
                    @if(isset($requirement))
                    @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Jenis Requirement -->
                        <div class="col-md-12 mb-3">
                            <label for="jenis_requirement_id" class="form-label">
                                <i class="fas fa-tag me-1"></i>
                                Jenis Requirement <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('jenis_requirement_id') is-invalid @enderror"
                                id="jenis_requirement_id" name="jenis_requirement_id" required>
                                <option value="">Pilih Jenis Requirement</option>
                                @foreach($jenisRequirements as $jenisRequirement)
                                <option value="{{ $jenisRequirement->id }}"
                                    {{ old('jenis_requirement_id', $requirement->jenis_requirement_id ?? '') == $jenisRequirement->id ? 'selected' : '' }}>
                                    {{ $jenisRequirement->nama }}
                                </option>
                                @endforeach
                            </select>
                            @error('jenis_requirement_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih jenis requirement yang sesuai untuk event ini
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi" class="form-label">
                                <i class="fas fa-align-left me-1"></i>
                                Deskripsi Requirement <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                id="deskripsi" name="deskripsi" rows="4" required
                                placeholder="Jelaskan detail requirement ini...">{{ old('deskripsi', $requirement->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Berikan penjelasan detail mengenai requirement ini (maksimal 1000 karakter)
                            </div>
                        </div>

                        <!-- Urutan dan Wajib -->
                        <div class="col-md-6 mb-3">
                            <label for="urutan" class="form-label">
                                <i class="fas fa-sort-numeric-down me-1"></i>
                                Urutan <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                id="urutan" name="urutan" min="1" required
                                value="{{ old('urutan', $requirement->urutan ?? '') }}"
                                placeholder="1">
                            @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Urutan tampil requirement (angka kecil = tampil lebih dulu)
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="is_mandatory" class="form-label">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Status Requirement <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('is_mandatory') is-invalid @enderror"
                                id="is_mandatory" name="is_mandatory" required>
                                <option value="">Pilih Status</option>
                                <option value="1" {{ old('is_mandatory', $requirement->is_mandatory ?? '') == '1' ? 'selected' : '' }}>
                                    Wajib (Mandatory)
                                </option>
                                <option value="0" {{ old('is_mandatory', $requirement->is_mandatory ?? '') == '0' ? 'selected' : '' }}>
                                    Opsional (Optional)
                                </option>
                            </select>
                            @error('is_mandatory')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Tentukan apakah requirement ini wajib dipenuhi atau tidak
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2">
                                    <i class="fas fa-save me-1"></i>
                                    {{ isset($requirement) ? 'Update Requirement' : 'Simpan Requirement' }}
                                </button>
                                <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    Tips & Panduan
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info border-0">
                    <h6><i class="fas fa-info-circle me-1"></i> Panduan Pengisian:</h6>
                    <ul class="mb-0 small">
                        <li><strong>Jenis Requirement:</strong> Pilih kategori requirement yang sesuai</li>
                        <li><strong>Deskripsi:</strong> Jelaskan detail apa yang harus dipenuhi peserta</li>
                        <li><strong>Urutan:</strong> Angka kecil akan ditampilkan lebih dulu</li>
                        <li><strong>Status:</strong> Wajib = harus dipenuhi, Opsional = boleh tidak dipenuhi</li>
                    </ul>
                </div>

                @if($jenisRequirements->count() == 0)
                <div class="alert alert-warning border-0">
                    <h6><i class="fas fa-exclamation-triangle me-1"></i> Perhatian:</h6>
                    <p class="mb-2 small">Belum ada jenis requirement yang tersedia.</p>
                    <a href="{{ route('jenis-requirements.create') }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Jenis Requirement
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate next urutan
        // @if(!isset($requirement))
        // const urutanField = document.getElementById('urutan');
        // if (urutanField && !urutanField.value) {
        //     // You can implement auto-numbering logic here if needed
        //     urutanField.value = 1;
        // }
        // @endif

        // Form validation
        const form = document.getElementById('requirementForm');
        form.addEventListener('submit', function(e) {
            const jenisRequirement = document.getElementById('jenis_requirement_id').value;
            const deskripsi = document.getElementById('deskripsi').value.trim();
            const urutan = document.getElementById('urutan').value;
            const isMandatory = document.getElementById('is_mandatory').value;

            if (!jenisRequirement || !deskripsi || !urutan || isMandatory === '') {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi!');
                return false;
            }

            if (deskripsi.length > 1000) {
                e.preventDefault();
                alert('Deskripsi tidak boleh lebih dari 1000 karakter!');
                return false;
            }
        });
    });
</script>
@endpush
@endsection