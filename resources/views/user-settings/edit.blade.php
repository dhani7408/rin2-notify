<x-adminlte-layout>
    <x-slot name="headerTitle">Notification Settings</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item active">Settings</li>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Settings</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user-settings.update') }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input id="phone_number" type="tel" name="phone_number" class="form-control" 
                                   value="{{ old('phone_number', $user->phone_number) }}" 
                                   placeholder="+1234567890">
                            <small class="form-text text-muted">
                                Enter your phone number with country code (e.g., +1234567890). Must start with + and contain only digits.
                            </small>
                            @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notification Switch -->
                        <div class="form-group">
                            <div class="form-check">
                                <input id="notification_switch" type="checkbox" name="notification_switch" value="1" 
                                       {{ old('notification_switch', $user->notification_switch) ? 'checked' : '' }}
                                       class="form-check-input">
                                <label for="notification_switch" class="form-check-label">
                                    Enable on-screen notifications
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                When enabled, you will receive notifications on your dashboard.
                            </small>
                            @error('notification_switch')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Current Settings -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Settings</h3>
                </div>
                <div class="card-body">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-user"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Name</span>
                            <span class="info-box-number">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-primary">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Email</span>
                            <span class="info-box-number">{{ $user->email }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-warning">
                            <i class="fas fa-phone"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Phone</span>
                            <span class="info-box-number">{{ $user->phone_number ?? 'Not provided' }}</span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon {{ $user->notification_switch ? 'bg-success' : 'bg-danger' }}">
                            <i class="fas fa-bell"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Notifications</span>
                            <span class="info-box-number">
                                {{ $user->notification_switch ? 'Enabled' : 'Disabled' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Help</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> About Phone Number Format</h5>
                        <p class="mb-0">
                            Phone numbers must be in international format starting with a country code (e.g., +1234567890). 
                            This ensures that notifications can be delivered to your phone if needed.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminlte-layout>