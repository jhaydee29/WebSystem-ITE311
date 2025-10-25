<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WebSystem - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('/dashboard') ?>">ITE311-MARAÑAN Dashboard</a>
        <div class="navbar-nav ms-auto d-flex align-items-center">
            <div class="dropdown me-3">
                <a class="nav-link position-relative dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    <span id="notificationBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                        0
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 350px; max-height: 400px; overflow-y: auto;">
                    <li class="dropdown-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-bell me-2"></i>Notifications</span>
                        <a href="<?= site_url('/notifications') ?>" class="btn btn-sm btn-link text-decoration-none">View All</a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li id="notificationList">
                        <div class="text-center py-3">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="text-muted small mb-0 mt-2">Loading notifications...</p>
                        </div>
                    </li>
                </ul>
            </div>
            <span class="navbar-text me-3">Welcome, <?= session()->get('name') ?>!</span>
            <a href="<?= site_url('logout') ?>" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <?= $this->renderSection('content') ?>
</div>

<!-- jQuery (required for notification functionality) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Notification Styles -->
<style>
    .notification-dropdown {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .notification-item {
        padding: 12px 16px;
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.2s;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    
    .notification-item.unread {
        background-color: #e7f3ff;
        border-left: 3px solid #0d6efd;
    }
    
    .notification-message {
        font-size: 0.875rem;
        margin-bottom: 4px;
        color: #212529;
    }
    
    .notification-time {
        font-size: 0.75rem;
        color: #6c757d;
    }
    
    .mark-read-btn {
        font-size: 0.75rem;
        padding: 2px 8px;
    }
    
    .notification-empty {
        padding: 20px;
        text-align: center;
        color: #6c757d;
    }
</style>

<!-- Notification JavaScript -->
<script>
$(document).ready(function() {
    // Load notifications on page load
    loadNotifications();
    
    // Reload notifications every 60 seconds
    setInterval(loadNotifications, 60000);
    
    // Load notifications when dropdown is opened
    $('#notificationDropdown').on('click', function() {
        loadNotifications();
    });
});

function loadNotifications() {
    $.get('<?= site_url('/notifications/get') ?>', function(response) {
        if (response.success) {
            updateNotificationBadge(response.unreadCount);
            displayNotifications(response.notifications);
        }
    }).fail(function(xhr, status, error) {
        console.error('Failed to load notifications:', error);
        $('#notificationList').html(
            '<div class="notification-empty">' +
            '<i class="fas fa-exclamation-triangle fa-2x mb-2"></i>' +
            '<p class="mb-0">Failed to load notifications</p>' +
            '</div>'
        );
    });
}

function updateNotificationBadge(count) {
    const badge = $('#notificationBadge');
    if (count > 0) {
        badge.text(count).show();
    } else {
        badge.hide();
    }
}

function displayNotifications(notifications) {
    const notificationList = $('#notificationList');
    
    if (notifications.length === 0) {
        notificationList.html(
            '<div class="notification-empty">' +
            '<i class="fas fa-bell-slash fa-2x mb-2"></i>' +
            '<p class="mb-0">No notifications</p>' +
            '</div>'
        );
        return;
    }
    
    let html = '';
    notifications.forEach(function(notification) {
        const isUnread = notification.is_read == 0;
        const unreadClass = isUnread ? 'unread' : '';
        const unreadBadge = isUnread ? '<span class="badge bg-primary badge-sm me-2">New</span>' : '';
        
        // Format the date
        const date = new Date(notification.created_at);
        const timeAgo = getTimeAgo(date);
        
        html += '<div class="notification-item ' + unreadClass + '" data-notification-id="' + notification.id + '">';
        html += '  <div class="d-flex justify-content-between align-items-start">';
        html += '    <div class="flex-grow-1">';
        html += '      <div class="notification-message">';
        html += '        ' + unreadBadge + escapeHtml(notification.message);
        html += '      </div>';
        html += '      <div class="notification-time">';
        html += '        <i class="far fa-clock me-1"></i>' + timeAgo;
        html += '      </div>';
        html += '    </div>';
        
        if (isUnread) {
            html += '    <button class="btn btn-sm btn-outline-primary mark-read-btn ms-2" onclick="markAsRead(' + notification.id + ', event)">';
            html += '      <i class="fas fa-check"></i>';
            html += '    </button>';
        }
        
        html += '  </div>';
        html += '</div>';
    });
    
    notificationList.html(html);
}

function markAsRead(notificationId, event) {
    event.stopPropagation();
    
    $.ajax({
        url: '<?= site_url('/notifications/mark-as-read/') ?>' + notificationId,
        type: 'POST',
        data: {
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        success: function(response) {
            if (response.success) {
                // Remove the notification item or update its appearance
                const notificationItem = $('[data-notification-id="' + notificationId + '"]');
                notificationItem.removeClass('unread');
                notificationItem.find('.badge').remove();
                notificationItem.find('.mark-read-btn').remove();
                
                // Update the badge count
                updateNotificationBadge(response.unreadCount);
                
                // Reload notifications to get fresh data
                setTimeout(loadNotifications, 500);
            } else {
                alert('Failed to mark notification as read: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error marking notification as read:', error);
            alert('An error occurred while marking the notification as read');
        }
    });
}

function getTimeAgo(date) {
    const seconds = Math.floor((new Date() - date) / 1000);
    
    let interval = seconds / 31536000;
    if (interval > 1) return Math.floor(interval) + ' year' + (Math.floor(interval) > 1 ? 's' : '') + ' ago';
    
    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + ' month' + (Math.floor(interval) > 1 ? 's' : '') + ' ago';
    
    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + ' day' + (Math.floor(interval) > 1 ? 's' : '') + ' ago';
    
    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + ' hour' + (Math.floor(interval) > 1 ? 's' : '') + ' ago';
    
    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + ' minute' + (Math.floor(interval) > 1 ? 's' : '') + ' ago';
    
    return Math.floor(seconds) + ' second' + (Math.floor(seconds) > 1 ? 's' : '') + ' ago';
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}
</script>
</body>
</html>
