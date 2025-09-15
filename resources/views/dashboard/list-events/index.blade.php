@extends('layout.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-calendar-alt me-2"></i>
        {{ $title ?? 'List Events' }}
    </h1>
    <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-1"></i>
                Filter
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" onclick="filterEvents('all')">Semua Event</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterEvents('published')">Published</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterEvents('draft')">Draft</a></li>
                <li><a class="dropdown-item" href="#" onclick="filterEvents('cancelled')">Cancelled</a></li>
            </ul>
        </div>
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-secondary" id="viewGrid" onclick="changeView('grid')">
                <i class="fas fa-th"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary active" id="viewList" onclick="changeView('list')">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div> -->
</div>

<!-- Search Bar -->
<!-- <div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-search"></i>
            </span>
            <input type="text" class="form-control" id="searchInput" placeholder="Cari event berdasarkan nama, kategori, atau deskripsi...">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-sort"></i>
            </span>
            <select class="form-select" id="sortSelect">
                <option value="name_asc">Nama A-Z</option>
                <option value="name_desc">Nama Z-A</option>
                <option value="date_asc">Tanggal Mulai Terlama</option>
                <option value="date_desc">Tanggal Mulai Terbaru</option>
                <option value="created_desc">Terbaru Dibuat</option>
                <option value="created_asc">Terlama Dibuat</option>
            </select>
        </div>
    </div>
</div> -->

<!-- Events Container -->
<div id="eventsContainer">
    @if($events && $events->count() > 0)

    <!-- Grid View -->
    <div id="gridView" class="row" style="display: none;">
        @foreach($events as $event)
        <div class="col-lg-4 col-md-6 mb-4 event-card"
            data-status="{{ $event->status }}"
            data-name="{{ strtolower($event->nama_event) }}"
            data-category="{{ strtolower($event->kategori->nama ?? '') }}"
            data-created="{{ $event->created_at }}"
            data-date="{{ $event->tanggal_mulai }}">
            <div class="card h-100 shadow-sm border-0 event-item">
                <!-- Banner Image -->
                @if($event->banner_image)
                <div class="card-img-top position-relative" style="height: 200px; overflow: hidden;">
                    <img src="{{ asset($event->banner_image) }}"
                        alt="{{ $event->nama_event }}"
                        class="w-100 h-100"
                        style="object-fit: cover;">
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        @if($event->status === 'published')
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Published
                        </span>
                        @elseif($event->status === 'draft')
                        <span class="badge bg-warning">
                            <i class="fas fa-edit me-1"></i>
                            Draft
                        </span>
                        @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>
                            Cancelled
                        </span>
                        @endif
                    </div>
                </div>
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <div class="text-center text-muted">
                        <i class="fas fa-image fa-3x mb-2"></i>
                        <p class="mb-0">No Image</p>
                    </div>
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 end-0 m-2">
                        @if($event->status === 'published')
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Published
                        </span>
                        @elseif($event->status === 'draft')
                        <span class="badge bg-warning">
                            <i class="fas fa-edit me-1"></i>
                            Draft
                        </span>
                        @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>
                            Cancelled
                        </span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="card-body d-flex flex-column">
                    <!-- Event Title -->
                    <h5 class="card-title text-truncate" title="{{ $event->nama_event }}">
                        {{ $event->nama_event }}
                    </h5>

                    <!-- Event Category -->
                    <div class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-tag me-1"></i>
                            {{ $event->kategori->nama ?? 'Tidak ada kategori' }}
                        </small>
                    </div>

                    <!-- Event Description -->
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($event->deskripsi ?? 'Tidak ada deskripsi', 100) }}
                    </p>

                    <!-- Event Dates -->
                    <div class="mb-3">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <small class="text-muted d-block">Mulai</small>
                                    <strong class="small">{{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</strong>
                                </div>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Selesai</small>
                                <strong class="small">{{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Deadline -->
                    <div class="mb-3 p-2 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Pendaftaran sampai:
                            <strong>{{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}</strong>
                        </small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-auto">
                        <div class="d-grid gap-2">
                            <a href="{{ route('list-events.show', $event->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- List View -->
    <div id="listView" class="row">
        @foreach($events as $event)
        <div class="col-12 mb-3 event-card"
            data-status="{{ $event->status }}"
            data-name="{{ strtolower($event->nama_event) }}"
            data-category="{{ strtolower($event->kategori->nama ?? '') }}"
            data-created="{{ $event->created_at }}"
            data-date="{{ $event->tanggal_mulai }}">
            <div class="card shadow-sm border-0 event-item">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Event Image -->
                        <div class="col-md-2">
                            @if($event->banner_image)
                            <img src="{{ asset($event->banner_image) }}"
                                alt="{{ $event->nama_event }}"
                                class="img-fluid rounded"
                                style="height: 80px; width: 100%; object-fit: cover;">
                            @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </div>

                        <!-- Event Info -->
                        <div class="col-md-7">
                            <h5 class="card-title mb-1">{{ $event->nama_event }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="fas fa-tag me-1"></i>
                                {{ $event->kategori->nama ?? 'Tidak ada kategori' }}
                            </p>
                            <p class="card-text text-muted small mb-2">
                                {{ Str::limit($event->deskripsi ?? 'Tidak ada deskripsi', 150) }}
                            </p>
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                                    </small>
                                </div>
                                <div class="col-sm-6">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Daftar sampai: {{ \Carbon\Carbon::parse($event->batas_pendaftaran)->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="col-md-3 text-md-end">
                            <div class="mb-2">
                                @if($event->status === 'published')
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Published
                                </span>
                                @elseif($event->status === 'draft')
                                <span class="badge bg-warning">
                                    <i class="fas fa-edit me-1"></i>
                                    Draft
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Cancelled
                                </span>
                                @endif
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('list-events.show', $event->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <!-- Empty State -->
    <div class="text-center py-5">
        <i class="fas fa-calendar-times fa-5x text-muted mb-3"></i>
        <h4 class="text-muted">Belum Ada Event</h4>
        <p class="text-muted">Tidak ada event yang tersedia saat ini.</p>
    </div>
    @endif
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="text-center py-5" style="display: none;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-muted mt-2">Memuat events...</p>
</div>

@push('styles')
<style>
    .event-item {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .event-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        border-color: #007bff;
    }

    .card-img-top {
        position: relative;
    }

    .badge {
        font-size: 0.7rem;
    }

    .view-toggle .btn.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }

    /* Smooth transitions for view changes */
    #gridView,
    #listView {
        transition: opacity 0.3s ease;
    }

    /* Search highlight */
    .highlight {
        background-color: yellow;
        padding: 1px 3px;
        border-radius: 2px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .event-item:hover {
            transform: none;
        }

        .card-title {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize view
        changeView('list');

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterAndSortEvents();
        });

        // Sort functionality
        document.getElementById('sortSelect').addEventListener('change', function() {
            filterAndSortEvents();
        });
    });

    function changeView(viewType) {
        const gridView = document.getElementById('gridView');
        const listView = document.getElementById('listView');
        const gridBtn = document.getElementById('viewGrid');
        const listBtn = document.getElementById('viewList');

        if (viewType === 'grid') {
            gridView.style.display = 'block';
            listView.style.display = 'none';
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
        } else {
            gridView.style.display = 'none';
            listView.style.display = 'block';
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
        }
    }

    function filterEvents(status) {
        const cards = document.querySelectorAll('.event-card');

        cards.forEach(card => {
            if (status === 'all' || card.dataset.status === status) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        // Update dropdown text
        const dropdownBtn = document.querySelector('.dropdown-toggle');
        const statusText = status === 'all' ? 'Semua Event' :
            status === 'published' ? 'Published' :
            status === 'draft' ? 'Draft' : 'Cancelled';
        dropdownBtn.innerHTML = `<i class="fas fa-filter me-1"></i> ${statusText}`;
    }

    function filterAndSortEvents() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const sortValue = document.getElementById('sortSelect').value;
        const cards = document.querySelectorAll('.event-card');

        // Convert NodeList to Array for sorting
        const cardsArray = Array.from(cards);

        // Filter cards based on search
        cardsArray.forEach(card => {
            const name = card.dataset.name;
            const category = card.dataset.category;
            const description = card.querySelector('.card-text') ?
                card.querySelector('.card-text').textContent.toLowerCase() : '';

            const matches = name.includes(searchTerm) ||
                category.includes(searchTerm) ||
                description.includes(searchTerm);

            card.style.display = matches ? 'block' : 'none';
        });

        // Sort visible cards
        const visibleCards = cardsArray.filter(card => card.style.display !== 'none');

        visibleCards.sort((a, b) => {
            switch (sortValue) {
                case 'name_asc':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'name_desc':
                    return b.dataset.name.localeCompare(a.dataset.name);
                case 'date_asc':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                case 'date_desc':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'created_asc':
                    return new Date(a.dataset.created) - new Date(b.dataset.created);
                case 'created_desc':
                    return new Date(b.dataset.created) - new Date(a.dataset.created);
                default:
                    return 0;
            }
        });

        // Reorder DOM elements
        const containers = [document.getElementById('gridView'), document.getElementById('listView')];

        containers.forEach(container => {
            // Clear container
            container.innerHTML = '';

            // Append sorted cards
            visibleCards.forEach(card => {
                container.appendChild(card.cloneNode(true));
            });
        });
    }

    // Add smooth loading effect
    function showLoading() {
        document.getElementById('eventsContainer').style.display = 'none';
        document.getElementById('loadingSpinner').style.display = 'block';
    }

    function hideLoading() {
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('eventsContainer').style.display = 'block';
    }
</script>
@endpush
@endsection