<?= $this->extend('dashboard_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">Dashboard</h1>
        <div class="d-flex align-items-center gap-3">
            <!-- Role-specific navigation -->
            <?php if (session()->get('isLoggedIn')): ?>
                <?php $userRole = session()->get('role'); ?>

                <?php if ($userRole === 'admin'): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog me-2"></i>Management
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>User Management</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-book me-2"></i>Course Management</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar me-2"></i>Reports</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-wrench me-2"></i>System Settings</a></li>
                        </ul>
                    </div>

                <?php elseif ($userRole === 'teacher'): ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Teaching
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-book me-2"></i>My Courses</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-graduation-cap me-2"></i>Gradebook</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tasks me-2"></i>Assignments</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>My Students</a></li>
                        </ul>
                    </div>

                <?php else: ?>
                    <div class="dropdown">
                        <button class="btn btn-outline-info dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-graduation-cap me-2"></i>Learning
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-book me-2"></i>My Courses</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Grades</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-tasks me-2"></i>Assignments</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-book-open me-2"></i>Resources</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- User menu -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user me-2"></i>Welcome, <?= $user['name'] ?> (<?= ucfirst($user['role']) ?>)
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Debug: Show user role data (temporarily hidden) -->
    <div class="alert alert-info" style="display: none;">
        <strong>Debug Info:</strong>
        User: <?= $user['name'] ?> |
        Role: <?= $user['role'] ?> |
        Email: <?= $user['email'] ?>
    </div>

    <?php $this->section('dashboard_content') ?>
    <?php if ($user['role'] === 'admin'): ?>
        <!-- Admin Dashboard Content -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <h2 class="mb-0"><?= $stats['total_users'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Courses</h5>
                    <h2 class="mb-0"><?= $stats['total_courses'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Recent Registrations</h5>
                    <h2 class="mb-0"><?= $stats['recent_registrations'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Active Courses</h5>
                    <h2 class="mb-0"><?= $stats['active_courses'] ?></h2>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'teacher'): ?>
        <!-- Teacher Dashboard Content -->
        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">My Courses</h5>
                    <h2 class="mb-0"><?= $stats['my_courses'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Students</h5>
                    <h2 class="mb-0"><?= $stats['total_students'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Pending Reviews</h5>
                    <h2 class="mb-0"><?= $stats['pending_submissions'] ?></h2>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Student Dashboard Content -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">My Learning Progress</h5>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary"><?= $stats['enrolled_courses'] ?></h4>
                            <small class="text-muted">Enrolled Courses</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?= $stats['completed_courses'] ?></h4>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info"><?= $stats['total_submissions'] ?></h4>
                            <small class="text-muted">Total Submissions</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning"><?= number_format($stats['average_grade'], 1) ?></h4>
                            <small class="text-muted">Average Grade</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Courses Section -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>My Enrolled Courses
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrolledCourses)): ?>
                        <div class="row">
                            <?php foreach ($enrolledCourses as $course): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card border-success h-100">
                                        <div class="card-body">
                                            <h6 class="card-title text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                <?php echo htmlspecialchars($course['course_name']); ?>
                                            </h6>
                                            <p class="card-text text-muted small">
                                                <?php echo htmlspecialchars(substr($course['description'], 0, 100) . (strlen($course['description']) > 100 ? '...' : '')); ?>
                                            </p>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Enrolled: <?php echo date('M d, Y', strtotime($course['enrollment_date'])); ?>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-info-circle text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No Enrolled Courses</h5>
                            <p class="text-muted">You haven't enrolled in any courses yet. Browse available courses below to get started!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Available Courses Section -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Available Courses
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($availableCourses)): ?>
                        <div class="row">
                            <?php foreach ($availableCourses as $course): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <?php echo htmlspecialchars($course['title']); ?>
                                            </h6>
                                            <p class="card-text text-muted small">
                                                <?php echo htmlspecialchars(substr($course['description'], 0, 100) . (strlen($course['description']) > 100 ? '...' : '')); ?>
                                            </p>
                                            <?php if (!empty($course['instructor_name'])): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-chalkboard-teacher me-1"></i>
                                                    <?php echo htmlspecialchars($course['instructor_name']); ?>
                                                </small>
                                            <?php endif; ?>
                                            <div class="mt-3">
                                                <button class="btn btn-primary btn-sm enroll-btn"
                                                        data-course-id="<?php echo $course['id']; ?>">
                                                    <i class="fas fa-plus me-1"></i>Enroll Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-trophy text-success fa-3x mb-3"></i>
                            <h5 class="text-success">All Courses Enrolled!</h5>
                            <p class="text-muted">Congratulations! You're enrolled in all available courses.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Recent Activity</h5>
                    <div class="activity-list">
                        <div class="activity-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Completed Assignment: Database Design</small>
                        </div>
                        <div class="activity-item">
                            <i class="fas fa-play-circle text-info me-2"></i>
                            <small>Started Course: Web Development</small>
                        </div>
                        <div class="activity-item">
                            <i class="fas fa-clipboard-check text-primary me-2"></i>
                            <small>Quiz Submitted: PHP Fundamentals</small>
                        </div>
                        <div class="activity-item">
                            <i class="fas fa-comments text-secondary me-2"></i>
                            <small>Joined Discussion: MVC Architecture</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php $this->endSection() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const enrollButtons = document.querySelectorAll('.enroll-btn');

    enrollButtons.forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.getAttribute('data-course-id');
            const originalText = this.innerHTML;

            // Show loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Enrolling...';
            this.disabled = true;

            // Make AJAX request to enroll
            fetch('<?php echo base_url('course/enroll'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'course_id=' + courseId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button to show success
                    this.className = 'btn btn-success btn-sm';
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Enrolled';
                    this.disabled = true;

                    // Show success message
                    showAlert('Successfully enrolled in the course!', 'success');

                    // Reload page after 2 seconds to show updated data
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    showAlert(data.message, 'danger');
                    // Reset button
                    this.innerHTML = originalText;
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred while enrolling. Please try again.', 'danger');
                // Reset button
                this.innerHTML = originalText;
                this.disabled = false;
            });
        });
    });

    function showAlert(message, type) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', alertHtml);

        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert-dismissible');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
});
</script>

<?= $this->endSection() ?>