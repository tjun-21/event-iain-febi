@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-edit me-2"></i>
        {{ $title }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="b                height: 300,
                toolbar: [ me-2">
            <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
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

<!-- Form Edit -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Form Edit Requirement
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('event-requirements.update', [$event->id, $requirement->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>
                                    Deskripsi Requirement <span class="text-danger">*</span>
                                </label>
                                <textarea name="deskripsi" id="deskripsi" class="summernote"
                                    placeholder="Masukkan deskripsi requirement di sini..."
                                    required>{{ old('deskripsi', $requirement->deskripsi) }}</textarea>
                                @error('deskripsi')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                                @enderror
                                <small class="form-text text-muted">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Gunakan rich text editor untuk formatting yang lebih baik. Anda juga bisa upload gambar.
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Info Last Update -->
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-light">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Terakhir diperbarui: {{ $requirement->updated_at->format('d M Y, H:i') }} WIB
                                    ({{ $requirement->updated_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-asterisk me-1"></i>
                                        Field yang ditandai dengan (*) wajib diisi
                                    </small>
                                </div>
                                <div>
                                    <a href="{{ route('event-requirements.index', $event->id) }}" class="btn btn-secondary me-2">
                                        <i class="fas fa-times me-1"></i>
                                        Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Update Requirement
                                    </button>
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

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">

<style>
    .note-editor {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    .note-editor.note-frame {
        border-radius: 0.375rem;
    }

    .note-editing-area {
        min-height: 300px;
    }

    .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 0.375rem 0.375rem 0 0;
    }

    /* Fix dropdown styling */
    .note-dropdown-menu {
        z-index: 1055 !important;
        position: absolute !important;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff !important;
        min-width: 160px;
        display: none;
    }

    .note-dropdown-menu.show {
        display: block !important;
    }

    .note-dropdown-item {
        padding: 8px 12px;
        color: #495057;
        text-decoration: none;
        display: block;
        clear: both;
        font-weight: 400;
        line-height: 1.5;
        white-space: nowrap;
        background-color: transparent;
        border: 0;
        cursor: pointer;
    }

    .note-dropdown-item:hover,
    .note-dropdown-item:focus {
        background-color: #f8f9fa !important;
        color: #495057 !important;
        text-decoration: none;
    }

    /* Fix button group dropdowns */
    .note-btn-group {
        position: relative;
    }

    .note-btn-group .note-dropdown-toggle::after {
        display: inline-block;
        margin-left: 0.255em;
        vertical-align: 0.255em;
        content: "";
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-bottom: 0;
        border-left: 0.3em solid transparent;
    }

    /* Fix color palette */
    .note-color .note-dropdown-menu {
        min-width: 290px;
        padding: 8px;
    }

    .note-color-palette {
        line-height: 1;
    }

    .note-color-palette div .note-color-btn {
        width: 20px;
        height: 20px;
        border: 1px solid #fff;
        border-radius: 2px;
        margin: 1px;
        cursor: pointer;
        display: inline-block;
    }

    .note-color-palette div .note-color-btn:hover {
        border: 2px solid #000;
    }

    /* Font name and size dropdowns */
    .note-fontname .note-dropdown-menu,
    .note-fontsize .note-dropdown-menu {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Style dropdown */
    .note-style .note-dropdown-menu {
        max-width: 200px;
    }

    .note-style .note-dropdown-item {
        padding: 5px 12px;
    }

    .note-style h1 {
        font-size: 2rem;
        margin: 0;
    }

    .note-style h2 {
        font-size: 1.75rem;
        margin: 0;
    }

    .note-style h3 {
        font-size: 1.5rem;
        margin: 0;
    }

    .note-style h4 {
        font-size: 1.25rem;
        margin: 0;
    }

    .note-style h5 {
        font-size: 1.1rem;
        margin: 0;
    }

    .note-style h6 {
        font-size: 1rem;
        margin: 0;
    }

    /* Fix button styling */
    .note-btn {
        border: none;
        border-radius: 0.25rem;
        padding: 5px 8px;
        margin: 1px;
        background-color: transparent;
        cursor: pointer;
        position: relative;
    }

    .note-btn:hover {
        background-color: #e9ecef !important;
    }

    .note-btn.active {
        background-color: #007bff !important;
        color: white !important;
    }

    /* Prevent Bootstrap interference */
    .note-editor * {
        box-sizing: border-box;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .card {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    /* Fix button styling */
    .note-btn {
        border: none;
        border-radius: 0.25rem;
        padding: 5px 8px;
        margin: 1px;
    }

    .note-btn:hover {
        background-color: #e9ecef;
    }

    .note-btn.active {
        background-color: #007bff;
        color: white;
    }

    /* Fix modal styling if any */
    .note-modal .modal-dialog {
        z-index: 1060;
    }
</style>
@endpush

@push('scripts')
<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
    $(document).ready(function() {
        // Wait for Bootstrap to load completely
        setTimeout(function() {
            // Initialize Summernote
            $('.summernote').summernote({
                height: 350,
                minHeight: 200,
                maxHeight: 600,
                focus: false,
                placeholder: 'Masukkan deskripsi requirement di sini...',
                fontNames: [
                    'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
                    'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
                    'Tahoma', 'Times New Roman', 'Verdana'
                ],
                fontNamesIgnoreCheck: [
                    'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
                    'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
                    'Tahoma', 'Times New Roman', 'Verdana'
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48', '64', '82', '150'],
                toolbar: [
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        console.log('Image upload triggered, files:', files);
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i], this);
                        }
                    },
                    onInit: function() {
                        console.log('Summernote initialized successfully');
                    },
                    onFocus: function() {
                        console.log('Summernote focused');
                    },
                    onChange: function(contents) {
                        console.log('Content changed:', contents);
                    }
                }
            });
        }, 100);

        // Image upload function
        function uploadImage(file, editor) {
            console.log('Starting upload for file:', file.name, 'size:', file.size);

            // Validate file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                return;
            }

            // Validate file type
            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar.');
                return;
            }

            var data = new FormData();
            data.append("file", file);
            data.append("_token", "{{ csrf_token() }}");

            // Show loading indicator
            console.log('Inserting loading text...');
            $(editor).summernote('insertText', '[Uploading image...]');

            $.ajax({
                data: data,
                type: "POST",
                url: "{{ route('upload.image') }}",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    console.log('Starting AJAX request...');
                },
                success: function(response) {
                    console.log('Upload response:', response);

                    // Remove loading text
                    var content = $(editor).summernote('code');
                    content = content.replace('[Uploading image...]', '');
                    $(editor).summernote('code', content);

                    if (response.success) {
                        console.log('Upload successful, inserting image:', response.url);
                        // Insert image
                        $(editor).summernote('insertImage', response.url, function($image) {
                            $image.css('max-width', '100%');
                            $image.css('height', 'auto');
                            $image.addClass('img-fluid');
                        });
                    } else {
                        console.error('Upload failed:', response.message);
                        alert('Gagal upload gambar: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });

                    // Remove loading text
                    var content = $(editor).summernote('code');
                    content = content.replace('[Uploading image...]', '');
                    $(editor).summernote('code', content);

                    alert('Gagal upload gambar. Silakan coba lagi.');
                }
            });
        }

        // Form validation
        $('form').on('submit', function(e) {
            var deskripsi = $('.summernote').summernote('code');
            var textContent = $('<div>').html(deskripsi).text().trim();

            if (deskripsi === '<p><br></p>' || textContent === '') {
                e.preventDefault();
                alert('Deskripsi requirement harus diisi');
                $('.summernote').summernote('focus');
                return false;
            }
        });

        // Auto-save changes (for edit form)
        setInterval(function() {
            var content = $('.summernote').summernote('code');
            if (content && content !== '<p><br></p>') {
                localStorage.setItem('requirement_edit_{{ $requirement->id }}', content);
                console.log('Edit draft saved to localStorage');
            }
        }, 30000);

        // Load auto-saved content if available
        var savedContent = localStorage.getItem('requirement_edit_{{ $requirement->id }}');
        if (savedContent && savedContent !== $('.summernote').summernote('code')) {
            if (confirm('Ditemukan perubahan yang belum disimpan. Muat perubahan tersebut?')) {
                $('.summernote').summernote('code', savedContent);
            }
        }

        // Clear auto-save on successful submit
        $('form').on('submit', function() {
            localStorage.removeItem('requirement_edit_{{ $requirement->id }}');
        });

        // Debug: Check if Summernote is properly initialized
        setTimeout(function() {
            if ($('.summernote').hasClass('note-editable')) {
                console.log('Summernote initialized successfully!');
            } else {
                console.error('Summernote failed to initialize!');
            }
        }, 1000);
    });
</script>
@endpush