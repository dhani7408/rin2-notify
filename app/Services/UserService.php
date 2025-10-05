<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * Get all users with notification counts
     */
    public function getUsersWithNotificationCounts(): array
    {
        try {
            $users = User::all();

            $usersWithCounts = $users->map(function($user) {
                // Calculate total notifications for this user
                $totalNotifications = DB::table('notifications')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('is_for_all', true);
                    })
                    ->count();

                // Calculate unread notifications for this user
                $unreadNotifications = DB::table('notifications')
                    ->where(function ($query) use ($user) {
                        $query->where('user_id', $user->id)
                              ->orWhere('is_for_all', true);
                    })
                    ->where('expires_at', '>', now())
                    ->whereNotExists(function ($query) use ($user) {
                        $query->select(DB::raw(1))
                              ->from('notification_reads')
                              ->whereRaw('notification_reads.notification_id = notifications.id')
                              ->where('notification_reads.user_id', $user->id);
                    })
                    ->count();

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'notification_switch' => $user->notification_switch,
                    'last_login_at' => $user->last_login_at,
                    'created_at' => $user->created_at,
                    'total_notifications' => $totalNotifications,
                    'unread_notifications' => $unreadNotifications,
                ];
            });

            return $usersWithCounts->toArray();
        } catch (\Exception $e) {
            Log::error('Error getting users with notification counts: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Update user's last login time
     */
    public function updateLastLogin(int $userId): bool
    {
        try {
            $user = User::findOrFail($userId);
            $user->update(['last_login_at' => now()]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error updating last login: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user by ID
     */
    public function getUserById(int $userId): ?User
    {
        try {
            return User::find($userId);
        } catch (\Exception $e) {
            Log::error('Error getting user by ID: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all users
     */
    public function getAllUsers(): \Illuminate\Database\Eloquent\Collection
    {
        try {
            return User::all();
        } catch (\Exception $e) {
            Log::error('Error getting all users: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Update user notification settings
     */
    public function updateNotificationSettings(int $userId, bool $enabled): bool
    {
        try {
            $user = User::findOrFail($userId);
            $user->update(['notification_switch' => $enabled]);
            return true;
        } catch (\Exception $e) {
            Log::error('Error updating notification settings: ' . $e->getMessage());
            return false;
        }
    }
}
