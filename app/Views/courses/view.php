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
                            <?php if ($user['role'] === 'student'): ?>
                                <?php if ($isEnrolled): ?>
                                    <div class="mt-2">
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i> Enrolled
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="mt-2">
                                        <button class="btn btn-primary enroll-btn" data-course-id="<?= $course['id'] ?>">
                                            <i class="fas fa-plus me-1"></i> Enroll Now
                                        </button>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($user['role'] === 'teacher'): ?>
                                <?php if ($course['instructor_id'] == $user['id']): ?>
                                    <div class="mt-2">
                                        <span class="badge bg-info">
                                            <i class="fas fa-chalkboard-teacher me-1"></i> Your Course
                                        </span>
                                    </div>
                                <?php endif; ?>
                            <?php elseif ($user['role'] === 'admin'): ?>
                                <div class="mt-2">
                                    <span class="badge bg-warning">
                                        <i class="fas fa-crown me-1"></i> Admin Access
                                    </span>
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
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STEP 6: Course Materials Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Course Materials</h5>
                                    <?php if ($canUploadMaterials): ?>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadMaterialModal">
                                            <i class="fas fa-upload me-1"></i> Upload Material
                                        </button>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <div id="materialAlerts"></div>
                                    <?php if (empty($materials)): ?>
                                        <div class="text-center text-muted py-4">
                                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                                            <p>No materials uploaded yet.</p>
                                        </div>
                                    <?php else: ?>
                                        <div class="list-group">
                                            <?php foreach ($materials as $material): ?>
                                                <div class="list-group-item">
                                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">
                                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                                <?= esc($material['title']) ?>
                                                            </h6>
                                                            <p class="mb-1 text-muted small"><?= esc($material['description'] ?? 'No description') ?></p>
                                                            <small class="text-muted">
                                                                Uploaded by <?= esc($material['uploader_name']) ?> on 
                                                                <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                            </small>
                                                        </div>
                                                        <div>
                                                            <?php if ($isEnrolled || $user['role'] === 'admin' || ($user['role'] === 'teacher' && $course['instructor_id'] == $user['id'])): ?>
                                                                <a href="<?= base_url('material/download/' . $material['id']) ?>" 
                                                                   class="btn btn-success btn-sm">
                                                                    <i class="fas fa-download me-1"></i> Download
                                                                </a>
                                                                <?php if ($canUploadMaterials): ?>
                                                                    <form action="<?= site_url('material/delete/' . $material['id']) ?>" method="post" class="d-inline delete-material-form">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted small">
                                                                    <i class="fas fa-lock me-1"></i> Enroll to download
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<?php if ($canUploadMaterials): ?>
<div class="modal fade" id="uploadMaterialModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Course Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="uploadMaterialForm" method="post" action="<?= site_url('material/upload') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="material_file" 
                               accept=".pdf,.ppt,.pptx,.doc,.docx" required>
                        <div class="form-text">Allowed: PDF, PPT, PPTX, DOC, DOCX (Max 10MB)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="uploadMaterialBtn">
                        <i class="fas fa-upload me-1"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Enroll Modal -->
<div class="modal fade" id="enrollModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enroll in Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    const enrollButtons = document.querySelectorAll('.enroll-btn');
    const confirmEnrollBtn = document.getElementById('confirmEnroll');
    let currentCourseId = null;

    enrollButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentCourseId = this.getAttribute('data-course-id');
            const modal = new bootstrap.Modal(document.getElementById('enrollModal'));
            modal.show();
        });
    });

    if (confirmEnrollBtn) {
        confirmEnrollBtn.addEventListener('click', function() {
            if (!currentCourseId) return;
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Enrolling...';

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
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to enroll');
                }
            });
        });
    }

    const uploadForm = document.getElementById('uploadMaterialForm');
    const materialAlerts = document.getElementById('materialAlerts');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('uploadMaterialBtn');
            const formData = new FormData(uploadForm);
            const actionUrl = uploadForm.getAttribute('action');
            const currentModal = bootstrap.Modal.getInstance(document.getElementById('uploadMaterialModal'));

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Uploading...';

            fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.csrf) {
                    const csrfInputs = document.querySelectorAll('input[name="<?= csrf_token() ?>"]');
                    csrfInputs.forEach(input => input.value = data.csrf);
                }
                if (data.success) {
                    if (currentModal) {
                        uploadForm.reset();
                        currentModal.hide();
                    }
                    if (materialAlerts) {
                        materialAlerts.innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>${data.message || 'Material uploaded successfully!'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                    }
                    setTimeout(() => window.location.reload(), 1200);
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload';
                    const message = data.message || 'Upload failed';
                    if (materialAlerts) {
                        materialAlerts.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                    } else {
                        alert(message);
                    }
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-upload me-1"></i> Upload';
                if (materialAlerts) {
                    materialAlerts.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>Upload error! Check console for details.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                } else {
                    alert('Upload error! Check console for details.');
                }
            });
        });
    }

    const deleteForms = document.querySelectorAll('.delete-material-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            if (!confirm('Delete this material?')) {
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

            const formData = new FormData(form);
            const actionUrl = form.getAttribute('action');

            fetch(actionUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.csrf) {
                    document.querySelectorAll('input[name="<?= csrf_token() ?>"]').forEach(input => input.value = data.csrf);
                }

                if (data.success) {
                    if (materialAlerts) {
                        materialAlerts.innerHTML = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>${data.message || 'Material deleted successfully!'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                    }
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
                    const message = data.message || 'Delete failed';
                    if (materialAlerts) {
                        materialAlerts.innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                    } else {
                        alert(message);
                    }
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if (materialAlerts) {
                    materialAlerts.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>Delete error! Check console for details.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                } else {
                    alert('Delete error! Check console for details.');
                }
            });
        });
    });
});
</script>
<?= $this->endSection() ?>
