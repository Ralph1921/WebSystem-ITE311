<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\NotificationModel;

class Notifications extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get notifications for the current user (AJAX endpoint)
     */
    public function get()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not logged in'
            ])->setStatusCode(401);
        }

        $user_id = session()->get('userID');

        // Get unread count and notifications
        $unread_count = $this->notificationModel->getUnreadCount($user_id);
        $notifications = $this->notificationModel->getNotificationsForUser($user_id, 10);

        return $this->response->setJSON([
            'success' => true,
            'unread_count' => $unread_count,
            'notifications' => $notifications,
            'debug' => [
                'user_id' => $user_id,
                'total_notifications' => count($notifications)
            ]
        ]);
    }

    /**
     * Mark a notification as read (AJAX endpoint)
     */
    public function mark_as_read($id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not logged in'
            ])->setStatusCode(401);
        }

        $user_id = session()->get('userID');

        // Verify the notification belongs to the user
        $notification = $this->notificationModel->find($id);

        if (!$notification) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Notification not found'
            ])->setStatusCode(404);
        }

        if ($notification['user_id'] != $user_id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ])->setStatusCode(403);
        }

        // Mark as read
        if ($this->notificationModel->markAsRead($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Notification marked as read'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to mark notification as read'
        ])->setStatusCode(500);
    }

    /**
     * Mark all notifications as read (AJAX endpoint)
     */
    public function mark_all_read()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not logged in'
            ])->setStatusCode(401);
        }

        $user_id = session()->get('userID');

        // Mark all notifications as read for user
        $db = \Config\Database::connect();
        $db->table('notifications')
            ->where('user_id', $user_id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
}
