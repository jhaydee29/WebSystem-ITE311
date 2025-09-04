<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Dashboard</h1>
            <span class="badge bg-success fs-6">Welcome, <?= session()->get('name') ?>!</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Stats Cards -->
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Courses</h6>
                        <h2 class="mb-0">12</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Completed</h6>
                        <h2 class="mb-0">8</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">In Progress</h6>
                        <h2 class="mb-0">3</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Assignments</h6>
                        <h2 class="mb-0">5</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-tasks fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Recent Activity -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Completed Assignment: Database Design</div>
                            <small class="text-muted">ITE311 - Database Systems</small>
                        </div>
                        <small class="text-muted">2 hours ago</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Started Course: Web Development</div>
                            <small class="text-muted">ITE312 - Web Programming</small>
                        </div>
                        <small class="text-muted">1 day ago</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Quiz Submitted: PHP Fundamentals</div>
                            <small class="text-muted">Score: 95/100</small>
                        </div>
                        <small class="text-muted">3 days ago</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-start border-0 px-0">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Joined Discussion: MVC Architecture</div>
                            <small class="text-muted">ITE311 - Database Systems</small>
                        </div>
                        <small class="text-muted">1 week ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Enroll in Course
                    </button>
                    <button class="btn btn-success">
                        <i class="fas fa-upload me-2"></i>Submit Assignment
                    </button>
                    <button class="btn btn-info">
                        <i class="fas fa-calendar me-2"></i>View Schedule
                    </button>
                    <button class="btn btn-warning">
                        <i class="fas fa-comments me-2"></i>Join Discussion
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-4">
    <!-- Upcoming Deadlines -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Upcoming Deadlines
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div>
                            <div class="fw-bold">System Analysis Report</div>
                            <small class="text-muted">ITE311 - Database Systems</small>
                        </div>
                        <span class="badge bg-danger">2 days</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div>
                            <div class="fw-bold">PHP Project Submission</div>
                            <small class="text-muted">ITE312 - Web Programming</small>
                        </div>
                        <span class="badge bg-warning">5 days</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                        <div>
                            <div class="fw-bold">Final Exam</div>
                            <small class="text-muted">ITE313 - Software Engineering</small>
                        </div>
                        <span class="badge bg-info">2 weeks</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Progress Overview -->
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>Progress Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Database Systems</span>
                        <span>85%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Web Programming</span>
                        <span>72%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: 72%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Software Engineering</span>
                        <span>60%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" style="width: 60%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="fw-bold">Network Security</span>
                        <span>45%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-danger" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>