<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    protected $notificationService;
    protected $userService;

    public function __construct(NotificationService $notificationService, UserService $userService)
    {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of notifications with filters
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['type', 'user_id', 'is_for_all']);
        $notifications = $this->notificationService->getNotificationsWithFilters($filters);
        $users = $this->userService->getAllUsers();

        return view('notifications.index', compact('notifications', 'users'));
    }

    /**
     * Show the form for creating a new notification
     */
    public function create(): View
    {
        $users = $this->userService->getAllUsers();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'type' => 'required|in:marketing,invoices,system',
                'text' => 'required|string|max:1000',
                'expires_at' => 'required|date|after:now',
                'destination' => 'required|in:specific,all',
                'user_id' => 'nullable|required_if:destination,specific|exists:users,id',
            ]);

            $data = [
                'type' => $request->type,
                'text' => $request->text,
                'expires_at' => $request->expires_at,
                'user_id' => $request->destination === 'specific' ? $request->user_id : null,
                'is_for_all' => $request->destination === 'all',
            ];

            $this->notificationService->createNotification($data);

            return redirect()->route('notifications.index')
                            ->with('success', 'Notification created successfully.');
        } catch (\Exception $e) {
            Log::error('Notification creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Failed to create notification. Please try again.');
        }
    }

    /**
     * Display the specified notification
     */
    public function show(Notification $notification): View
    {
        $notification->load(['user', 'readByUsers']);
        return view('notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified notification
     */
    public function edit(Notification $notification): View
    {
        $users = $this->userService->getAllUsers();
        return view('notifications.edit', compact('notification', 'users'));
    }

    /**
     * Update the specified notification
     */
    public function update(Request $request, Notification $notification): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:marketing,invoices,system',
            'text' => 'required|string|max:1000',
            'expires_at' => 'required|date',
            'destination' => 'required|in:specific,all',
            'user_id' => 'required_if:destination,specific|exists:users,id',
        ]);

        $data = [
            'type' => $request->type,
            'text' => $request->text,
            'expires_at' => $request->expires_at,
            'user_id' => $request->destination === 'specific' ? $request->user_id : null,
            'is_for_all' => $request->destination === 'all',
        ];

        $this->notificationService->updateNotification($notification->id, $data);

        return redirect()->route('notifications.index')
                        ->with('success', 'Notification updated successfully.');
    }

    /**
     * Remove the specified notification
     */
    public function destroy(Notification $notification): RedirectResponse
    {
        $this->notificationService->deleteNotification($notification->id);

        return redirect()->route('notifications.index')
                        ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Get notifications for the current user (for AJAX)
     */
    public function getUserNotifications(Request $request)
    {
        $user = auth()->user();
        $notifications = Notification::unreadForUser($user->id)
                                   ->orderBy('created_at', 'desc')
                                   ->limit(10)
                                   ->get();

        return response()->json($notifications);
    }

    /**
     * Mark all notifications as read for the current user
     */
    public function markAllAsRead()
    {
        $user = auth()->user();
        $result = $this->notificationService->markAllNotificationsAsReadForUser($user->id);
        
        return response()->json($result);
    }

    /**
     * Mark all notifications as read for ALL users (Global action)
     */
    public function markAllAsReadGlobal()
    {
        $result = $this->notificationService->markAllNotificationsAsReadGlobal();
        
        return response()->json($result);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead(Notification $notification)
    {
        $user = auth()->user();
        $success = $this->notificationService->markNotificationAsRead($notification->id, $user->id);
        
        if ($success) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
    }

    /**
     * Get DataTable data for notifications
     */
    public function getDataTableData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? '';
        $orderColumn = $request->get('order')[0]['column'] ?? 0;
        $orderDirection = $request->get('order')[0]['dir'] ?? 'desc';
        $userId = $request->get('user_id');

        // Column mapping
        $columns = ['id', 'type', 'text', 'user_id', 'is_for_all', 'expires_at', 'created_at'];
        $orderColumnName = $columns[$orderColumn] ?? 'created_at';

        // Build query
        $query = Notification::with(['user', 'readByUsers']);

        // Apply user filter if specified
        if ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                  ->orWhere('is_for_all', true);
            });
        }

        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('text', 'like', "%{$searchValue}%")
                  ->orWhere('type', 'like', "%{$searchValue}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchValue) {
                      $userQuery->where('name', 'like', "%{$searchValue}%")
                               ->orWhere('email', 'like', "%{$searchValue}%");
                  });
            });
        }

        // Get total count
        $totalRecords = Notification::count();
        $filteredRecords = $query->count();

        // Apply ordering and pagination
        $notifications = $query->orderBy($orderColumnName, $orderDirection)
                              ->skip($start)
                              ->take($length)
                              ->get();

        // Prepare data for DataTable
        $data = [];
        foreach ($notifications as $notification) {
            $isRead = $userId ? $notification->readByUsers()->where('user_id', $userId)->exists() : false;
            $readStatus = $userId ? ($isRead ? '<span class="badge badge-success">Read</span>' : '<span class="badge badge-warning">Unread</span>') : '';
            
            $data[] = [
                'id' => $notification->id,
                'type' => '<span class="badge badge-' . $this->getTypeBadgeClass($notification->type) . '">' . ucfirst($notification->type) . '</span>',
                'text' => Str::limit($notification->text, 50),
                'destination' => $notification->is_for_all ? 
                    '<span class="badge badge-info">All Users</span>' : 
                    '<span class="badge badge-primary">' . ($notification->user->name ?? 'Unknown') . '</span>',
                'read_status' => $readStatus,
                'expires_at' => $notification->expires_at->format('M j, Y g:i A'),
                'created_at' => $notification->created_at->format('M j, Y g:i A'),
                'actions' => $this->getActionButtons($notification, $userId),
                'is_expired' => $notification->expires_at <= now(),
                'is_for_all' => $notification->is_for_all
            ];
        }

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
    }

    /**
     * Get type badge class
     */
    private function getTypeBadgeClass($type)
    {
        $classes = [
            'marketing' => 'warning',
            'invoices' => 'info',
            'system' => 'secondary'
        ];
        return $classes[$type] ?? 'secondary';
    }

    /**
     * Get action buttons for DataTable
     */
    private function getActionButtons($notification, $userId = null)
    {
        $buttons = '<div class="btn-group">';
        
        // View button
        $buttons .= '<a href="' . route('notifications.show', $notification) . '" class="btn btn-sm btn-info" title="View">';
        $buttons .= '<i class="fas fa-eye"></i></a>';
        
        // Edit button
        $buttons .= '<a href="' . route('notifications.edit', $notification) . '" class="btn btn-sm btn-primary" title="Edit">';
        $buttons .= '<i class="fas fa-edit"></i></a>';
        
        // Mark as read button (only for specific user view)
        if ($userId && !$notification->readByUsers()->where('user_id', $userId)->exists()) {
            $buttons .= '<button class="btn btn-sm btn-success mark-read-btn" data-id="' . $notification->id . '" title="Mark as Read">';
            $buttons .= '<i class="fas fa-check"></i></button>';
        }
        
        // Delete button
        $buttons .= '<button class="btn btn-sm btn-danger delete-btn" data-id="' . $notification->id . '" title="Delete">';
        $buttons .= '<i class="fas fa-trash"></i></button>';
        
        $buttons .= '</div>';
        
        return $buttons;
    }

    /**
     * Get notification statistics for the notifications page
     */
    public function getNotificationStats(): \Illuminate\Http\JsonResponse
    {
        try {
            $totalNotifications = Notification::count();
            $activeNotifications = Notification::where('expires_at', '>', now())->count();
            $expiredNotifications = Notification::where('expires_at', '<=', now())->count();
            $globalNotifications = Notification::where('is_for_all', true)->count();

            return response()->json([
                'total' => $totalNotifications,
                'active' => $activeNotifications,
                'expired' => $expiredNotifications,
                'global' => $globalNotifications
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting notification stats: ' . $e->getMessage());
            return response()->json([
                'total' => 0,
                'active' => 0,
                'expired' => 0,
                'global' => 0
            ]);
        }
    }
}
