<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users with their unread notification counts
     */
    public function index(): View
    {
        $users = User::all();
        
        // Calculate unread count for each user using the same logic as dashboard
        foreach ($users as $user) {
            // Get all notifications for this user (both user-specific and for-all)
            $allNotifications = Notification::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('is_for_all', true);
            })
            ->where('expires_at', '>', now())
            ->get();

            // Get unread count using direct DB query
            $unreadCount = 0;
            foreach ($allNotifications as $notification) {
                $isRead = DB::table('notification_reads')
                    ->where('user_id', $user->id)
                    ->where('notification_id', $notification->id)
                    ->exists();
                
                if (!$isRead) {
                    $unreadCount++;
                }
            }
            
            $user->unread_count = $unreadCount;
            $user->total_notifications = $allNotifications->count();
        }

        return view('users.index', compact('users'));
    }

    /**
     * Impersonate a user
     */
    public function impersonate(User $user)
    {
        // Store the original user ID in session
        session(['impersonated_by' => Auth::id()]);
        
        // Update last login time
        $user->update(['last_login_at' => now()]);
        
        // Log in as the impersonated user
        Auth::login($user);
        
        return redirect()->route('user.dashboard');
    }

    /**
     * Stop impersonating and return to original user
     */
    public function stopImpersonating()
    {
        $originalUserId = session('impersonated_by');
        
        if ($originalUserId) {
            $originalUser = User::find($originalUserId);
            Auth::login($originalUser);
            session()->forget('impersonated_by');
        }
        
        return redirect()->route('users.index');
    }

    /**
     * Get DataTable data for users
     */
    public function getDataTableData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchValue = $request->get('search')['value'] ?? '';
        $orderColumn = $request->get('order')[0]['column'] ?? 0;
        $orderDirection = $request->get('order')[0]['dir'] ?? 'desc';

        // Column mapping (unread_count is calculated, not a DB column)
        $columns = ['id', 'name', 'email', 'notification_switch', 'created_at'];
        $orderColumnName = $columns[$orderColumn] ?? 'created_at';
        
        // If trying to order by unread_count (index 4), default to created_at
        if ($orderColumn == 4) {
            $orderColumnName = 'created_at';
        }

        // Build query
        $query = User::query();

        // Apply search filter
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                  ->orWhere('email', 'like', "%{$searchValue}%");
            });
        }

        // Get total count
        $totalRecords = User::count();
        $filteredRecords = $query->count();

        // Apply ordering and pagination
        $users = $query->orderBy($orderColumnName, $orderDirection)
                      ->skip($start)
                      ->take($length)
                      ->get();

        // Prepare data for DataTable
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'notification_status' => $user->notification_switch ? 
                    '<span class="badge badge-success">Enabled</span>' : 
                    '<span class="badge badge-danger">Disabled</span>',
                'unread_count' => $this->getUnreadCountDisplay($user),
                
                'created_at' => $user->created_at->format('M j, Y g:i A'),
                'actions' => $this->getUserActionButtons($user)
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
     * Get unread count display
     */
    private function getUnreadCountDisplay($user)
    {
        $unreadCount = $this->calculateUnreadCount($user->id);
        if ($unreadCount > 0) {
            return '<span class="badge badge-danger">' . $unreadCount . '</span>';
        } else {
            return '<span class="badge badge-success">0</span>';
        }
    }


    /**
     * Get user action buttons
     */
    private function getUserActionButtons($user)
    {
        $buttons = '<div class="btn-group">';
        
        // Impersonate button
        $buttons .= '<button class="btn btn-sm btn-warning impersonate-btn" data-id="' . $user->id . '" title="Impersonate User">';
        $buttons .= '<i class="fas fa-user-secret"></i></button>';
        
        $buttons .= '</div>';
        
        return $buttons;
    }

    /**
     * Calculate unread count for user
     */
    private function calculateUnreadCount($userId)
    {
        return \DB::table('notifications')
            ->leftJoin('notification_reads', function($join) use ($userId) {
                $join->on('notifications.id', '=', 'notification_reads.notification_id')
                     ->where('notification_reads.user_id', '=', $userId);
            })
            ->where(function($query) use ($userId) {
                $query->where('notifications.user_id', $userId)
                      ->orWhere('notifications.is_for_all', true);
            })
            ->where('notifications.expires_at', '>', now())
            ->whereNull('notification_reads.id')
            ->count();
    }
}
