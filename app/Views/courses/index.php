<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4">Available Courses</h1>
            <p class="text-center text-muted">Browse and enroll in courses to start your learning journey</p>
        </div>
    </div>

        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
<<<<<<< HEAD
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="card-title text-primary">
                                    <a href="<?= base_url('course/view/' . $course['id']) ?>" class="text-decoration-none text-primary">
=======
<<<<<<< HEAD
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="card-title text-primary">
                                    <a href="<?= base_url('course/' . $course['id']) ?>" class="text-decoration-none text-primary">
>>>>>>> origin/recovered-master
                                        <?php echo htmlspecialchars($course['title']); ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    <?php 
                                    $description = $course['description'];
                                    echo strlen($description) > 100 ? 
                                        htmlspecialchars(substr($description, 0, 100)) . '...' : 
                                        htmlspecialchars($description);
                                    ?>
                                </p>

                                <?php if (isset($course['instructor_name'])): ?>
                                    <p class="card-text mb-2">
                                        <small class="text-muted">
                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                            <?php echo htmlspecialchars($course['instructor_name']); ?>
                                        </small>
                                    </p>
                                <?php endif; ?>

                                <?php if (!empty($course['level'])): ?>
                                    <span class="badge bg-secondary mb-2">
                                        <?php echo htmlspecialchars($course['level']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-info">
                                        <i class="fas fa-users me-1"></i>
                                        <?php echo $course['enrollment_count']; ?> enrolled
                                    </span>

                                    <?php if (in_array($course['id'], $enrolledCourseIds)): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Enrolled
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-grid gap-2">
<<<<<<< HEAD
                                    <a href="<?= base_url('course/view/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>View Details
                                    </a>
                                    
                                    <?php if ($user['role'] === 'student'): ?>
                                        <?php if (!in_array($course['id'], $enrolledCourseIds)): ?>
                                            <button class="btn btn-primary btn-sm enroll-btn"
                                                    data-course-id="<?php echo $course['id']; ?>">
                                                <i class="fas fa-plus me-1"></i>Enroll Now
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-success btn-sm" disabled>
                                                <i class="fas fa-check me-1"></i>Enrolled
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
=======
                                    <a href="<?= base_url('course/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>View Details
                                    </a>
                                    
                                    <?php if (!in_array($course['id'], $enrolledCourseIds)): ?>
                                        <button class="btn btn-primary btn-sm enroll-btn"
                                                data-course-id="<?php echo $course['id']; ?>">
                                            <i class="fas fa-plus me-1"></i>Enroll Now
                                        </button>
                                    <?php endif; ?>
                                </div>
=======
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo htmlspecialchars($course['title']); ?></h5>
                            <p class="card-text text-muted"><?php echo htmlspecialchars($course['description']); ?></p>

                            <?php if (isset($course['instructor_name'])): ?>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="fas fa-chalkboard-teacher me-1"></i>Instructor: <?php echo htmlspecialchars($course['instructor_name']); ?>
                                    </small>
                                </p>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-info">
                                    <i class="fas fa-users me-1"></i><?php echo $course['enrollment_count']; ?> enrolled
                                </span>

                                <?php if (in_array($course['id'], $enrolledCourseIds)): ?>
                                    <button class="btn btn-success btn-sm" disabled>
                                        <i class="fas fa-check me-1"></i>Enrolled
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-primary btn-sm enroll-btn"
                                            data-course-id="<?php echo $course['id']; ?>">
                                        <i class="fas fa-plus me-1"></i>Enroll
                                    </button>
                                <?php endif; ?>
>>>>>>> 4ea0f464c41604ac8b9ef56ccd448fdc7b56931e
>>>>>>> origin/recovered-master
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No courses available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
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

            // Make AJAX request
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
                    // Update button to show enrolled state
                    this.className = 'btn btn-success btn-sm';
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Enrolled';
                    this.disabled = true;

                    // Show success message
                    showAlert('Success! You have been enrolled in the course.', 'success');
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
