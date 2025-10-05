<x-adminlte-layout>
    <x-slot name="headerTitle">Notifications Management</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item active">Notifications</li>
    </x-slot>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total-notifications">-</h3>
                    <p>Total Notifications</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="active-notifications">-</h3>
                    <p>Active</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3 id="expired-notifications">-</h3>
                    <p>Expired</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3 id="global-notifications">-</h3>
                    <p>Global Notifications</p>
                </div>
                <div class="icon">
                    <i class="fas fa-globe"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filters</h3>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="">All Types</option>
                                <option value="marketing" {{ request('type') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="invoices" {{ request('type') == 'invoices' ? 'selected' : '' }}>Invoices</option>
                                <option value="system" {{ request('type') == 'system' ? 'selected' : '' }}>System</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select id="user_id" name="user_id" class="form-control">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="is_for_all">Destination</label>
                            <select id="is_for_all" name="is_for_all" class="form-control">
                                <option value="">All</option>
                                <option value="1" {{ request('is_for_all') == '1' ? 'selected' : '' }}>All Users</option>
                                <option value="0" {{ request('is_for_all') == '0' ? 'selected' : '' }}>Specific User</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Notifications Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Notifications</h3>
            <div class="card-tools">
                @if(request('user_id'))
                    <button id="mark-all-read-btn" class="btn btn-sm btn-primary mr-2">
                        <i class="fas fa-check-double mr-1"></i>Mark All Read for User
                    </button>
                @else
                    <button id="mark-all-read-global-btn" class="btn btn-sm btn-warning mr-2">
                        <i class="fas fa-check-double mr-1"></i>Mark All Read (Global)
                    </button>
                @endif
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-users"></i> View Users
                </a>
                <a href="{{ route('notifications.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Create Notification
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="notificationsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Message</th>
                            <th>Destination</th>
                            <th>Created</th>
                            <th>Expires</th>
                            <th>Status</th>
                            @if(request('user_id'))
                                <th>Read Status</th>
                            @endif
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
<script>
$(document).ready(function() {
    // Load notification stats
    loadNotificationStats();
    
    // Auto-refresh stats every 30 seconds
    setInterval(function() {
        loadNotificationStats();
    }, 30000);
    
    // Initialize DataTable
    const table = $('#notificationsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("api.notifications.datatable") }}',
            data: function(d) {
                d.user_id = '{{ request("user_id") }}';
                d.type = '{{ request("type") }}';
                d.is_for_all = '{{ request("is_for_all") }}';
            }
        },
        columns: [
            { data: 'type', name: 'type' },
            { data: 'text', name: 'text' },
            { data: 'destination', name: 'destination' },
            { data: 'created_at', name: 'created_at' },
            { data: 'expires_at', name: 'expires_at' },
            { 
                data: 'is_expired', 
                name: 'is_expired',
                render: function(data, type, row) {
                    return data ? 
                        '<span class="badge badge-danger">Expired</span>' : 
                        '<span class="badge badge-success">Active</span>';
                }
            },
            @if(request('user_id'))
            { data: 'read_status', name: 'read_status' },
            @endif
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[3, 'desc']], // Order by created_at desc
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: "Loading notifications...",
            emptyTable: "No notifications found",
            zeroRecords: "No notifications match your search"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Auto-submit form when filters change
    const filterSelects = $('#filter-form select');
    filterSelects.on('change', function() {
        $('#filter-form').submit();
    });
    
    // Handle individual mark as read
    $(document).on('click', '.mark-read-btn', function() {
        const notificationId = $(this).data('id');
        
        $.ajax({
            url: `/notifications/${notificationId}/mark-read`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                showToast('success', 'Notification marked as read');
                table.ajax.reload();
            },
            error: function() {
                showToast('error', 'Failed to mark notification as read');
            }
        });
    });
    
    // Handle mark all as read
    $('#mark-all-read-btn').on('click', function() {
        if (confirm('Are you sure you want to mark all notifications as read for this user?')) {
            $.ajax({
                url: '{{ route("notifications.mark-all-read") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showToast('success', `Marked ${response.count} notifications as read`);
                    $('#mark-all-read-btn').hide();
                    table.ajax.reload();
                },
                error: function() {
                    showToast('error', 'Failed to mark notifications as read');
                }
            });
        }
    });
    
    // Handle mark all as read global
    $('#mark-all-read-global-btn').on('click', function() {
        if (confirm('Are you sure you want to mark all notifications as read globally?')) {
            $.ajax({
                url: '{{ route("notifications.mark-all-read-global") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showToast('success', `Marked ${response.count} notifications as read globally`);
                    $('#mark-all-read-global-btn').hide();
                    table.ajax.reload();
                },
                error: function() {
                    showToast('error', 'Failed to mark notifications as read');
                }
            });
        }
    });
    
    // Handle delete
    $(document).on('click', '.delete-btn', function() {
        const notificationId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this notification?')) {
            $.ajax({
                url: `/notifications/${notificationId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    showToast('success', 'Notification deleted successfully');
                    table.ajax.reload();
                },
                error: function() {
                    showToast('error', 'Failed to delete notification');
                }
            });
        }
    });
    
    function loadNotificationStats() {
        $.ajax({
            url: '{{ route("api.notifications.stats") }}',
            method: 'GET',
            success: function(data) {
                console.log('Notification stats loaded:', data);
                updateNotificationStats(data);
            },
            error: function(xhr, status, error) {
                console.log('Error loading notification stats:', error);
                console.log('Response:', xhr.responseText);
                // Show fallback data
                updateNotificationStats({
                    total: 0,
                    active: 0,
                    expired: 0,
                    global: 0
                });
            }
        });
    }
    
    function updateNotificationStats(stats) {
        $('#total-notifications').text(stats.total);
        $('#active-notifications').text(stats.active);
        $('#expired-notifications').text(stats.expired);
        $('#global-notifications').text(stats.global);
    }
    
    function showToast(type, message) {
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
});
</script>
</x-slot>
</x-adminlte-layout>