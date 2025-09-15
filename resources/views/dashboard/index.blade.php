@extends('layout.main')

<!-- @section('title', 'Dashboard - Competition Management') -->

@section('content')
<!-- Dashboard Section -->
<div id="dashboard-section" class="content-section fade-in">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
        <div>
            <h1 class="h2 fw-bold mb-2">
                <i class="fas fa-chart-line me-3" style="color: var(--primary);"></i>
                {{ $title ?? 'Dashboard Overview' }}
            </h1>
            <p class="text-muted">Monitor dan kelola kompetisi artikel dengan mudah</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-outline-primary me-2">
                <i class="fas fa-download me-2"></i>Export Data
            </button>
            <button type="button" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card pulse">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2 fw-medium">Total Artikel</p>
                        <h2 class="stats-number mb-0">156</h2>
                        <small class="text-success"><i class="fas fa-arrow-up me-1"></i>12% dari bulan lalu</small>
                    </div>
                    <div class="stats-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2 fw-medium">Pending Review</p>
                        <h2 class="stats-number mb-0">23</h2>
                        <small class="text-warning"><i class="fas fa-clock me-1"></i>Butuh perhatian</small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, var(--warning) 0%, #F39C12 100%);">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2 fw-medium">Approved</p>
                        <h2 class="stats-number mb-0">98</h2>
                        <small class="text-success"><i class="fas fa-check me-1"></i>Ready to publish</small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, var(--success) 0%, #00B894 100%);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="stats-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-2 fw-medium">Active Users</p>
                        <h2 class="stats-number mb-0">89</h2>
                        <small class="text-info"><i class="fas fa-users me-1"></i>Online sekarang</small>
                    </div>
                    <div class="stats-icon" style="background: linear-gradient(135deg, var(--info) 0%, #0984e3 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Activity -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Submission Trends</h5>
                        <small class="text-muted">Grafik submission artikel per bulan</small>
                    </div>
                    <div class="btn-group" role="group">
                        <input type="radio" class="btn-check" name="chartPeriod" id="monthly" checked>
                        <label class="btn btn-outline-primary btn-sm" for="monthly">Monthly</label>
                        <input type="radio" class="btn-check" name="chartPeriod" id="weekly">
                        <label class="btn btn-outline-primary btn-sm" for="weekly">Weekly</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-success rounded-circle p-2">
                                        <i class="fas fa-upload text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">New Article Submitted</h6>
                                    <p class="mb-1 small text-muted">"AI in Healthcare Revolution" by Dr. Sarah</p>
                                    <small class="text-muted">2 minutes ago</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-primary rounded-circle p-2">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Article Approved</h6>
                                    <p class="mb-1 small text-muted">"Machine Learning Basics" telah disetujui</p>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-info rounded-circle p-2">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">New Participant</h6>
                                    <p class="mb-1 small text-muted">John Doe bergabung dalam kompetisi</p>
                                    <small class="text-muted">3 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex">
                                <div class="me-3">
                                    <div class="bg-warning rounded-circle p-2">
                                        <i class="fas fa-exclamation text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold">Review Required</h6>
                                    <p class="mb-1 small text-muted">5 artikel menunggu review</p>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <a href="#" class="btn btn-outline-primary btn-sm w-100">View All Activities</a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">Approved</span>
                            <span class="fw-bold text-success">63%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 63%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">Under Review</span>
                            <span class="fw-bold text-warning">25%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 25%"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-medium">Rejected</span>
                            <span class="fw-bold text-danger">12%</span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: 12%"></div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-sync-alt me-2"></i>Refresh Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary btn-lg">
                                    <i class="fas fa-eye me-2"></i>Review Pending Articles
                                    <span class="badge bg-light text-dark ms-2">23</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-success btn-lg">
                                    <i class="fas fa-download me-2"></i>Export Approved
                                    <span class="badge bg-light text-dark ms-2">98</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-info btn-lg">
                                    <i class="fas fa-users me-2"></i>Manage Participants
                                    <span class="badge bg-light text-dark ms-2">89</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-grid">
                                <button class="btn btn-warning btn-lg">
                                    <i class="fas fa-chart-bar me-2"></i>View Reports
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Important Dates</h5>
                </div>
                <div class="card-body">
                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-primary rounded-circle p-2">
                                    <i class="fas fa-calendar text-white small"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-1">Submission Deadline</h6>
                                <p class="small text-muted mb-0">March 31, 2024</p>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item mb-3">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-warning rounded-circle p-2">
                                    <i class="fas fa-eye text-white small"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-1">Review Period</h6>
                                <p class="small text-muted mb-0">April 1-15, 2024</p>
                            </div>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <div class="bg-success rounded-circle p-2">
                                    <i class="fas fa-trophy text-white small"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="fw-semibold mb-1">Results Announcement</h6>
                                <p class="small text-muted mb-0">April 20, 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection