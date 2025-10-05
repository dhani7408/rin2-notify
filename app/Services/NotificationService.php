<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Get notifications for a specific user
     */
    public function getNotificationsForUser(int $userId, int $perPage = 20)
    {
        $notifications = Notification::forUser($userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
            
        // Add read status to each notification
        $notifications->getCollection()->transform(function($notification) use ($userId) {
            $notification->is_read = $notification->readByUsers()->where('user_id', $userId)->exists();
            $notification->read_at = $notification->readByUsers()->where('user_id', $userId)->first()?->pivot?->read_at;
            return $notification;
        });
        
        return $notifications;
    }

    /**
     * Get notifications with filters for admin view
     */
    public function getNotificationsWithFilters(array $filters = [], int $perPage = 15)
    {
        $query = Notification::with('user');

        // Apply filters
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['user_id'])) {
            // Show notifications relevant to this user (both user-specific and global)
            $query->where(function ($q) use ($filters) {
                $q->where('user_id', $filters['user_id'])
                  ->orWhere('is_for_all', true);
            });
        }

        if (isset($filters['is_for_all'])) {
            $isForAll = $filters['is_for_all'];
            if ($isForAll === '1') {
                $query->where('is_for_all', true);
            } elseif ($isForAll === '0') {
                $query->where('is_for_all', false);
            }
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Mark a notification as read for a specific user
     */
    public function markNotificationAsRead(int $notificationId, int $userId): bool
    {
        try {
            $notification = Notification::findOrFail($notificationId);
            
            // Check if user can read this notification
            if (!$notification->is_for_all && $notification->user_id !== $userId) {
                return false;
            }

            // Mark as read if not already read
            if (!$notification->readByUsers()->where('user_id', $userId)->exists()) {
                $notification->readByUsers()->attach($userId, ['read_at' => now()]);
                return true;
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Error marking notification as read: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Mark all notifications as read for a specific user
     */
    public function markAllNotificationsAsReadForUser(int $userId): array
    {
        try {
            // Get all unread notifications for this user
            $unreadNotifications = Notification::where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('is_for_all', true);
            })
            ->where('expires_at', '>', now())
            ->whereDoesntHave('readByUsers', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->get();

            $markedCount = 0;
            // Mark each notification as read
            foreach ($unreadNotifications as $notification) {
                if (!$notification->readByUsers()->where('user_id', $userId)->exists()) {
                    $notification->readByUsers()->attach($userId, ['read_at' => now()]);
                    $markedCount++;
                }
            }

            return [
                'success' => true,
                'message' => 'All notifications marked as read',
                'count' => $markedCount
            ];
        } catch (\Exception $e) {
            Log::error('Error marking all notifications as read for user: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to mark all notifications as read',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Mark all notifications as read for ALL users (Global action)
     */
    public function markAllNotificationsAsReadGlobal(): array
    {
        try {
            // Get all users
            $users = User::all();
            $totalMarked = 0;
            
            foreach ($users as $user) {
                // Get all unread notifications for this user
                $unreadNotifications = Notification::where(function($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->orWhere('is_for_all', true);
                })
                ->where('expires_at', '>', now())
                ->whereDoesntHave('readByUsers', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->get();

                // Mark each notification as read for this user
                foreach ($unreadNotifications as $notification) {
                    if (!$notification->readByUsers()->where('user_id', $user->id)->exists()) {
                        $notification->readByUsers()->attach($user->id, ['read_at' => now()]);
                        $totalMarked++;
                    }
                }
            }

            return [
                'success' => true,
                'message' => 'All notifications marked as read for all users',
                'count' => $totalMarked
            ];
        } catch (\Exception $e) {
            Log::error('Error in markAllNotificationsAsReadGlobal: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to mark all notifications as read',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get notification statistics for dashboard
     */
    public function getNotificationStats(): array
    {
        try {
            $totalNotifications = Notification::count();
            $activeNotifications = Notification::where('expires_at', '>', now())->count();
            $expiredNotifications = Notification::where('expires_at', '<=', now())->count();
            $globalNotifications = Notification::where('is_for_all', true)->count();

            return [
                'total' => $totalNotifications,
                'active' => $activeNotifications,
                'expired' => $expiredNotifications,
                'global' => $globalNotifications
            ];
        } catch (\Exception $e) {
            Log::error('Error getting notification stats: ' . $e->getMessage());
            return [
                'total' => 0,
                'active' => 0,
                'expired' => 0,
                'global' => 0
            ];
        }
    }

    /**
     * Get user notification statistics
     */
    public function getUserNotificationStats(int $userId): array
    {
        try {
            $notifications = Notification::forUser($userId)->get();
            
            $unreadCount = $notifications->filter(function($notification) use ($userId) {
                return !$notification->readByUsers()->where('user_id', $userId)->exists();
            })->count();
            
            $readCount = $notifications->filter(function($notification) use ($userId) {
                return $notification->readByUsers()->where('user_id', $userId)->exists();
            })->count();
            
            $activeCount = $notifications->filter(function($notification) {
                return $notification->expires_at > now();
            })->count();
            
            $expiredCount = $notifications->filter(function($notification) {
                return $notification->expires_at <= now();
            })->count();
            
            $userSpecificCount = $notifications->where('user_id', $userId)->count();

            return [
                'unread' => $unreadCount,
                'read' => $readCount,
                'active' => $activeCount,
                'expired' => $expiredCount,
                'user_specific' => $userSpecificCount,
                'total' => $notifications->count()
            ];
        } catch (\Exception $e) {
            Log::error('Error getting user notification stats: ' . $e->getMessage());
            return [
                'unread' => 0,
                'read' => 0,
                'active' => 0,
                'expired' => 0,
                'user_specific' => 0,
                'total' => 0
            ];
        }
    }

    /**
     * Get recent notifications for dashboard
     */
    public function getRecentNotifications(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return Notification::with('user')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting recent notifications: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get notification count for a user
     */
    public function getNotificationCountForUser(int $userId): int
    {
        try {
            return Notification::forUser($userId)
                ->where('expires_at', '>', now())
                ->whereDoesntHave('readByUsers', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->count();
        } catch (\Exception $e) {
            Log::error('Error getting notification count for user: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Create a new notification
     */
    public function createNotification(array $data): Notification
    {
        try {
            return Notification::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating notification: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update a notification
     */
    public function updateNotification(int $notificationId, array $data): bool
    {
        try {
            $notification = Notification::findOrFail($notificationId);
            return $notification->update($data);
        } catch (\Exception $e) {
            Log::error('Error updating notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a notification
     */
    public function deleteNotification(int $notificationId): bool
    {
        try {
            $notification = Notification::findOrFail($notificationId);
            return $notification->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting notification: ' . $e->getMessage());
            return false;
        }
    }
}
