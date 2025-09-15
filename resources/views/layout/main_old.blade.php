<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Manajemen Artikel')</title>

    <!-- External CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

:root {
--primary: #FFD700;
--primary-dark: #F4C430;
--primary-light: #FFF8DC;
--secondary: #1A1A2E;
--accent: #16213E;
--success: #00D4AA;
--danger: #FF6B6B;
--warning: #FFB800;
--info: #4FC3F7;
--gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
--gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
--gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
--gradient-gold: linear-gradient(135deg, #FFD700 0%, #FFA500 50%, #FF8C00 100%);
--shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
--shadow-hover: 0 20px 60px rgba(0, 0, 0, 0.15);
--border-radius: 20px;
}

* {
margin: 0;
padding: 0;
box-sizing: border-box;
}

body {
font-family: 'Inter', sans-serif;
background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
min-height: 100vh;
overflow-x: hidden;
}

/* Floating Elements Animation */
.floating-shapes {
position: fixed;
top: 0;
left: 0;
width: 100%;
height: 100%;
pointer-events: none;
z-index: -1;
}

.shape {
position: absolute;
border-radius: 50%;
background: var(--gradient-gold);
opacity: 0.1;
animation: float 20s infinite linear;
}

.shape:nth-child(1) {
width: 80px;
height: 80px;
top: 10%;
left: 10%;
animation-delay: 0s;
}

.shape:nth-child(2) {
width: 120px;
height: 120px;
top: 70%;
right: 10%;
animation-delay: 5s;
}

.shape:nth-child(3) {
width: 60px;
height: 60px;
bottom: 20%;
left: 20%;
animation-delay: 10s;
}

@keyframes float {

0%,
100% {
transform: translateY(0px) rotate(0deg);
}

50% {
transform: translateY(-20px) rotate(180deg);
}
}

/* Navbar */
.navbar {
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(20px);
border-bottom: 1px solid rgba(255, 215, 0, 0.2);
box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
position: sticky;
top: 0;
z-index: 1000;
}

.navbar-brand {
font-weight: 800;
font-size: 1.5rem;
background: var(--gradient-gold);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.navbar-toggler {
border: none;
padding: 8px 12px;
border-radius: 12px;
background: var(--gradient-gold);
transition: all 0.3s ease;
}

.navbar-toggler:focus {
box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
}

/* Sidebar */
.sidebar {
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(20px);
height: calc(100vh - 80px);
border-radius: 0 var(--border-radius) var(--border-radius) 0;
box-shadow: var(--shadow);
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
border-right: 3px solid transparent;
background-image: linear-gradient(rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.95)),
linear-gradient(135deg, var(--primary), var(--primary-dark));
background-origin: border-box;
background-clip: content-box, border-box;
position: fixed;
top: 80px;
left: 0;
z-index: 1000;
overflow-y: auto;
}

.nav-link {
color: var(--secondary);
padding: 16px 24px;
margin: 8px 16px;
border-radius: 16px;
font-weight: 500;
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
position: relative;
overflow: hidden;
}

.nav-link::before {
content: '';
position: absolute;
top: 0;
left: -100%;
width: 100%;
height: 100%;
background: var(--gradient-gold);
transition: left 0.3s ease;
z-index: -1;
}

.nav-link:hover::before,
.nav-link.active::before {
left: 0;
}

.nav-link:hover,
.nav-link.active {
color: var(--secondary);
transform: translateX(8px) scale(1.02);
box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.nav-link i {
width: 20px;
margin-right: 12px;
}

@media (max-width: 767.98px) {
.sidebar {
position: fixed;
top: 80px;
left: 0;
z-index: 1000;
width: 320px;
transform: translateX(-100%);
height: calc(100vh - 80px);
overflow-y: auto;
border-radius: 0 var(--border-radius) var(--border-radius) 0;
}

.sidebar.show {
transform: translateX(0);
}

.sidebar-backdrop {
position: fixed;
top: 80px;
left: 0;
width: 100vw;
height: calc(100vh - 80px);
background: rgba(0, 0, 0, 0.6);
backdrop-filter: blur(5px);
z-index: 999;
opacity: 0;
visibility: hidden;
transition: all 0.3s ease;
}

.sidebar-backdrop.show {
opacity: 1;
visibility: visible;
}

.main-content {
margin-left: 0 !important;
}
}

@media (min-width: 768px) {
.main-content {
margin-left: 250px;
}
}

/* Main Content */
.main-content {
padding: 40px;
background: transparent;
min-height: calc(100vh - 80px);
}

/* Cards */
.card {
border: none;
border-radius: var(--border-radius);
box-shadow: var(--shadow);
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
overflow: hidden;
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(20px);
}

.card:hover {
transform: translateY(-10px);
box-shadow: var(--shadow-hover);
}

.card-header {
background: var(--gradient-gold);
border: none;
padding: 24px 30px;
font-weight: 600;
color: var(--secondary);
}

.stats-card {
background: rgba(255, 255, 255, 0.95);
backdrop-filter: blur(20px);
border-radius: var(--border-radius);
padding: 30px;
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
position: relative;
overflow: hidden;
}

.stats-card::before {
content: '';
position: absolute;
top: 0;
left: 0;
right: 0;
height: 6px;
background: var(--gradient-gold);
}

.stats-card:hover {
transform: translateY(-8px) scale(1.02);
box-shadow: var(--shadow-hover);
}

.stats-number {
font-size: 2.5rem;
font-weight: 800;
background: var(--gradient-gold);
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
}

.stats-icon {
width: 60px;
height: 60px;
border-radius: 16px;
display: flex;
align-items: center;
justify-content: center;
font-size: 1.5rem;
background: var(--gradient-gold);
color: white;
}

/* Buttons */
.btn {
border-radius: 12px;
font-weight: 600;
padding: 12px 24px;
border: none;
transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
text-transform: uppercase;
letter-spacing: 0.5px;
font-size: 0.85rem;
}

.btn-primary {
background: var(--gradient-gold);
color: var(--secondary);
box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
}

.btn-primary:hover {
transform: translateY(-2px);
box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
color: var(--secondary);
}

.btn-success {
background: linear-gradient(135deg, var(--success) 0%, #00B894 100%);
color: white;
}

.btn-danger {
background: linear-gradient(135deg, var(--danger) 0%, #E84393 100%);
color: white;
}

.btn-info {
background: linear-gradient(135deg, var(--info) 0%, #0984e3 100%);
color: white;
}

.btn-warning {
background: linear-gradient(135deg, var(--warning) 0%, #F39C12 100%);
color: white;
}

/* Form Controls */
.form-control,
.form-select {
border: 2px solid rgba(255, 215, 0, 0.2);
border-radius: 12px;
padding: 12px 16px;
background: rgba(255, 255, 255, 0.9);
backdrop-filter: blur(10px);
transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
border-color: var(--primary);
box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
background: rgba(255, 255, 255, 1);
}

/* Custom Scrollbar */
::-webkit-scrollbar {
width: 8px;
}

::-webkit-scrollbar-track {
background: rgba(255, 255, 255, 0.1);
border-radius: 10px;
}

::-webkit-scrollbar-thumb {
background: var(--gradient-gold);
border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
background: var(--primary-dark);
}

/* Animation Classes */
.fade-in {
animation: fadeIn 0.6s ease-in-out;
}

@keyframes fadeIn {
from {
opacity: 0;
transform: translateY(30px);
}

to {
opacity: 1;
transform: translateY(0);
}
}

@media (max-width: 768px) {
.main-content {
padding: 20px;
}

.card-body {
padding: 20px;
}
}
</style>
</head>

<body>
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn d-md-none me-3" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">
                <i class="fas fa-trophy me-2"></i>
                <span class="d-none d-sm-inline">Competition Dashboard</span>
                <span class="d-sm-none">Dashboard</span>
            </a>
            <div class="d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        <span class="d-none d-sm-inline">Admin</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell me-2"></i>Notifikasi</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Backdrop (Mobile) -->
            <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar" id="sidebar">
                <div class="position-sticky pt-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 d-md-none px-3">
                        <h6 class="mb-0 fw-bold">Menu Navigation</h6>
                        <button type="button" class="btn-close" id="sidebarClose"></button>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-section="dashboard">
                                <i class="fas fa-chart-line"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="upload">
                                <i class="fas fa-cloud-upload-alt"></i>
                                Upload Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="manage">
                                <i class="fas fa-tasks"></i>
                                Kelola Artikel
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="participants">
                                <i class="fas fa-users"></i>
                                Peserta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-section="reports">
                                <i class="fas fa-analytics"></i>
                                Analytics
                            </a>
                        </li>
                        <li class="nav-item mt-4">
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
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

    <script>
        // Global variables
        let currentSection = 'dashboard';

        // DOM elements
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebar = document.getElementById('sidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');
        const navLinks = document.querySelectorAll('.nav-link[data-section]');
        const contentSections = document.querySelectorAll('.content-section');

        // Sidebar functionality
        function openSidebar() {
            sidebar.classList.add('show');
            sidebarBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Event listeners
        sidebarToggle?.addEventListener('click', openSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);
        sidebarBackdrop?.addEventListener('click', closeSidebar);

        // Responsive sidebar handling
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</body>

</html>