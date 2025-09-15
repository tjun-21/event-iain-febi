<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Febi Event Dashboard' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <style>
        /* Sidebar Collapse Styling */
        .nav-link[data-bs-toggle="collapse"] {
            position: relative;
        }

        .nav-link[data-bs-toggle="collapse"] .fa-chevron-down {
            transition: transform 0.3s ease;
        }

        .nav-link[data-bs-toggle="collapse"]:not(.collapsed) .fa-chevron-down {
            transform: rotate(180deg);
        }

        .collapse .nav-link {
            padding-left: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
            border-left: 2px solid transparent;
        }

        .collapse .nav-link:hover {
            color: #495057;
            border-left-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }

        .collapse .nav-link.active {
            color: #007bff;
            border-left-color: #007bff;
            background-color: rgba(0, 123, 255, 0.1);
        }

        /* Alert Enhancements */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideInRight 0.3s ease-out;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert.position-fixed {
            z-index: 9999;
            max-width: 400px;
            min-width: 300px;
        }

        .alert-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border-left: 4px solid #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
            border-left: 4px solid #721c24;
        }

        .alert-info {
            background: linear-gradient(135deg, #17a2b8, #3498db);
            color: white;
            border-left: 4px solid #0c5460;
        }

        .alert-warning {
            background: linear-gradient(135deg, #ffc107, #f39c12);
            color: #212529;
            border-left: 4px solid #856404;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-calendar-alt me-2"></i>
                Febi Event
            </a>

            <button class="navbar-toggler" type="button" id="sidebarToggle">
                <i class="fas fa-bars text-white"></i>
            </button>

            <div class="d-none d-lg-flex align-items-center ms-auto">
                <div class="dropdown">
                    <button class="btn btn-link text-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle fa-lg me-2"></i>
                        {{ session('user_data')['name'] ?? 'no session name' }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <button class="btn-close d-md-none mb-3" id="sidebarClose"></button>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="/">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">
                                <i class="fas fa-calendar-alt"></i>
                                Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#masterDataCollapse" aria-expanded="false" aria-controls="masterDataCollapse">
                                <i class="fas fa-database"></i>
                                Master
                                <i class="fas fa-chevron-down ms-auto small"></i>
                            </a>
                            <div class="collapse" id="masterDataCollapse">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('kategori.index') }}">
                                            <i class="fas fa-tags me-2"></i>
                                            Kategori
                                        </a>
                                    </li>

                                </ul>
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link py-2" href="{{ route('lingkup.index') }}">
                                            <i class="fas fa-link me-2"></i>
                                            Lingkup
                                        </a>
                                    </li>

                                </ul>

                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('list-events.index') }}">
                                <i class="fas fa-calendar-check"></i>
                                Daftar Event
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('participants.index') }}">
                                <i class="fas fa-users"></i>
                                Participants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('submitting.index') }}">
                                <i class="fas fa-paper-plane"></i>
                                Submit Event
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('submissions.index') }}">
                                <i class="fas fa-list-alt"></i>
                                Submissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-bar"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i>
                                Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="{{ asset('js/dashboard.js') }}"></script> -->

    <script>
        // Handle sidebar collapse for better UX
        document.addEventListener('DOMContentLoaded', function() {
            // Add collapsed class to collapse triggers initially
            const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            collapseToggles.forEach(toggle => {
                toggle.classList.add('collapsed');
            });

            // Handle collapse events
            const collapseElements = document.querySelectorAll('.collapse');
            collapseElements.forEach(collapseEl => {
                collapseEl.addEventListener('show.bs.collapse', function() {
                    const toggle = document.querySelector(`[data-bs-target="#${this.id}"]`);
                    if (toggle) toggle.classList.remove('collapsed');
                });

                collapseEl.addEventListener('hide.bs.collapse', function() {
                    const toggle = document.querySelector(`[data-bs-target="#${this.id}"]`);
                    if (toggle) toggle.classList.add('collapsed');
                });
            });

            // Auto-hide alerts with enhanced animations
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Auto-hide success alerts after 5 seconds
                if (alert.classList.contains('alert-success')) {
                    setTimeout(function() {
                        if (alert && alert.parentNode) {
                            hideAlert(alert);
                        }
                    }, 5000);
                }

                // Auto-hide info alerts after 7 seconds
                if (alert.classList.contains('alert-info')) {
                    setTimeout(function() {
                        if (alert && alert.parentNode) {
                            hideAlert(alert);
                        }
                    }, 7000);
                }

                // Auto-hide warning alerts after 8 seconds
                if (alert.classList.contains('alert-warning')) {
                    setTimeout(function() {
                        if (alert && alert.parentNode) {
                            hideAlert(alert);
                        }
                    }, 8000);
                }
            });

            // Function to hide alert with animation
            function hideAlert(alert) {
                alert.style.transition = 'all 0.3s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateX(100%)';

                setTimeout(function() {
                    if (alert && alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }

            // Add click to close functionality
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-close') || e.target.closest('.btn-close')) {
                    const alert = e.target.closest('.alert');
                    if (alert) {
                        hideAlert(alert);
                        e.preventDefault();
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>