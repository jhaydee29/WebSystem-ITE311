<?php $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-bell me-2"></i>Notifications</h2>
                <?php if ($unreadCount > 0): ?>
                    <button id="markAllReadBtn" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                <?php endif; ?>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <?php if (empty($notifications)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">No notifications yet</h4>
                            <p class="text-muted">You'll see notifications here when you have updates</p>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($notifications as $notification): ?>
                                <div class="list-group-item notification-item <?= $notification['is_read'] == 0 ? 'unread' : '' ?>" 
                                     data-notification-id="<?= $notification['id'] ?>">
                                    <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center">
                                                <?php if ($notification['is_read'] == 0): ?>
                                                    <span class="badge bg-primary me-2">New</span>
                                                <?php endif; ?>
                                                <p class="mb-1 <?= $notification['is_read'] == 0 ? 'fw-bold' : '' ?>">
                                                    <?= esc($notification['message']) ?>
                                                </p>
                                            </div>
                                            <small class="text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?= date('F j, Y \a\t g:i A', strtotime($notification['created_at'])) ?>
                                            </small>
                                        </div>
                                        <?php if ($notification['is_read'] == 0): ?>
                                            <button class="btn btn-sm btn-outline-secondary mark-read-btn ms-3" 
                                                    data-notification-id="<?= $notification['id'] ?>"
                                                    title="Mark as read">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
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

<style>
    .notification-item.unread {
        background-color: #f8f9fa;
        border-left: 4px solid #0d6efd;
    }
    
    .notification-item {
        transition: all 0.3s ease;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    
    .mark-read-btn {
        opacity: 0.7;
        transition: opacity 0.2s;
    }
    
    .mark-read-btn:hover {
        opacity: 1;
    }
</style>

<script>
    // CSRF Token
    const csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';

    // Mark individual notification as read
    document.querySelectorAll('.mark-read-btn').forEach(button => {
        button.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            markAsRead(notificationId);
        });
    });

    // Mark all notifications as read
    const markAllBtn = document.getElementById('markAllReadBtn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function() {
            markAllAsRead();
        });
    }

    function markAsRead(notificationId) {
        fetch(`<?= site_url('/notifications/mark-as-read/') ?>${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                [csrfName]: csrfToken
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the notification item or update its appearance
                const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('unread');
                    notificationItem.querySelector('.badge')?.remove();
                    notificationItem.querySelector('.mark-read-btn')?.remove();
                    notificationItem.querySelector('p')?.classList.remove('fw-bold');
                }
                
                // Update the unread count badge in navbar
                updateNotificationBadge(data.unreadCount);
                
                // Reload page if no more unread notifications
                if (data.unreadCount === 0) {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                alert('Failed to mark notification as read: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while marking the notification as read');
        });
    }

    function markAllAsRead() {
        if (!confirm('Mark all notifications as read?')) {
            return;
        }

        fetch('<?= site_url('/notifications/mark-all-as-read') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                [csrfName]: csrfToken
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Failed to mark all notifications as read: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while marking all notifications as read');
        });
    }

    function updateNotificationBadge(count) {
        const badge = document.querySelector('.navbar .badge');
        if (badge) {
            if (count > 0) {
                badge.textContent = count;
            } else {
                badge.remove();
            }
        }
    }
</script>

<?= $this->endSection() ?>
