<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($course['title']) ?></li>
                </ol>
            </nav>
            
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?= session('error') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success">
                    <?= session('success') ?>
                </div>
            <?php endif; ?>
            
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <h1 class="h3 mb-2"><?= esc($course['title']) ?></h1>
                            <p class="text-muted mb-0">
                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                Instructor: <?= esc($instructor['name'] ?? 'N/A') ?>
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary mb-2">
                                <i class="fas fa-users me-1"></i> 
                                <?= $enrolledStudents ?> enrolled
                            </span>
                            <?php if ($isEnrolled): ?>
                                <div class="mt-2">
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Enrolled
                                    </span>
                                    <?php if ($enrollment && isset($enrollment['enrollment_date'])): ?>
                                        <div class="text-muted small mt-1">
                                            Since <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="mt-2">
                                    <button class="btn btn-primary enroll-btn" data-course-id="<?= $course['id'] ?>">
                                        <i class="fas fa-plus me-1"></i> Enroll Now
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Course Description</h5>
                                </div>
                                <div class="card-body">
                                    <?= nl2br(esc($course['description'])) ?>
                                </div>
                            </div>
                            
                            <?php if (!empty($course['learning_outcomes'])): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">What You'll Learn</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <?php 
                                            $outcomes = explode("\n", $course['learning_outcomes']);
                                            foreach ($outcomes as $outcome): 
                                                if (trim($outcome) !== ''):
                                            ?>
                                                <li class="list-group-item">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <?= esc(trim($outcome)) ?>
                                                </li>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Course Details</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-user-graduate me-2 text-primary"></i> Level</span>
                                            <span class="badge bg-primary"><?= esc($course['level'] ?? 'Beginner') ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-clock me-2 text-primary"></i> Duration</span>
                                            <span><?= esc($course['duration'] ?? 'Self-paced') ?></span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-tasks me-2 text-primary"></i> Modules</span>
                                            <span><?= $course['module_count'] ?? 0 ?> modules</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span><i class="fas fa-language me-2 text-primary"></i> Language</span>
                                            <span>English</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <?php if (!empty($course['prerequisites'])): ?>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Prerequisites</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-unstyled">
                                            <?php 
                                            $prerequisites = explode("\n", $course['prerequisites']);
                                            foreach ($prerequisites as $prereq): 
                                                if (trim($prereq) !== ''):
                                            ?>
                                                <li class="mb-2">
                                                    <i class="fas fa-arrow-right text-muted me-2"></i>
                                                    <?= esc(trim($prereq)) ?>
                                                </li>
                                            <?php 
                                                endif;
                                            endforeach; 
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enroll Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollModalLabel">Enroll in Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enroll in <strong><?= esc($course['title']) ?></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmEnroll">Yes, Enroll Me</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enroll button click handler
    const enrollButtons = document.querySelectorAll('.enroll-btn');
    const confirmEnrollBtn = document.getElementById('confirmEnroll');
    let currentCourseId = null;
    
    // Set up enroll buttons
    enrollButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentCourseId = this.getAttribute('data-course-id');
            const modal = new bootstrap.Modal(document.getElementById('enrollModal'));
            modal.show();
        });
    });
    
    // Confirm enrollment
    if (confirmEnrollBtn) {
        confirmEnrollBtn.addEventListener('click', function() {
            if (!currentCourseId) return;
            
            const button = this;
            const originalText = button.innerHTML;
            
            // Show loading state
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Enrolling...';
            
            // Make AJAX request
            fetch('<?= base_url('course/enroll') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: 'course_id=' + currentCourseId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('enrollModal'));
                    modal.hide();
                    
                    // Show success message
                    showAlert('Success! You have been enrolled in the course.', 'success');
                    
                    // Update UI
                    window.location.reload();
                } else {
                    showAlert(data.message || 'Failed to enroll. Please try again.', 'danger');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('An error occurred. Please try again.', 'danger');
                button.innerHTML = originalText;
                button.disabled = false;
            });
        });
    }
    
    // Helper function to show alerts
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = document.querySelector('.container');
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            const alert = bootstrap.Alert.getOrCreateInstance(alertDiv);
            if (alert) alert.close();
        }, 5000);
    }
});
</script>
<?= $this->endSection() ?>
