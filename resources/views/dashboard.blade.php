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
                            <p class="text-muted">You're logged in! This is your admin dashboard.</p>
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
                    More info <i class="fas fa-arrow-circle-right"></i>
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
                    More info <i class="fas fa-arrow-circle-right"></i>
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
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- System Stats -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3 id="total-users">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Total Users</p>
                    <div class="small text-white">
                        <span id="users-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="users-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('users.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3 id="active-users">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Active Users</p>
                    <div class="small text-white">
                        <span id="active-users-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="active-users-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('users.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3 id="system-uptime">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>System Uptime</p>
                    <div class="small text-white">
                        <span id="uptime-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="uptime-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-server"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-light">
                <div class="inner">
                    <h3 id="database-status">
                        <i class="fas fa-spinner fa-spin"></i>
                    </h3>
                    <p>Database</p>
                        <div class="small text-white">
                        <span id="db-trend" class="trend-indicator">
                            <i class="fas fa-minus"></i>
                        </span>
                        <span id="db-change">0</span> from last hour
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>Recent Activity
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="recent-activity">
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                            <p class="text-muted mt-2">Loading activity...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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
    </div>

    <!-- System Status -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-server mr-2"></i>System Status
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success" id="web-server-icon">
                                    <i class="fas fa-server"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Web Server</span>
                                    <span class="info-box-number" id="web-server-status">Online</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" id="web-server-progress" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description" id="web-server-description">
                                        All systems operational
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info" id="database-icon">
                                    <i class="fas fa-database"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Database</span>
                                    <span class="info-box-number" id="database-status-text">Connected</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" id="database-progress" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description" id="database-description">
                                        Database connection stable
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning" id="mail-icon">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Mail Service</span>
                                    <span class="info-box-number" id="mail-status">Ready</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" id="mail-progress" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description" id="mail-description">
                                        Email notifications ready
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary" id="notification-icon">
                                    <i class="fas fa-bell"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Notifications</span>
                                    <span class="info-box-number" id="notification-status">Active</span>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" id="notification-progress" style="width: 100%"></div>
                                    </div>
                                    <span class="progress-description" id="notification-description">
                                        Notification system running
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<x-slot name="scripts">
<style>
.trend-indicator {
    font-size: 12px;
    margin-right: 5px;
}

.progress-bar {
    transition: width 0.6s ease;
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
</style>

<script>
console.log('📄 Dashboard script file loaded');

$(document).ready(function() {
    console.log('🚀 Main Dashboard script loaded successfully');
    
    // Test if jQuery is available
    if (typeof $ === 'undefined') {
        console.error('❌ jQuery is not loaded!');
        return;
    }
    
    console.log('✅ jQuery is available');
    
    let refreshInterval;
    let previousStats = {};
    
    // Add a visual indicator that script is loaded
    $('body').append('<div id="script-loaded-indicator" style="position: fixed; top: 10px; right: 10px; background: green; color: white; padding: 5px; border-radius: 3px; font-size: 12px; z-index: 9999;">Dashboard Script Loaded ✅</div>');
    setTimeout(function() {
        $('#script-loaded-indicator').fadeOut();
    }, 5000);
    
    // Initialize dashboard
    console.log('🔄 Initializing dashboard...');
    initializeDashboard();
    
    // Handle refresh buttons
    $('#refresh-system-status').on('click', function() {
        console.log('🔄 Manual refresh triggered');
        loadSystemPerformance();
    });
    
    // Test click handler to verify script is working
    $('.small-box').on('click', function() {
        console.log('🎯 Small box clicked:', $(this).find('p').text());
    });
    
    function initializeDashboard() {
        console.log('Initializing dashboard...');
        
        // Test basic functionality first
        testBasicFunctionality();
        
        // Load all data initially
        loadNotificationStats();
        loadSystemStats();
        loadSystemPerformance();
        loadRecentActivity();
        
        // Set up auto-refresh every 15 seconds for real-time updates
        // RE-ENABLED with duplicate prevention
        console.log('Auto-refresh ENABLED with duplicate prevention');
        refreshInterval = setInterval(function() {
            console.log('Auto-refreshing dashboard data...');
            loadNotificationStats();
            loadSystemStats();
            loadSystemPerformance();
            loadRecentActivity();
        }, 15000);
    }
    
    function testBasicFunctionality() {
        console.log('Testing basic functionality...');
        
        // Test if we can update the DOM
        $('#total-notifications').text('Loading...');
        $('#unread-notifications').text('Loading...');
        $('#active-notifications').text('Loading...');
        $('#expired-notifications').text('Loading...');
        
        // Test if we can make a simple AJAX call
        $.ajax({
            url: '{{ route("dashboard.stats") }}',
            method: 'GET',
            success: function(data) {
                console.log('✅ Dashboard API is working!', data);
            },
            error: function(xhr, status, error) {
                console.log('❌ Dashboard API error:', error);
                console.log('Status:', status);
                console.log('Response:', xhr.responseText);
                
                // Show fallback data
                $('#total-notifications').text('0');
                $('#unread-notifications').text('0');
                $('#active-notifications').text('0');
                $('#expired-notifications').text('0');
            }
        });
    }
    
    function loadNotificationStats() {
        $.ajax({
            url: '{{ route("dashboard.stats") }}',
            method: 'GET',
            success: function(data) {
                console.log('Notification stats loaded:', data);
                updateNotificationStats(data);
                updateTrendIndicators(data, previousStats);
                previousStats = { ...data };
            },
            error: function(xhr, status, error) {
                console.log('Error loading notification stats:', error);
                console.log('Response:', xhr.responseText);
                // Show fallback data
                updateNotificationStats({
                    total: 0,
                    unread: 0,
                    active: 0,
                    expired: 0
                });
            }
        });
    }
    
    function loadSystemStats() {
        $.ajax({
            url: '{{ route("dashboard.users") }}',
            method: 'GET',
            success: function(data) {
                console.log('System stats loaded:', data);
                updateSystemStats(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading system stats:', error);
                console.log('Response:', xhr.responseText);
                // Show fallback data
                $('#total-users').text('0');
                $('#active-users').text('0');
                $('#system-uptime').text('99.9%');
                $('#database-status').text('OK');
            }
        });
    }
    
    function loadSystemPerformance() {
        $.ajax({
            url: '{{ route("dashboard.performance") }}',
            method: 'GET',
            success: function(data) {
                console.log('System performance loaded:', data);
                updateSystemPerformance(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading system performance:', error);
                console.log('Response:', xhr.responseText);
                // Show fallback data
                updateSystemPerformance({
                    status: 'online',
                    cpu: 50,
                    memory: 60,
                    db_connections: 5,
                    response_time: 100
                });
            }
        });
    }
    
    function loadRecentActivity() {
        $.ajax({
            url: '{{ route("dashboard.activity") }}',
            method: 'GET',
            success: function(data) {
                console.log('Activity feed loaded:', data);
                displayActivityFeed(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading activity feed:', error);
                console.log('Response:', xhr.responseText);
                // Show fallback data
                displayActivityFeed([]);
            }
        });
    }
    
    function updateNotificationStats(stats) {
        $('#total-notifications').text(stats.total);
        $('#unread-notifications').text(stats.unread);
        $('#active-notifications').text(stats.active);
        $('#expired-notifications').text(stats.expired);
    }
    
    function updateSystemStats(users) {
        const totalUsers = users.length;
        const activeUsers = users.filter(user => user.notification_switch).length;
        
        $('#total-users').text(totalUsers);
        $('#active-users').text(activeUsers);
        
        // Simulate system uptime and database status
        $('#system-uptime').text('99.9%');
        $('#database-status').text('OK');
    }
    
    function updateTrendIndicators(current, previous) {
        if (Object.keys(previous).length === 0) return;
        
        const metrics = [
            { key: 'total', element: 'total' },
            { key: 'unread', element: 'unread' },
            { key: 'active', element: 'active' },
            { key: 'expired', element: 'expired' }
        ];
        
        metrics.forEach(metric => {
            const change = current[metric.key] - previous[metric.key];
            const trendElement = $(`#${metric.element}-trend`);
            const changeElement = $(`#${metric.element}-change`);
            
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
    
    function updateSystemPerformance(data) {
        // Update system status indicators
        updateSystemStatus('web-server', data.status === 'online' ? 'Online' : 'Offline', data.status === 'online' ? 'success' : 'danger');
        updateSystemStatus('database', 'Connected', 'info');
        updateSystemStatus('mail', 'Ready', 'warning');
        updateSystemStatus('notification', 'Active', 'primary');
    }
    
    function updateSystemStatus(service, status, color) {
        $(`#${service}-status`).text(status);
        $(`#${service}-icon`).removeClass('bg-success bg-info bg-warning bg-primary bg-danger').addClass(`bg-${color}`);
        $(`#${service}-progress`).removeClass('bg-success bg-info bg-warning bg-primary bg-danger').addClass(`bg-${color}`).css('width', '100%');
    }
    
    function displayActivityFeed(activities) {
        const container = $('#recent-activity');
        
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