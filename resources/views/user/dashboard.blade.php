<x-adminlte-layout>
    <x-slot name="headerTitle">Dashboard</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item active">Dashboard</li>
    </x-slot>
    
    <!-- Welcome Message -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="card-title">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-white">This is your personal dashboard. Check the notification bell for any new messages.</p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-notifications">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Total Notifications</p>
                    <div class="small text-white">
                        <span id="total-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="total-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-bell"></i>
                </div>
                <a href="{{ route('notifications.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="unread-notifications">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Unread</p>
                    <div class="small text-white">
                        <span id="unread-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="unread-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <a href="{{ route('notifications.index') }}?filter=unread" class="small-box-footer">
                    View unread <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="active-notifications">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Active</p>
                    <div class="small text-white">
                        <span id="active-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="active-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('notifications.index') }}?filter=active" class="small-box-footer">
                    View active <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="expired-notifications">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Expired</p>
                        <div class="small text-white">
                        <span id="expired-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="expired-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <a href="{{ route('notifications.index') }}?filter=expired" class="small-box-footer">
                    View expired <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>Notification Trends (Last 7 Days)
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-calendar"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#" data-period="7">Last 7 days</a>
                                <a class="dropdown-item" href="#" data-period="30">Last 30 days</a>
                                <a class="dropdown-item" href="#" data-period="90">Last 90 days</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="notificationTrendsChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-2"></i>Notification Types
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="notificationTypesChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- System Performance Row -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tachometer-alt mr-2"></i>System Performance
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-server"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">CPU Usage</span>
                                    <span class="info-box-number" id="cpu-usage">0%</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" id="cpu-progress" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-memory"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Memory Usage</span>
                                    <span class="info-box-number" id="memory-usage">0%</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" id="memory-progress" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-database"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">DB Connections</span>
                                    <span class="info-box-number" id="db-connections">0</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" id="db-progress" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Response Time</span>
                                    <span class="info-box-number" id="response-time">0ms</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" id="response-progress" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>Recent Activity
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" id="refresh-activity">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="activity-feed" style="max-height: 300px; overflow-y: auto;">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="text-muted mt-2">Loading activity...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Notifications -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bell mr-2"></i>Recent Notifications
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="recent-notifications">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="text-muted mt-2">Loading notifications...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User List with Notification Counts -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>Users & Notification Counts
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="users-list">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="text-muted mt-2">Loading users...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bolt mr-2"></i>Quick Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('notifications.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Create Notification
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-info">
                            <i class="fas fa-list mr-2"></i>View All Notifications
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-success">
                            <i class="fas fa-users mr-2"></i>Manage Users
                        </a>
                        <a href="{{ route('user-settings.edit') }}" class="btn btn-warning">
                            <i class="fas fa-cog mr-2"></i>Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar mr-2"></i>System Status
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" id="refresh-system-status">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-success" id="system-status-icon">
                            <i class="fas fa-server"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">System Status</span>
                            <span class="info-box-number" id="system-status">Online</span>
                            <div class="progress">
                                <div class="progress-bar bg-success" id="system-progress" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" id="system-description">
                                All systems operational
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-info" id="database-status-icon">
                            <i class="fas fa-database"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Database</span>
                            <span class="info-box-number" id="database-status">Connected</span>
                            <div class="progress">
                                <div class="progress-bar bg-info" id="database-progress" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" id="database-description">
                                Database connection stable
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-warning" id="queue-status-icon">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Queue Status</span>
                            <span class="info-box-number" id="queue-status">Active</span>
                            <div class="progress">
                                <div class="progress-bar bg-warning" id="queue-progress" style="width: 100%"></div>
                            </div>
                            <span class="progress-description" id="queue-description">
                                <span id="queue-jobs">0</span> jobs pending
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.trend-indicator {
    font-size: 12px;
    margin-right: 5px;
}

.timeline {
    position: relative;
    padding: 0;
    list-style: none;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 40px;
    width: 2px;
    margin-left: -1.5px;
    background-color: #e9ecef;
}

.timeline > li {
    position: relative;
    margin-bottom: 50px;
    min-height: 50px;
}

.timeline > li:before,
.timeline > li:after {
    content: '';
    display: table;
}

.timeline > li:after {
    clear: both;
}

.timeline > li .timeline-item {
    position: relative;
    background: #fff;
    border-radius: 0.25rem;
    padding: 0 20px 20px 20px;
    margin-left: 60px;
    border-left: 3px solid #e9ecef;
}

.timeline > li .timeline-item:before {
    content: '';
    position: absolute;
    top: 16px;
    left: -11px;
    right: 100%;
    width: 0;
    height: 0;
    border: 7px solid transparent;
    border-left-color: #e9ecef;
}

.timeline > li .timeline-item:after {
    content: '';
    position: absolute;
    top: 16px;
    left: -8px;
    right: 100%;
    width: 0;
    height: 0;
    border: 7px solid transparent;
    border-left-color: #fff;
}

.timeline > li i {
    position: absolute;
    left: 18px;
    top: 0;
    width: 40px;
    height: 40px;
    font-size: 18px;
    line-height: 40px;
    text-align: center;
    background-color: #fff;
    color: #fff;
    border-radius: 50%;
    border: 3px solid #e9ecef;
}

.timeline .time-label > span {
    font-weight: 600;
    padding: 5px 10px;
    background-color: #fff;
    border-radius: 4px;
    color: #fff;
    font-size: 12px;
}

.timeline .time-label {
    position: relative;
    margin-bottom: 20px;
}

.timeline .time-label:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background-color: #e9ecef;
    z-index: 1;
}

.timeline .time-label > span {
    position: relative;
    z-index: 2;
    padding: 5px 10px;
    background-color: #fff;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}

.timeline .timeline-header {
    margin: 0;
    color: #495057;
    border-bottom: 1px solid #f4f4f4;
    padding-bottom: 10px;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: 600;
}

.timeline .timeline-body {
    padding: 10px 0;
}

.timeline .time {
    color: #999;
    font-size: 12px;
    padding: 10px 0;
}

.info-box .info-box-content {
    padding-left: 10px;
}

.info-box .info-box-text {
    text-transform: uppercase;
    font-weight: bold;
    font-size: 12px;
}

.info-box .info-box-number {
    display: block;
    font-weight: bold;
    font-size: 18px;
}

.progress {
    height: 7px;
    margin: 5px 0;
}

.progress-bar {
    transition: width 0.6s ease;
}
</style>

<script>
$(document).ready(function() {
    console.log('Dashboard script loaded successfully');
    
    // Test if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded!');
        return;
    }
    
    let refreshInterval;
    let charts = {};
    let previousStats = {};
    
    // Initialize dashboard
    initializeDashboard();
    
    // Add a visual indicator that script is loaded
    $('body').append('<div id="script-loaded-indicator" style="position: fixed; top: 10px; right: 10px; background: green; color: white; padding: 5px; border-radius: 3px; font-size: 12px; z-index: 9999;">Script Loaded</div>');
    setTimeout(function() {
        $('#script-loaded-indicator').fadeOut();
    }, 3000);
    
    // Handle notification bell click
    $('#notification-bell').on('click', function() {
        loadNotifications();
    });
    
    // Handle mark all as read button click
    $('#mark-all-read').on('click', function() {
        markAllAsRead();
    });
    
    function initializeDashboard() {
        // Load all data initially
        loadStats();
        loadNotifications();
        loadUsers();
        loadNotificationCount();
        loadActivityFeed();
        loadSystemPerformance();
        loadNotificationTrends();
        loadNotificationTypes();
        
        // Set up auto-refresh every 15 seconds for real-time updates
        refreshInterval = setInterval(function() {
            loadStats();
            loadNotifications();
            loadUsers();
            loadNotificationCount();
            loadActivityFeed();
            loadSystemPerformance();
        }, 15000);
        
        // Set up chart refresh every 2 minutes
        setInterval(function() {
            loadNotificationTrends();
            loadNotificationTypes();
        }, 120000);
        
        // Set up event handlers
        setupEventHandlers();
    }
    
    function setupEventHandlers() {
        // Chart period selector
        $('.dropdown-item[data-period]').on('click', function(e) {
            e.preventDefault();
            const period = $(this).data('period');
            loadNotificationTrends(period);
        });
        
        // Refresh buttons
        $('#refresh-activity').on('click', function() {
            loadActivityFeed();
        });
        
        $('#refresh-system-status').on('click', function() {
            loadSystemPerformance();
        });
    }
    
    function loadStats() {
        $.ajax({
            url: '{{ route("dashboard.stats") }}',
            method: 'GET',
            success: function(data) {
                console.log('Stats loaded:', data);
                updateStats(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading stats:', error);
            }
        });
    }
    
    function loadNotifications() {
        $.ajax({
            url: '{{ route("dashboard.notifications") }}',
            method: 'GET',
            success: function(data) {
                displayNotifications(data);
                displayDropdownNotifications(data);
            },
            error: function() {
                console.log('Error loading notifications');
            }
        });
    }
    
    function loadUsers() {
        $.ajax({
            url: '{{ route("dashboard.users") }}',
            method: 'GET',
            success: function(data) {
                console.log('Users loaded:', data);
                displayUsers(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading users:', error);
                console.log('Response:', xhr.responseText);
            }
        });
    }
    
    function loadNotificationCount() {
        $.ajax({
            url: '{{ route("dashboard.notification-count") }}',
            method: 'GET',
            success: function(data) {
                updateNotificationCount(data.count);
            },
            error: function() {
                console.log('Error loading notification count');
            }
        });
    }
    
    function updateStats(stats) {
        // Store previous stats for trend calculation
        if (Object.keys(previousStats).length > 0) {
            updateTrendIndicators(stats, previousStats);
        }
        
        $('#total-notifications').text(stats.total);
        $('#unread-notifications').text(stats.unread);
        $('#active-notifications').text(stats.active);
        $('#expired-notifications').text(stats.expired);
        
        // Store current stats for next comparison
        previousStats = { ...stats };
    }
    
    function updateTrendIndicators(current, previous) {
        const metrics = ['total', 'unread', 'active', 'expired'];
        
        metrics.forEach(metric => {
            const change = current[metric] - previous[metric];
            const trendElement = $(`#${metric}-trend`);
            const changeElement = $(`#${metric}-change`);
            
            if (change > 0) {
                trendElement.html('<i class="fas fa-arrow-up text-success"></i>');
                changeElement.text(`+${change}`).removeClass('text-danger text-success').addClass('text-success');
            } else if (change < 0) {
                trendElement.html('<i class="fas fa-arrow-down text-danger"></i>');
                changeElement.text(change).removeClass('text-danger text-success').addClass('text-danger');
            } else {
                trendElement.html('<i class="fas fa-minus text-muted"></i>');
                changeElement.text('0').removeClass('text-danger text-success').addClass('text-muted');
            }
        });
    }
    
    function updateNotificationCount(count) {
        const countElement = $('#notification-count');
        if (count > 0) {
            countElement.text(count).removeClass('hidden');
        } else {
            countElement.addClass('hidden');
        }
    }
    
    function displayNotifications(notifications) {
        const container = $('#recent-notifications');
        
        if (notifications.length === 0) {
            container.html(`
                <div class="text-center py-4">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No notifications</h5>
                    <p class="text-muted">You don't have any notifications at the moment.</p>
                </div>
            `);
            return;
        }
        
        let html = '<div class="list-group">';
        notifications.slice(0, 5).forEach(function(notification) {
            const isExpired = notification.is_expired;
            const isRead = notification.read_at !== null;
            const statusClass = isExpired ? 'list-group-item-danger' : 
                              isRead ? 'list-group-item-light' : 'list-group-item-primary';
            
            html += `
                <div class="list-group-item ${statusClass}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">
                                <span class="badge badge-${getTypeBadgeClass(notification.type)} mr-2">
                                    ${notification.type.charAt(0).toUpperCase() + notification.type.slice(1)}
                                </span>
                                ${notification.text}
                            </h6>
                            <small class="text-muted">
                                ${new Date(notification.created_at).toLocaleString()}
                                ${isExpired ? ' - Expired' : ''}
                                ${isRead ? ' - Read' : ' - Unread'}
                            </small>
                        </div>
                        ${!isRead ? `
                            <button class="btn btn-sm btn-outline-primary mark-read" data-id="${notification.id}">
                                <i class="fas fa-check"></i>
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        html += '</div>';
        
        if (notifications.length > 5) {
            html += `
                <div class="text-center mt-3">
                    <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-primary">
                        View All Notifications
                    </a>
                </div>
            `;
        }
        
        container.html(html);
        
        // Handle mark as read
        $('.mark-read').on('click', function() {
            const notificationId = $(this).data('id');
            markAsRead(notificationId);
        });
    }
    
    function displayUsers(users) {
        const container = $('#users-list');
        
        console.log('Displaying users:', users);
        
        if (users.length === 0) {
            container.html(`
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No users found</h5>
                </div>
            `);
            return;
        }
        
        let html = '<div class="table-responsive"><table class="table table-striped">';
        html += `
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Total Notifications</th>
                    <th>Unread Count</th>
                    <th>Member Since</th>
                </tr>
            </thead>
            <tbody>
        `;
        
        users.forEach(function(user) {
            const unreadBadge = user.unread_notifications > 0 ? 
                `<span class="badge badge-danger">${user.unread_notifications}</span>` : 
                '<span class="badge badge-success">0</span>';
            
            html += `
                <tr>
                    <td>
                        <strong>${user.name}</strong>
                    </td>
                    <td>${user.email}</td>
                    <td>
                        <span class="badge badge-info">${user.total_notifications}</span>
                    </td>
                    <td>${unreadBadge}</td>
                    <td>${new Date(user.created_at).toLocaleDateString()}</td>
                </tr>
            `;
        });
        
        html += '</tbody></table></div>';
        container.html(html);
    }
    
    function markAsRead(notificationId) {
        $.ajax({
            url: `/notifications/${notificationId}/mark-read`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                // Refresh all data
                loadStats();
                loadNotifications();
                loadUsers();
                loadNotificationCount();
            },
            error: function() {
                console.log('Error marking notification as read');
            }
        });
    }
    
    function displayDropdownNotifications(notifications) {
        const container = $('#notification-list');
        const markAllButton = $('#mark-all-read');
        
        // Count unread notifications
        const unreadCount = notifications.filter(n => !n.read_at).length;
        
        if (notifications.length === 0) {
            container.html(`
                <div class="text-center py-3">
                    <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No notifications</p>
                </div>
            `);
            markAllButton.hide();
            return;
        }
        
        // Show/hide mark all button based on unread count
        if (unreadCount > 0) {
            markAllButton.show();
        } else {
            markAllButton.hide();
        }
        
        let html = '';
        notifications.slice(0, 8).forEach(function(notification) {
            const isExpired = notification.is_expired;
            const isRead = notification.read_at !== null;
            const statusClass = isExpired ? 'text-danger' : 
                              isRead ? 'text-muted' : 'text-primary';
            
            html += `
                <div class="dropdown-item-text">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge badge-${getTypeBadgeClass(notification.type)} mr-2">
                                    ${notification.type.charAt(0).toUpperCase() + notification.type.slice(1)}
                                </span>
                                ${!isRead ? '<i class="fas fa-circle text-primary" style="font-size: 8px;"></i>' : ''}
                            </div>
                            <div class="${statusClass}" style="font-size: 14px;">
                                ${notification.text}
                            </div>
                            <small class="text-muted">
                                ${new Date(notification.created_at).toLocaleString()}
                                ${isExpired ? ' - Expired' : ''}
                            </small>
                        </div>
                        ${!isRead ? `
                            <button class="btn btn-sm btn-outline-primary mark-read-dropdown" data-id="${notification.id}" title="Mark as read">
                                <i class="fas fa-check"></i>
                            </button>
                        ` : ''}
                    </div>
                </div>
            `;
        });
        
        if (notifications.length > 8) {
            html += `
                <div class="dropdown-divider"></div>
                <div class="dropdown-item text-center">
                    <a href="{{ route('notifications.index') }}" class="text-sm text-primary">
                        View All Notifications (${notifications.length})
                    </a>
                </div>
            `;
        }
        
        container.html(html);
        
        // Handle mark as read for dropdown
        $('.mark-read-dropdown').on('click', function() {
            const notificationId = $(this).data('id');
            markAsRead(notificationId);
        });
    }
    
    function markAllAsRead() {
        $.ajax({
            url: '{{ route("notifications.mark-all-read") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('Marked all as read:', response.message);
                // Refresh all data
                loadStats();
                loadNotifications();
                loadUsers();
                loadNotificationCount();
                
                // Show success message
                showToast('success', `Marked ${response.count} notifications as read`);
            },
            error: function() {
                console.log('Error marking all notifications as read');
                showToast('error', 'Failed to mark all notifications as read');
            }
        });
    }
    
    function showToast(type, message) {
        // Simple toast notification
        const toastClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const toast = $(`
            <div class="alert ${toastClass} alert-dismissible fade show position-fixed" 
                 style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        `);
        
        $('body').append(toast);
        
        setTimeout(function() {
            toast.alert('close');
        }, 3000);
    }
    
    function loadActivityFeed() {
        $.ajax({
            url: '{{ route("dashboard.activity") }}',
            method: 'GET',
            success: function(data) {
                displayActivityFeed(data);
            },
            error: function() {
                console.log('Error loading activity feed');
            }
        });
    }
    
    function loadSystemPerformance() {
        $.ajax({
            url: '{{ route("dashboard.performance") }}',
            method: 'GET',
            success: function(data) {
                updateSystemPerformance(data);
            },
            error: function() {
                console.log('Error loading system performance');
            }
        });
    }
    
    function loadNotificationTrends(period = 7) {
        $.ajax({
            url: '{{ route("dashboard.trends") }}',
            method: 'GET',
            data: { period: period },
            success: function(data) {
                updateTrendsChart(data);
            },
            error: function() {
                console.log('Error loading notification trends');
            }
        });
    }
    
    function loadNotificationTypes() {
        $.ajax({
            url: '{{ route("dashboard.types") }}',
            method: 'GET',
            success: function(data) {
                updateTypesChart(data);
            },
            error: function() {
                console.log('Error loading notification types');
            }
        });
    }
    
    function displayActivityFeed(activities) {
        const container = $('#activity-feed');
        
        if (activities.length === 0) {
            container.html(`
                <div class="text-center py-4">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No recent activity</h5>
                </div>
            `);
            return;
        }
        
        let html = '<div class="timeline">';
        activities.forEach(function(activity) {
            html += `
                <div class="time-label">
                    <span class="bg-${getActivityColor(activity.type)}">
                        ${new Date(activity.created_at).toLocaleDateString()}
                    </span>
                </div>
                <div>
                    <i class="fas fa-${getActivityIcon(activity.type)} bg-${getActivityColor(activity.type)}"></i>
                    <div class="timeline-item">
                        <span class="time">
                            <i class="fas fa-clock"></i> ${new Date(activity.created_at).toLocaleTimeString()}
                        </span>
                        <h3 class="timeline-header">
                            ${activity.title}
                        </h3>
                        <div class="timeline-body">
                            ${activity.description}
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        
        container.html(html);
    }
    
    function updateSystemPerformance(data) {
        // Update CPU usage
        $('#cpu-usage').text(data.cpu + '%');
        $('#cpu-progress').css('width', data.cpu + '%');
        
        // Update Memory usage
        $('#memory-usage').text(data.memory + '%');
        $('#memory-progress').css('width', data.memory + '%');
        
        // Update DB connections
        $('#db-connections').text(data.db_connections);
        $('#db-progress').css('width', Math.min(data.db_connections * 10, 100) + '%');
        
        // Update Response time
        $('#response-time').text(data.response_time + 'ms');
        $('#response-progress').css('width', Math.min(data.response_time / 10, 100) + '%');
        
        // Update system status
        updateSystemStatus(data);
    }
    
    function updateSystemStatus(data) {
        const status = data.status;
        const statusElement = $('#system-status');
        const statusIcon = $('#system-status-icon');
        const statusProgress = $('#system-progress');
        const statusDescription = $('#system-description');
        
        if (status === 'online') {
            statusElement.text('Online');
            statusIcon.removeClass('bg-danger bg-warning').addClass('bg-success');
            statusProgress.removeClass('bg-danger bg-warning').addClass('bg-success').css('width', '100%');
            statusDescription.text('All systems operational');
        } else if (status === 'warning') {
            statusElement.text('Warning');
            statusIcon.removeClass('bg-success bg-danger').addClass('bg-warning');
            statusProgress.removeClass('bg-success bg-danger').addClass('bg-warning').css('width', '75%');
            statusDescription.text('Some systems experiencing issues');
        } else {
            statusElement.text('Offline');
            statusIcon.removeClass('bg-success bg-warning').addClass('bg-danger');
            statusProgress.removeClass('bg-success bg-warning').addClass('bg-danger').css('width', '25%');
            statusDescription.text('System experiencing issues');
        }
    }
    
    function updateTrendsChart(data) {
        const ctx = document.getElementById('notificationTrendsChart').getContext('2d');
        
        if (charts.trends) {
            charts.trends.destroy();
        }
        
        charts.trends = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Total Notifications',
                    data: data.total,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }, {
                    label: 'Unread Notifications',
                    data: data.unread,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    function updateTypesChart(data) {
        const ctx = document.getElementById('notificationTypesChart').getContext('2d');
        
        if (charts.types) {
            charts.types.destroy();
        }
        
        charts.types = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
    
    function getActivityColor(type) {
        const colors = {
            'notification_created': 'success',
            'notification_read': 'info',
            'user_login': 'primary',
            'system_error': 'danger',
            'notification_expired': 'warning'
        };
        return colors[type] || 'secondary';
    }
    
    function getActivityIcon(type) {
        const icons = {
            'notification_created': 'bell',
            'notification_read': 'check',
            'user_login': 'sign-in-alt',
            'system_error': 'exclamation-triangle',
            'notification_expired': 'clock'
        };
        return icons[type] || 'circle';
    }
    
    function getTypeBadgeClass(type) {
        const classes = {
            'marketing': 'warning',
            'invoices': 'info',
            'system': 'secondary'
        };
        return classes[type] || 'secondary';
    }
    
    // Clean up interval when page unloads
    $(window).on('beforeunload', function() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
});
</script>
    </x-slot>
</x-adminlte-layout>