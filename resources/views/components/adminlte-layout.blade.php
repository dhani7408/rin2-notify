<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $headerTitle ?? 'Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">
    
    @stack('styles')
    
    <style>
    /* Custom styles for notification dropdown */
    #notification-list-nav {
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 #f1f1f1;
    }
    
    #notification-list-nav::-webkit-scrollbar {
        width: 6px;
    }
    
    #notification-list-nav::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    #notification-list-nav::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    #notification-list-nav::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    .notification-item {
        transition: background-color 0.2s ease;
    }
    
    .notification-item:hover {
        background-color: #f8f9fa !important;
    }
    
    .btn-xs {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Impersonation Notice -->
                @if(session()->has('impersonated_by'))
                    <li class="nav-item">
                        <div class="nav-link text-warning">
                            <i class="fas fa-user-secret"></i>
                            Impersonating: {{ Auth::user()->name }}
                            <form method="POST" action="{{ route('users.stop-impersonating') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning ml-2">Stop</button>
                            </form>
                        </div>
                    </li>
                @endif

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" id="notification-bell-nav">
                        <i class="far fa-bell"></i>
                        <span id="notification-count-nav" class="badge badge-warning navbar-badge hidden">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="width: 350px; max-height: 500px;">
                        <div class="dropdown-header">
                            <h6 class="mb-0">Notifications</h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div id="notification-list-nav" style="max-height: 350px; overflow-y: auto;">
                            <!-- Notifications will be loaded here via AJAX -->
                        </div>
                    </div>
                </li>

                <!-- User Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link">
                <img src="{{ asset('vendor/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RIN2 Notify</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- Users -->
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>

                        <!-- Notifications -->
                        <li class="nav-item {{ request()->routeIs('notifications.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bell"></i>
                                <p>
                                    Notifications
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Notifications</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('notifications.create') }}" class="nav-link {{ request()->routeIs('notifications.create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Notification</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Settings -->
                        <li class="nav-item">
                            <a href="{{ route('user-settings.edit') }}" class="nav-link {{ request()->routeIs('user-settings.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Settings</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $headerTitle ?? 'Dashboard' }}</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('user.dashboard') }}">Home</a></li>
                                @if(isset($breadcrumbs))
                                    @foreach($breadcrumbs as $breadcrumb)
                                        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                            @if($loop->last)
                                                {{ $breadcrumb['title'] }}
                                            @else
                                                <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="#">RIN2 Notify</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    @stack('scripts')
    
    {{ $scripts ?? '' }}
    
    <script>
    $(document).ready(function() {
        // Initialize navbar notifications
        initializeNavbarNotifications();
        
        function initializeNavbarNotifications() {
            loadNavbarNotifications();
            loadNavbarNotificationCount();
            
            // Set up auto-refresh every 30 seconds
            setInterval(function() {
                loadNavbarNotifications();
                loadNavbarNotificationCount();
            }, 30000);
        }
        
        // Handle navbar notification bell click
        $('#notification-bell-nav').on('click', function() {
            loadNavbarNotifications();
        });
        
        
        function loadNavbarNotifications() {
            $.ajax({
                url: '{{ route("dashboard.notifications") }}',
                method: 'GET',
                success: function(data) {
                    displayNavbarNotifications(data);
                },
                error: function() {
                    console.log('Error loading navbar notifications');
                }
            });
        }
        
        function loadNavbarNotificationCount() {
            $.ajax({
                url: '{{ route("dashboard.notification-count") }}',
                method: 'GET',
                success: function(data) {
                    updateNavbarNotificationCount(data.count);
                },
                error: function() {
                    console.log('Error loading navbar notification count');
                }
            });
        }
        
        function updateNavbarNotificationCount(count) {
            const countElement = $('#notification-count-nav');
            if (count > 0) {
                countElement.text(count).removeClass('hidden');
            } else {
                countElement.addClass('hidden');
            }
        }
        
        function displayNavbarNotifications(notifications) {
            const container = $('#notification-list-nav');
            
            if (notifications.length === 0) {
                container.html(`
                    <div class="text-center py-3">
                        <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No notifications</p>
                    </div>
                `);
                return;
            }
            
            let html = '';
            notifications.forEach(function(notification) {
                const isExpired = notification.is_expired;
                const isRead = notification.read_at !== null;
                const statusClass = isExpired ? 'text-danger' : 
                                  isRead ? 'text-muted' : 'text-primary';
                const bgClass = isRead ? 'bg-light' : 'bg-white';
                
                html += `
                    <div class="dropdown-item-text notification-item ${bgClass}" style="border-bottom: 1px solid #f0f0f0; padding: 12px;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-${getTypeBadgeClassNavbar(notification.type)} mr-2">
                                        ${notification.type.charAt(0).toUpperCase() + notification.type.slice(1)}
                                    </span>
                                    ${!isRead ? '<i class="fas fa-circle text-primary" style="font-size: 8px;" title="Unread"></i>' : ''}
                                    ${isExpired ? '<span class="badge badge-danger ml-1">Expired</span>' : ''}
                                </div>
                                <div class="${statusClass}" style="font-size: 14px; line-height: 1.4; margin-bottom: 8px;">
                                    ${notification.text}
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock mr-1"></i>
                                        ${new Date(notification.created_at).toLocaleString()}
                                    </small>
                                    ${!isRead ? `
                                        <button class="btn btn-xs btn-outline-success mark-read-navbar" data-id="${notification.id}" title="Mark as read">
                                            <i class="fas fa-check mr-1"></i>Read
                                        </button>
                                    ` : `
                                        <small class="text-success">
                                            <i class="fas fa-check-circle mr-1"></i>Read
                                        </small>
                                    `}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            if (notifications.length === 0) {
                html = `
                    <div class="text-center py-4">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No notifications</h6>
                        <p class="text-muted small">You don't have any notifications at the moment.</p>
                    </div>
                `;
            }
            
            container.html(html);
            
            // Handle mark as read for navbar dropdown
            $('.mark-read-navbar').on('click', function() {
                const notificationId = $(this).data('id');
                markAsReadNavbar(notificationId);
            });
        }
        
        function markAsReadNavbar(notificationId) {
            $.ajax({
                url: `/notifications/${notificationId}/mark-read`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    // Refresh navbar notifications
                    loadNavbarNotifications();
                    loadNavbarNotificationCount();
                },
                error: function() {
                    console.log('Error marking notification as read');
                }
            });
        }
        
        
        function showToastNavbar(type, message) {
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
        
        function getTypeBadgeClassNavbar(type) {
            const classes = {
                'marketing': 'warning',
                'invoices': 'info',
                'system': 'secondary'
            };
            return classes[type] || 'secondary';
        }
    });
    </script>

</body>
</html>
