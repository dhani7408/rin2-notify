<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $notificationService;
    protected $userService;

    public function __construct(NotificationService $notificationService, UserService $userService)
    {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    /**
     * Show the dashboard
     */
    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * Get dashboard statistics
     */
    public function getStats(): JsonResponse
    {
        $user = auth()->user();
        $stats = $this->notificationService->getUserNotificationStats($user->id);
        
        return response()->json([
            'total' => $stats['total'],
            'unread' => $stats['unread'],
            'read' => $stats['read'],
            'active' => $stats['active'],
            'expired' => $stats['expired']
        ]);
    }

    /**
     * Get recent notifications for the user
     */
    public function getRecentNotifications(): JsonResponse
    {
        $user = auth()->user();
        $notifications = $this->notificationService->getNotificationsForUser($user->id, 50);
        
        $formattedNotifications = $notifications->getCollection()->map(function($notification) use ($user) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'text' => $notification->text,
                'created_at' => $notification->created_at,
                'expires_at' => $notification->expires_at,
                'is_for_all' => $notification->is_for_all,
                'read_at' => $notification->read_at,
                'is_expired' => $notification->expires_at <= now(),
            ];
        });

        return response()->json($formattedNotifications);
    }

    /**
     * Get user list with unread notification counts
     */
    public function getUsersWithCounts(): JsonResponse
    {
        $usersWithCounts = $this->userService->getUsersWithNotificationCounts();
        
        return response()->json($usersWithCounts);
    }

    /**
     * Get notification count for the current user
     */
    public function getNotificationCount(): JsonResponse
    {
        $user = auth()->user();
        $count = $this->notificationService->getNotificationCountForUser($user->id);
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get activity feed for the dashboard
     */
    public function getActivityFeed(): JsonResponse
    {
        $user = auth()->user();
        
        // Get recent activities (this would typically come from an activity log)
        $activities = [
            [
                'type' => 'notification_created',
                'title' => 'New notification created',
                'description' => 'A new system notification was created',
                'created_at' => now()->subMinutes(5)
            ],
            [
                'type' => 'user_login',
                'title' => 'User logged in',
                'description' => 'User successfully logged into the system',
                'created_at' => now()->subMinutes(10)
            ],
            [
                'type' => 'notification_read',
                'title' => 'Notification marked as read',
                'description' => 'A notification was marked as read',
                'created_at' => now()->subMinutes(15)
            ]
        ];
        
        return response()->json($activities);
    }

    /**
     * Get system performance metrics
     */
    public function getSystemPerformance(): JsonResponse
    {
        // Simulate system performance data
        $performance = [
            'cpu' => rand(20, 80),
            'memory' => rand(30, 90),
            'db_connections' => rand(5, 20),
            'response_time' => rand(50, 200),
            'status' => 'online' // or 'warning' or 'offline'
        ];
        
        return response()->json($performance);
    }

    /**
     * Get notification trends data for charts
     */
    public function getNotificationTrends(Request $request): JsonResponse
    {
        $period = $request->get('period', 7);
        $user = auth()->user();
        
        // Generate sample trend data
        $labels = [];
        $total = [];
        $unread = [];
        
        for ($i = $period - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M d');
            $total[] = rand(10, 50);
            $unread[] = rand(2, 15);
        }
        
        return response()->json([
            'labels' => $labels,
            'total' => $total,
            'unread' => $unread
        ]);
    }

    /**
     * Get notification types distribution
     */
    public function getNotificationTypes(): JsonResponse
    {
        $user = auth()->user();
        
        // Get notification types count
        $types = [
            'marketing' => rand(5, 20),
            'invoices' => rand(3, 15),
            'system' => rand(2, 10)
        ];
        
        return response()->json([
            'labels' => array_keys($types),
            'values' => array_values($types)
        ]);
    }
}