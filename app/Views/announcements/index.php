<?php 
// Debug: Check if announcements data is available
// echo '<pre>';
// print_r($announcements);
// echo '</pre>';
?>

<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Announcements</h1>
                <?php if (session()->get('role') === 'admin'): ?>
                    <a href="<?= base_url('announcements/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> New Announcement
                    </a>
                <?php endif; ?>
            </div>
            
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php 
            // Debug: Check if announcements is set and is an array
            if (!isset($announcements) || !is_array($announcements)): 
                echo '<div class="alert alert-warning">Announcements data is not available or in wrong format.</div>';
                echo '<pre>'; print_r($announcements); echo '</pre>';
            elseif (empty($announcements)): 
            ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No announcements found.
                </div>
            <?php else: ?>
                <div class="list-group">
                    <?php foreach ($announcements as $announcement): ?>
                        <div class="list-group-item mb-3 rounded shadow-sm">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-primary"><?= esc($announcement['title'] ?? 'No Title') ?></h5>
                                <small class="text-muted">
                                    <?= isset($announcement['created_at']) ? date('M d, Y h:i A', strtotime($announcement['created_at'])) : 'No date' ?>
                                </small>
                            </div>
                            <p class="mb-1"><?= isset($announcement['content']) ? nl2br(esc($announcement['content'])) : 'No content' ?></p>
                            <small class="text-muted">
                                Posted by: <?= esc($announcement['author_name'] ?? 'Unknown') ?>
                            </small>
                            
                            <?php if (session()->get('role') === 'admin'): ?>
                                <div class="mt-2">
                                    <a href="<?= base_url('announcements/edit/' . ($announcement['id'] ?? '')) ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger delete-announcement" data-id="<?= $announcement['id'] ?? '' ?>">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if (session()->get('role') === 'admin'): ?>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this announcement? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        const deleteButtons = document.querySelectorAll('.delete-announcement');
        const confirmDelete = document.getElementById('confirmDelete');
        
        if (deleteButtons.length > 0) {
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const announcementId = this.getAttribute('data-id');
                    if (announcementId) {
                        confirmDelete.href = '<?= base_url('announcements/delete/') ?>' + announcementId;
                        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                        modal.show();
                    } else {
                        console.error('Announcement ID is missing');
                    }
                });
            });
        }
    });
</script>
<?= $this->endSection() ?>
