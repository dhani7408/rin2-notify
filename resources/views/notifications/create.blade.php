<x-adminlte-layout>
    <x-slot name="headerTitle">Create New Notification</x-slot>
    <x-slot name="breadcrumbs">
        <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
        <li class="breadcrumb-item active">Create</li>
    </x-slot>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Notification Details</h3>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('notifications.store') }}" id="notification-form">
                        @csrf

                        <!-- Type -->
                        <div class="form-group">
                            <label for="type">Notification Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="">Select a type</option>
                                <option value="marketing" {{ old('type') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="invoices" {{ old('type') == 'invoices' ? 'selected' : '' }}>Invoices</option>
                                <option value="system" {{ old('type') == 'system' ? 'selected' : '' }}>System</option>
                            </select>
                            @error('type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Text -->
                        <div class="form-group">
                            <label for="text">Notification Text</label>
                            <textarea id="text" name="text" rows="4" class="form-control" required placeholder="Enter the notification message...">{{ old('text') }}</textarea>
                            <small class="form-text text-muted">Maximum 1000 characters. Keep it concise and clear.</small>
                            @error('text')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Expiration Date -->
                        <div class="form-group">
                            <label for="expires_at">Expiration Date & Time</label>
                            <input id="expires_at" name="expires_at" type="datetime-local" 
                                   value="{{ old('expires_at') }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}"
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
                                       {{ old('destination', 'all') == 'all' ? 'checked' : '' }}
                                       class="form-check-input">
                                <label for="destination_all" class="form-check-label">
                                    Send to all users
                                </label>
                            </div>
                            <div class="form-check">
                                <input id="destination_specific" type="radio" name="destination" value="specific" 
                                       {{ old('destination') == 'specific' ? 'checked' : '' }}
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
                        <div id="user-selection" class="form-group" style="display: none;">
                            <label for="user_id">Select User</label>
                            <select id="user_id" name="user_id" class="form-control select2" style="width: 100%;">
                                <option value="">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                        @if($user->last_login_at)
                                            (Last login: {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }})
                                        @else
                                            (Never logged in)
                                        @endif
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
                            <a href="{{ route('notifications.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Notification
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preview</h3>
                </div>
                <div class="card-body">
                    <div id="preview" class="text-muted">
                        Fill in the form to see a preview of your notification.
                    </div>
                </div>
            </div>
        </div>
    </div>


<x-slot name="scripts">
<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationRadios = document.querySelectorAll('input[name="destination"]');
    const userSelection = document.getElementById('user-selection');
    const userIdSelect = document.getElementById('user_id');
    const preview = document.getElementById('preview');
    
    const typeSelect = document.getElementById('type');
    const textTextarea = document.getElementById('text');
    const expiresAtInput = document.getElementById('expires_at');

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
            updatePreview();
        });
    });

    // Update preview when form changes
    [typeSelect, textTextarea, expiresAtInput, userIdSelect].forEach(element => {
        element.addEventListener('input', updatePreview);
    });

    // Initial setup
    const checkedRadio = document.querySelector('input[name="destination"]:checked');
    if (checkedRadio && checkedRadio.value === 'specific') {
        userSelection.style.display = 'block';
        userIdSelect.required = true;
    }

    function updatePreview() {
        const type = typeSelect.value;
        const text = textTextarea.value;
        const expiresAt = expiresAtInput.value;
        const checkedRadio = document.querySelector('input[name="destination"]:checked');
        const destination = checkedRadio ? checkedRadio.value : 'all';
        const userId = userIdSelect.value;
        
        let previewText = '';
        
        if (type && text && expiresAt) {
            const selectedUser = userId && users ? users.find(u => u.id == userId) : null;
            const destinationText = destination === 'all' ? 'All users' : (selectedUser ? selectedUser.name : 'Selected user');
            
            previewText = `
                <div class="alert alert-info">
                    <div class="d-flex align-items-center mb-2">
                        <span class="badge badge-${getTypeBadgeClass(type)} mr-2">
                            ${type.charAt(0).toUpperCase() + type.slice(1)}
                        </span>
                        <small>To: ${destinationText}</small>
                    </div>
                    <p class="mb-1">${text}</p>
                    <small class="text-muted">Expires: ${new Date(expiresAt).toLocaleString()}</small>
                </div>
            `;
        } else {
            previewText = '<div class="text-muted">Fill in the form to see a preview of your notification.</div>';
        }
        
        preview.innerHTML = previewText;
    }

    function getTypeBadgeClass(type) {
        const classes = {
            'marketing': 'warning',
            'invoices': 'info',
            'system': 'secondary'
        };
        return classes[type] || 'secondary';
    }

    // Initialize Select2 for user selection
    if ($('#user_id').length) {
        $('#user_id').select2({
            placeholder: 'Select a user',
            allowClear: true,
            width: '100%'
        });
    }

    // Initial preview update
    updatePreview();
});

// Users data for preview
const users = @json($users);
</script>
</x-slot>

</x-adminlte-layout>