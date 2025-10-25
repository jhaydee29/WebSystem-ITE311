<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;

class Notifications extends BaseController
{
    use ResponseTrait;

    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for the current user
     * Returns JSON response with unread count and list of notifications
     *
     * @return mixed
     */
    public function get()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->respond([
                'success' => false,
                'message' => 'Please login to view notifications'
            ], 401);
        }

        $userId = session()->get('id');

        // Get unread count
        $unreadCount = $this->notificationModel->getUnreadCount($userId);

        // Get notifications (latest 5 by default, can be customized)
        $limit = $this->request->getGet('limit') ?? 5;
        $notifications = $this->notificationModel->getNotificationsForUser($userId, $limit);

        return $this->respond([
            'success' => true,
            'unreadCount' => $unreadCount,
            'notifications' => $notifications
        ], 200);
    }

    /**
     * Mark a specific notification as read
     *
     * @param int $id Notification ID
     * @return mixed
     */
    public function mark_as_read($id = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->respond([
                'success' => false,
                'message' => 'Please login to perform this action'
            ], 401);
        }

        // Validate notification ID
        if (!$id) {
            return $this->respond([
                'success' => false,
                'message' => 'Notification ID is required'
            ], 400);
        }

        $userId = session()->get('id');

        // Get the notification to verify ownership
        $notification = $this->notificationModel->find($id);

        if (!$notification) {
            return $this->respond([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        // Verify that the notification belongs to the current user
        if ($notification['user_id'] != $userId) {
            return $this->respond([
                'success' => false,
                'message' => 'Unauthorized access to this notification'
            ], 403);
        }

        // Mark as read
        if ($this->notificationModel->markAsRead($id)) {
            // Get updated unread count
            $unreadCount = $this->notificationModel->getUnreadCount($userId);

            return $this->respond([
                'success' => true,
                'message' => 'Notification marked as read',
                'unreadCount' => $unreadCount
            ], 200);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to mark notification as read'
            ], 500);
        }
    }

    /**
     * Display notifications page view
     *
     * @return mixed
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');

        // Get all notifications for the user
        $this->data['title'] = 'Notifications';
        $this->data['notifications'] = $this->notificationModel->getNotificationsForUser($userId, 50);
        $this->data['unreadCount'] = $this->notificationModel->getUnreadCount($userId);

        return view('notifications/index', $this->data);
    }

    /**
     * Mark all notifications as read for the current user
     *
     * @return mixed
     */
    public function mark_all_as_read()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->respond([
                'success' => false,
                'message' => 'Please login to perform this action'
            ], 401);
        }

        $userId = session()->get('id');

        // Mark all as read
        if ($this->notificationModel->markAllAsRead($userId)) {
            return $this->respond([
                'success' => true,
                'message' => 'All notifications marked as read',
                'unreadCount' => 0
            ], 200);
        } else {
            return $this->respond([
                'success' => false,
                'message' => 'Failed to mark all notifications as read'
            ], 500);
        }
    }
}
