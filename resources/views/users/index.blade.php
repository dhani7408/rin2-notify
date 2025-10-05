<x-adminlte-layout>
    <x-slot name="headerTitle">Users Management</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item active">Users</li>
    </x-slot>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $users->count() }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $users->where('notification_switch', true)->count() }}</h3>
                    <p>Active Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $users->where('notification_switch', false)->count() }}</h3>
                    <p>Inactive Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-times"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $users->sum('unread_count') }}</h3>
                    <p>Total Unread</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bell"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Users</h3>
            <div class="card-tools">
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-info mr-2">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="{{ route('notifications.create') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Create Notification
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Notification Status</th>
                            <th>Unread Count</th>
                            <th>Last Login</th>
                            <th>Created</th>
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
    // Initialize DataTable
    const table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("api.users.datatable") }}'
        },
        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'notification_status', name: 'notification_status' },
            { data: 'unread_count', name: 'unread_count', orderable: false },
            { data: 'last_login', name: 'last_login_at' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[5, 'desc']], // Order by created_at desc
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        language: {
            processing: "Loading users...",
            emptyTable: "No users found",
            zeroRecords: "No users match your search"
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Handle impersonate
    $(document).on('click', '.impersonate-btn', function() {
        const userId = $(this).data('id');
        
        if (confirm('Are you sure you want to impersonate this user?')) {
            $.ajax({
                url: `/users/${userId}/impersonate`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    showToast('success', 'Impersonation started');
                    window.location.href = '{{ route("user.dashboard") }}';
                },
                error: function() {
                    showToast('error', 'Failed to impersonate user');
                }
            });
        }
    });
    
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