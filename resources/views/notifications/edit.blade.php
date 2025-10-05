<x-adminlte-layout>
    <x-slot name="headerTitle">Edit Notification</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
        <li class="breadcrumb-item"><a href="{{ route('notifications.show', $notification) }}">View</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </x-slot>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Notification Details</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('notifications.update', $notification) }}">
                        @csrf
                        @method('PUT')

                        <!-- Type -->
                        <div class="form-group">
                            <label for="type">Notification Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select a type</option>
                                <option value="marketing" {{ old('type', $notification->type) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="invoices" {{ old('type', $notification->type) == 'invoices' ? 'selected' : '' }}>Invoices</option>
                                <option value="system" {{ old('type', $notification->type) == 'system' ? 'selected' : '' }}>System</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Text -->
                        <div class="form-group">
                            <label for="text">Notification Text</label>
                            <textarea id="text" name="text" rows="4" class="form-control" required placeholder="Enter the notification message...">{{ old('text', $notification->text) }}</textarea>
                            <small class="form-text text-muted">Maximum 1000 characters. Keep it concise and clear.</small>
                            @error('text')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Expiration Date -->
                        <div class="form-group">
                            <label for="expires_at">Expiration Date & Time</label>
                            <input id="expires_at" name="expires_at" type="datetime-local" 
                                   value="{{ old('expires_at', \Carbon\Carbon::parse($notification->expires_at)->format('Y-m-d\TH:i')) }}"
                                   class="form-control" required>
                            <small class="form-text text-muted">The notification will automatically disappear after this date.</small>
                            @error('expires_at')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Destination -->
                        <div class="form-group">
                            <label>Destination</label>
                            <div class="form-check">
                                <input id="destination_all" type="radio" name="destination" value="all" 
                                       {{ old('destination', $notification->is_for_all ? 'all' : 'specific') == 'all' ? 'checked' : '' }}
                                       class="form-check-input">
                                <label for="destination_all" class="form-check-label">
                                    Send to all users
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="destination_specific" type="radio" name="destination" value="specific" 
                                       {{ old('destination', $notification->is_for_all ? 'all' : 'specific') == 'specific' ? 'checked' : '' }}
                                       class="form-check-input">
                                <label for="destination_specific" class="form-check-label">
                                    Send to specific user
                                </label>
                            </div>
                            @error('destination')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User Selection (shown only when specific user is selected) -->
                        <div id="user-selection" class="form-group" style="display: {{ old('destination', $notification->is_for_all ? 'all' : 'specific') == 'specific' ? 'block' : 'none' }};">
                            <label for="user_id">Select User</label>
                            <select id="user_id" name="user_id" class="form-control select2" style="width: 100%;">
                                <option value="">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $notification->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                       
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Search and select a specific user to send the notification to.</small>
                            @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group">
                            <a href="{{ route('notifications.show', $notification) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Notification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Current Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Current Information</h3>
                </div>
                <div class="card-body">
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

                    <div class="info-box">
                        <span class="info-box-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Current Destination</span>
                            <span class="info-box-number">
                                @if($notification->is_for_all)
                                    All Users
                                @else
                                    {{ $notification->user->name ?? 'Unknown User' }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="info-box">
                        <span class="info-box-icon bg-success">
                            <i class="fas fa-eye"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Read by</span>
                            <span class="info-box-number">{{ $notification->readByUsers->count() }} user(s)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('notifications.show', $notification) }}" class="btn btn-info">
                            <i class="fas fa-eye mr-2"></i>View Details
                        </a>
                        <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list mr-2"></i>Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-adminlte-layout>

<x-slot name="scripts">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationRadios = document.querySelectorAll('input[name="destination"]');
    const userSelection = document.getElementById('user-selection');
    const userIdSelect = document.getElementById('user_id');

    // Handle destination change
    destinationRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'specific') {
                userSelection.style.display = 'block';
                userIdSelect.required = true;
            } else {
                userSelection.style.display = 'none';
                userIdSelect.required = false;
            }
        });
    });

    // Initialize Select2 for user selection
    if ($('#user_id').length) {
        $('#user_id').select2({
            placeholder: 'Select a user',
            allowClear: true,
            width: '100%'
        });
    }
});
</script>
</x-slot>