@extends('layout.main')

@section('content')
<!-- Additional Flash Messages for Validation Errors -->
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    <strong>Terjadi kesalahan validasi:</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-alt me-2"></i>
        {{ isset($event) ? 'Edit Event' : 'Tambah Event' }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-{{ isset($event) ? 'edit' : 'plus' }} me-2"></i>
                    {{ isset($event) ? 'Form Edit Event' : 'Form Tambah Event' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($event) ? route('events.update', $event->id) : route('events.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="eventForm">
                    @csrf
                    @if(isset($event))
                    @method('PUT')
                    @endif

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Nama Event -->
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            Nama Event <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('nama_event') is-invalid @enderror"
                                            id="nama_event"
                                            name="nama_event"
                                            value="{{ old('nama_event', $event->nama_event ?? '') }}"
                                            placeholder="Masukkan nama event"
                                            maxlength="255"
                                            required>
                                        @error('nama_event')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">
                                            <i class="fas fa-link me-1"></i>
                                            Slug <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            id="slug"
                                            name="slug"
                                            value="{{ old('slug', $event->slug ?? '') }}"
                                            placeholder="slug-event (akan auto-generate dari nama)"
                                            maxlength="255"
                                            required>
                                        @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">URL-friendly version dari nama event</div>
                                    </div>

                                    <!-- Kategori dan Lingkup -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="id_kategori_event" class="form-label">
                                                    <i class="fas fa-tag me-1"></i>
                                                    Kategori Event <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('id_kategori_event') is-invalid @enderror"
                                                    id="id_kategori_event"
                                                    name="id_kategori_event"
                                                    required>
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($kategoris as $kategori)
                                                    <option value="{{ $kategori->id }}"
                                                        {{ old('id_kategori_event', $event->id_kategori_event ?? '') == $kategori->id ? 'selected' : '' }}>
                                                        {{ $kategori->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('id_kategori_event')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="id_range_event" class="form-label">
                                                    <i class="fas fa-globe me-1"></i>
                                                    Lingkup Event <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select @error('id_range_event') is-invalid @enderror"
                                                    id="id_range_event"
                                                    name="id_range_event"
                                                    required>
                                                    <option value="">Pilih Lingkup</option>
                                                    @foreach($lingkups as $lingkup)
                                                    <option value="{{ $lingkup->id }}"
                                                        {{ old('id_range_event', $event->id_range_event ?? '') == $lingkup->id ? 'selected' : '' }}>
                                                        {{ $lingkup->nama_range }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('id_range_event')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">
                                            <i class="fas fa-file-text me-1"></i>
                                            Deskripsi Event
                                        </label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                            id="deskripsi"
                                            name="deskripsi"
                                            rows="5"
                                            placeholder="Masukkan deskripsi lengkap event">{{ old('deskripsi', $event->deskripsi ?? '') }}</textarea>
                                        @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Jadwal Event</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_mulai" class="form-label">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Tanggal Mulai <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                    id="tanggal_mulai"
                                                    name="tanggal_mulai"
                                                    value="{{ old('tanggal_mulai', isset($event) && $event->tanggal_mulai ? $event->tanggal_mulai->format('Y-m-d') : '') }}"
                                                    required>
                                                @error('tanggal_mulai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="tanggal_selesai" class="form-label">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Tanggal Selesai
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                    id="tanggal_selesai"
                                                    name="tanggal_selesai"
                                                    value="{{ old('tanggal_selesai', isset($event) && $event->tanggal_selesai ? $event->tanggal_selesai->format('Y-m-d') : '') }}">
                                                @error('tanggal_selesai')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="batas_pendaftaran" class="form-label">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    Batas Pendaftaran <span class="text-danger">*</span>
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('batas_pendaftaran') is-invalid @enderror"
                                                    id="batas_pendaftaran"
                                                    name="batas_pendaftaran"
                                                    value="{{ old('batas_pendaftaran', isset($event) && $event->batas_pendaftaran ? $event->batas_pendaftaran->format('Y-m-d') : '') }}"
                                                    required>
                                                @error('batas_pendaftaran')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Tanggal terakhir peserta dapat mendaftar</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="batas_submission" class="form-label">
                                                    <i class="fas fa-calendar-times me-1"></i>
                                                    Batas Submission
                                                </label>
                                                <input type="date"
                                                    class="form-control @error('batas_submission') is-invalid @enderror"
                                                    id="batas_submission"
                                                    name="batas_submission"
                                                    value="{{ old('batas_submission', isset($event) && $event->batas_submission ? $event->batas_submission->format('Y-m-d') : '') }}">
                                                @error('batas_submission')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <div class="form-text">Batas akhir pengumpulan karya/submission (opsional)</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- Banner Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-image me-2"></i>Banner Event</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="banner_image" class="form-label">
                                            <i class="fas fa-upload me-1"></i>
                                            Upload Banner
                                        </label>
                                        <input type="file"
                                            class="form-control @error('banner_image') is-invalid @enderror"
                                            id="banner_image"
                                            name="banner_image"
                                            accept="image/*"
                                            onchange="previewImage(this)">
                                        @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                    </div>

                                    <!-- Image Preview -->
                                    <div id="image-preview" class="text-center">
                                        @if(isset($event) && $event->banner_image)
                                        <img src="{{ asset($event->banner_image) }}"
                                            alt="Banner Preview"
                                            class="img-thumbnail mb-2"
                                            style="max-width: 100%; max-height: 200px;">
                                        <p class="text-muted small">Banner saat ini</p>
                                        @else
                                        <div class="bg-light d-flex align-items-center justify-content-center mb-2"
                                            style="height: 200px; border: 2px dashed #dee2e6;">
                                            <div class="text-center text-muted">
                                                <i class="fas fa-image fa-3x mb-2"></i>
                                                <p>Preview banner akan tampil di sini</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Settings -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Pengaturan</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="status" class="form-label">
                                            <i class="fas fa-flag me-1"></i>
                                            Status <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                            <option value="draft" {{ old('status', $event->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                            <option value="published" {{ old('status', $event->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="cancelled" {{ old('status', $event->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary" id="submitBtn">
                                            <i class="fas fa-save me-1"></i>
                                            {{ isset($event) ? 'Update Event' : 'Simpan Event' }}
                                        </button>
                                        <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-generate slug from nama_event
        const namaEventInput = document.getElementById('nama_event');
        const slugInput = document.getElementById('slug');

        namaEventInput.addEventListener('input', function() {
            const namaEvent = this.value;
            const slug = namaEvent
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens with single
                .trim('-'); // Remove leading/trailing hyphens

            slugInput.value = slug;
        });

        // Form validation
        const form = document.getElementById('eventForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            submitBtn.disabled = true;

            // Basic validation
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            // Date validation
            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;
            const batasPendaftaran = document.getElementById('batas_pendaftaran').value;
            const batasSubmission = document.getElementById('batas_submission').value;

            console.log(tanggalMulai, tanggalSelesai, batasPendaftaran, batasSubmission);

            if (tanggalSelesai < tanggalMulai) {
                alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai');
                e.preventDefault();
                resetSubmitButton();
                return false;
            }

            if (batasPendaftaran < tanggalMulai) {
                alert('Batas pendaftaran tidak boleh lebih cepat dari tanggal mulai event');
                e.preventDefault();
                resetSubmitButton();
                return false;
            }

            if (batasPendaftaran > tanggalSelesai) {
                alert('Batas pendaftaran tidak boleh lebih lambat dari tanggal selesai event');
                e.preventDefault();
                resetSubmitButton();
                return false;
            }

            if ((batasSubmission < tanggalMulai) || (batasSubmission >= tanggalSelesai)) {
                alert('Batas submission tidak boleh lebih lambat dari tanggal mulai/lebih lambat/sama dengan tanggal selesai event');
                e.preventDefault();
                resetSubmitButton();
                return false;
            }

            if (batasSubmission >= tanggalSelesai) {
                alert('Batas submission tidak boleh lebih lambat/sama dengan tanggal selesai event');
                e.preventDefault();
                resetSubmitButton();
                return false;
            }

            if (!isValid) {
                e.preventDefault();
                resetSubmitButton();
                alert('Harap lengkapi semua field yang wajib diisi');
                return false;
            }
        });

        function resetSubmitButton() {
            submitBtn.innerHTML = '<i class="fas fa-save me-1"></i>{{ isset($event) ? "Update Event" : "Simpan Event" }}';
            submitBtn.disabled = false;
        }
    });

    // Image preview function
    function previewImage(input) {
        const preview = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = `
                    <img src="${e.target.result}" 
                         alt="Banner Preview" 
                         class="img-thumbnail mb-2" 
                         style="max-width: 100%; max-height: 200px;">
                    <p class="text-muted small">Preview banner baru</p>
                `;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush