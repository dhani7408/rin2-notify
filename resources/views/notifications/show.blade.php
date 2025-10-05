<x-adminlte-layout>
    <x-slot name="headerTitle">Notification Details</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
        <li class="breadcrumb-item active">View</li>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <!-- Notification Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-bell mr-2"></i>
                            {{ ucfirst($notification->type) }} Notification
                        </h3>
                        <div>
                            @if(\Carbon\Carbon::parse($notification->expires_at)->isPast())
                                <span class="badge badge-danger">Expired</span>
                            @else
                                <span class="badge badge-success">Active</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Notification Message -->
                    <div class="mb-4">
                        <h5 class="font-weight-bold">Message Content</h5>
                        <div class="alert alert-info">
                            <p class="mb-0">{{ $notification->text }}</p>
                        </div>
                    </div>

                    <!-- Read Status -->
                    <div class="mb-4">
                        <h5 class="font-weight-bold">
                            <i class="fas fa-eye mr-2"></i>Read Status
                        </h5>
                        
                        @if($notification->readByUsers->count() > 0)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-sm font-weight-bold">
                                        Read by {{ $notification->readByUsers->count() }} user(s)
                                    </span>
                                    <div class="progress" style="width: 200px; height: 8px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ ($notification->readByUsers->count() / max(1, $notification->is_for_all ? \App\Models\User::count() : 1)) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="list-group">
                                @foreach($notification->readByUsers as $user)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3" 
                                                     style="width: 40px; height: 40px;">
                                                    {{ substr($user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                                    <div class="text-muted small">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($user->pivot->read_at)->format('M j, Y') }}
                                                </div>
                                                <div class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($user->pivot->read_at)->format('g:i A') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-eye-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No reads yet</h5>
                                <p class="text-muted">This notification hasn't been read by any users.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Destination Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>Destination
                    </h3>
                </div>
                <div class="card-body">
                    @if($notification->is_for_all)
                        <div class="text-center">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h5 class="text-success font-weight-bold">All Users</h5>
                            <p class="text-muted">This notification is visible to all users</p>
                        </div>
                    @else
                        <div class="text-center">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                            <h5 class="text-primary font-weight-bold">{{ $notification->user->name ?? 'Unknown User' }}</h5>
                            <p class="text-muted">{{ $notification->user->email ?? 'No email' }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timing Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock mr-2"></i>Timing
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-calendar-plus"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Created</span>
                                    <span class="info-box-number">{{ \Carbon\Carbon::parse($notification->created_at)->format('M j, Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->format('g:i A') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-calendar-times"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Expires</span>
                                    <span class="info-box-number">{{ \Carbon\Carbon::parse($notification->expires_at)->format('M j, Y') }}</span>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($notification->expires_at)->format('g:i A') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-box">
                        <span class="info-box-icon bg-secondary">
                            <i class="fas fa-hourglass-half"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Duration</span>
                            <span class="info-box-number">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans(\Carbon\Carbon::parse($notification->expires_at), true) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-2"></i>Actions
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('notifications.edit', $notification) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-2"></i>Edit Notification
                        </a>
                        
                        <form method="POST" action="{{ route('notifications.destroy', $notification) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this notification?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash mr-2"></i>Delete Notification
                            </button>
                        </form>
                        
                        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                        </a>
                    </div>
                    
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            Last updated {{ \Carbon\Carbon::parse($notification->updated_at)->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminlte-layout>