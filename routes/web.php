<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User management routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');
    Route::post('/users/stop-impersonating', [UserController::class, 'stopImpersonating'])->name('users.stop-impersonating');
    
    // User dashboard (for impersonated users)
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    
    // Dashboard API routes
    Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
    Route::get('/dashboard/notifications', [DashboardController::class, 'getRecentNotifications'])->name('dashboard.notifications');
    Route::get('/dashboard/users', [DashboardController::class, 'getUsersWithCounts'])->name('dashboard.users');
    Route::get('/dashboard/notification-count', [DashboardController::class, 'getNotificationCount'])->name('dashboard.notification-count');
    Route::get('/dashboard/activity', [DashboardController::class, 'getActivityFeed'])->name('dashboard.activity');
    Route::get('/dashboard/performance', [DashboardController::class, 'getSystemPerformance'])->name('dashboard.performance');
    Route::get('/dashboard/trends', [DashboardController::class, 'getNotificationTrends'])->name('dashboard.trends');
    Route::get('/dashboard/types', [DashboardController::class, 'getNotificationTypes'])->name('dashboard.types');
    
    // DataTable API routes
    Route::get('/api/notifications/datatable', [NotificationController::class, 'getDataTableData'])->name('api.notifications.datatable');
    Route::get('/api/users/datatable', [UserController::class, 'getDataTableData'])->name('api.users.datatable');
    
    // Notifications stats API
    Route::get('/api/notifications/stats', [NotificationController::class, 'getNotificationStats'])->name('api.notifications.stats');
    
    // Notification routes
    Route::resource('notifications', NotificationController::class);
    Route::get('/notifications/user/list', [NotificationController::class, 'getUserNotifications'])->name('notifications.user.list');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('/notifications/mark-all-read-global', [NotificationController::class, 'markAllAsReadGlobal'])->name('notifications.mark-all-read-global');
    
    // User settings routes
    Route::get('/user-settings', [UserSettingsController::class, 'edit'])->name('user-settings.edit');
    Route::patch('/user-settings', [UserSettingsController::class, 'update'])->name('user-settings.update');
});

require __DIR__.'/auth.php';
