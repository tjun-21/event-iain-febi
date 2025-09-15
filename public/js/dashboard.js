// Dashboard JavaScript Module
class Dashboard {
    constructor() {
        this.currentSection = 'dashboard';
        this.init();
    }

    init() {
        this.initializeElements();
        this.bindEvents();
        this.initializeTooltips();
    }

    initializeElements() {
        // DOM elements
        this.sidebarToggle = document.getElementById('sidebarToggle');
        this.sidebarClose = document.getElementById('sidebarClose');
        this.sidebar = document.getElementById('sidebar');
        this.sidebarBackdrop = document.getElementById('sidebarBackdrop');
        this.navLinks = document.querySelectorAll('.nav-link[data-section]');
        this.contentSections = document.querySelectorAll('.content-section');
    }

    bindEvents() {
        // Sidebar events
        this.sidebarToggle?.addEventListener('click', () => this.openSidebar());
        this.sidebarClose?.addEventListener('click', () => this.closeSidebar());
        this.sidebarBackdrop?.addEventListener('click', () => this.closeSidebar());

        // Responsive handling
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                this.closeSidebar();
            }
        });

        // Navigation links
        this.navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const sectionId = link.dataset.section;
                if (sectionId) {
                    this.showSection(sectionId);
                }
            });
        });
    }

    // Sidebar functionality
    openSidebar() {
        if (this.sidebar && this.sidebarBackdrop) {
            this.sidebar.classList.add('show');
            this.sidebarBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    }

    closeSidebar() {
        if (this.sidebar && this.sidebarBackdrop) {
            this.sidebar.classList.remove('show');
            this.sidebarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
    }

    // Navigation functionality
    showSection(sectionId) {
        // Hide all sections
        this.contentSections.forEach(section => {
            section.classList.add('d-none');
            section.classList.remove('fade-in');
        });

        // Show target section
        const targetSection = document.getElementById(sectionId + '-section');
        if (targetSection) {
            targetSection.classList.remove('d-none');
            setTimeout(() => {
                targetSection.classList.add('fade-in');
            }, 10);
        }

        // Update nav links
        this.navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.dataset.section === sectionId) {
                link.classList.add('active');
            }
        });

        this.currentSection = sectionId;

        // Close sidebar on mobile
        if (window.innerWidth < 768) {
            this.closeSidebar();
        }
    }

    // Initialize Bootstrap tooltips
    initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Statistics animation
    animateStats() {
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statsNumbers = entry.target.querySelectorAll('.stats-number');
                    statsNumbers.forEach(stat => {
                        this.animateNumber(stat);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all stats cards
        document.querySelectorAll('.stats-card').forEach(card => {
            observer.observe(card);
        });
    }

    animateNumber(element) {
        const finalValue = parseInt(element.textContent);
        let currentValue = 0;
        const increment = finalValue / 30;

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                element.textContent = finalValue;
                clearInterval(timer);
            } else {
                element.textContent = Math.round(currentValue);
            }
        }, 50);
    }

    // Dynamic greeting based on time
    updateGreeting() {
        const now = new Date();
        const hour = now.getHours();
        let greeting = 'Good Morning';

        if (hour >= 12 && hour < 17) {
            greeting = 'Good Afternoon';
        } else if (hour >= 17) {
            greeting = 'Good Evening';
        }

        const greetingElements = document.querySelectorAll('.greeting');
        greetingElements.forEach(el => {
            el.textContent = greeting;
        });
    }

    // Enhanced search functionality
    initializeSearch() {
        const searchInputs = document.querySelectorAll('input[placeholder*="Search"], input[placeholder*="search"]');
        searchInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                this.performSearch(searchTerm);
            });
        });
    }

    performSearch(term) {
        // Add your search logic here
        console.log('Searching for:', term);
    }

    // Enhanced form validation
    initializeFormValidation() {
        // Hanya validate form dengan class 'validate-form', bukan semua form
        const forms = document.querySelectorAll('form.validate-form');
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.validateForm(form);
            });
        });
    }

    validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });

        if (isValid) {
            this.showSubmissionSuccess(form);
        }
    }

    showSubmissionSuccess(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
            submitBtn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Success!';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');

                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.classList.remove('btn-success');
                    submitBtn.classList.add('btn-primary');
                    submitBtn.disabled = false;
                    form.reset();
                }, 2000);
            }, 1500);
        }
    }

    // File upload functionality
    initializeFileUpload() {
        const fileInput = document.getElementById('fileInput');
        const uploadArea = document.querySelector('.upload-area');

        if (fileInput && uploadArea) {
            fileInput.addEventListener('change', (e) => this.handleFileSelect(e));
            
            // Drag and drop functionality
            uploadArea.addEventListener('dragover', (e) => this.handleDragOver(e));
            uploadArea.addEventListener('dragleave', (e) => this.handleDragLeave(e));
            uploadArea.addEventListener('drop', (e) => this.handleFileDrop(e));
        }
    }

    handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            const uploadContent = document.querySelector('.upload-content');
            if (uploadContent) {
                uploadContent.innerHTML = `
                    <i class="fas fa-file-check fa-4x text-success mb-3"></i>
                    <h4 class="fw-bold mb-2 text-success">File Selected!</h4>
                    <p class="text-muted mb-3">${file.name}</p>
                    <small class="text-muted">Size: ${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                `;
            }
        }
    }

    handleDragOver(e) {
        e.preventDefault();
        const uploadArea = e.currentTarget;
        uploadArea.style.background = 'linear-gradient(135deg, rgba(255, 215, 0, 0.2) 0%, rgba(255, 255, 255, 0.95) 100%)';
    }

    handleDragLeave(e) {
        e.preventDefault();
        const uploadArea = e.currentTarget;
        uploadArea.style.background = '';
    }

    handleFileDrop(e) {
        e.preventDefault();
        const uploadArea = e.currentTarget;
        uploadArea.style.background = '';

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const fileInput = document.getElementById('fileInput');
            if (fileInput) {
                fileInput.files = files;
                fileInput.dispatchEvent(new Event('change'));
            }
        }
    }

    // Auto refresh data
    startAutoRefresh() {
        setInterval(() => {
            console.log('Auto refreshing data...');
            // Add your data refresh logic here
        }, 30000); // Refresh every 30 seconds
    }
}

// Initialize Dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const dashboard = new Dashboard();
    
    // Initialize additional features
    dashboard.animateStats();
    dashboard.updateGreeting();
    dashboard.initializeSearch();
    dashboard.initializeFormValidation();
    dashboard.initializeFileUpload();
    dashboard.startAutoRefresh();
    
    // Show dashboard section by default
    if (dashboard.contentSections.length > 0) {
        dashboard.showSection('dashboard');
    }
});

// Export for potential use in other modules
window.Dashboard = Dashboard;
