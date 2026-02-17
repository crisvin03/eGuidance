@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Notification Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.notifications') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <h6 class="mb-3">Email Notifications</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="email_concerns" name="email_concerns" checked>
                            <label class="form-check-label" for="email_concerns">
                                Concern updates and responses
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="email_appointments" name="email_appointments" checked>
                            <label class="form-check-label" for="email_appointments">
                                Appointment reminders and updates
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="email_system" name="email_system" checked>
                            <label class="form-check-label" for="email_system">
                                System announcements and updates
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="mb-3">In-App Notifications</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="app_concerns" name="app_concerns" checked>
                            <label class="form-check-label" for="app_concerns">
                                New concerns and responses
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="app_appointments" name="app_appointments" checked>
                            <label class="form-check-label" for="app_appointments">
                                Appointment notifications
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="app_messages" name="app_messages" checked>
                            <label class="form-check-label" for="app_messages">
                                Messages and communications
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-bell"></i>
                        Save Notification Settings
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Privacy Settings</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.privacy') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <h6 class="mb-3">Profile Visibility</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="show_email" name="show_email">
                            <label class="form-check-label" for="show_email">
                                Show email address to other users
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="show_phone" name="show_phone">
                            <label class="form-check-label" for="show_phone">
                                Show phone number to counselors
                            </label>
                        </div>
                        @if(Auth::user()->role_id == 1)
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="anonymous_default" name="anonymous_default">
                            <label class="form-check-label" for="anonymous_default">
                                Submit concerns anonymously by default
                            </label>
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="mb-3">Data & Privacy</h6>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="data_analytics" name="data_analytics" checked>
                            <label class="form-check-label" for="data_analytics">
                                Allow usage analytics for improvement
                            </label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="remember_login" name="remember_login" checked>
                            <label class="form-check-label" for="remember_login">
                                Remember login session
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-shield-check"></i>
                        Save Privacy Settings
                    </button>
                </form>
            </div>
        </div>
        
        @if(Auth::user()->role_id == 1)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Counseling Preferences</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.counseling') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="preferred_counselor" class="form-label">Preferred Counselor</label>
                        <select class="form-select" id="preferred_counselor" name="preferred_counselor">
                            <option value="">No Preference</option>
                            @foreach(App\Models\User::where('role_id', 2)->where('is_active', 1)->get() as $counselor)
                                <option value="{{ $counselor->id }}">{{ $counselor->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="appointment_reminder" class="form-label">Appointment Reminder Time</label>
                        <select class="form-select" id="appointment_reminder" name="appointment_reminder">
                            <option value="15">15 minutes before</option>
                            <option value="30" selected>30 minutes before</option>
                            <option value="60">1 hour before</option>
                            <option value="1440">1 day before</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="contact_method" class="form-label">Preferred Contact Method</label>
                        <select class="form-select" id="contact_method" name="contact_method">
                            <option value="email" selected>Email</option>
                            <option value="phone">Phone</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-heart"></i>
                        Save Counseling Preferences
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Account Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary" onclick="exportData()">
                        <i class="bi bi-download"></i>
                        Export My Data
                    </button>
                    <button class="btn btn-outline-warning" onclick="clearCache()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Clear Cache
                    </button>
                    <button class="btn btn-outline-info" onclick="viewActivity()">
                        <i class="bi bi-clock-history"></i>
                        View Activity Log
                    </button>
                    <hr>
                    <button class="btn btn-outline-danger" onclick="confirmDeactivate()">
                        <i class="bi bi-pause-circle"></i>
                        Deactivate Account
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">System Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Version</small>
                    <div class="fw-bold">v1.0.0</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Last Login</small>
                    <div class="fw-bold">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y h:i A') : 'First time' }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Account Created</small>
                    <div class="fw-bold">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Storage Used</small>
                    <div class="fw-bold">2.3 MB</div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">Help & Support</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-question-circle"></i>
                        Help Center
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-book"></i>
                        User Guide
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="bi bi-envelope"></i>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportData() {
    if (confirm('This will download all your personal data. Continue?')) {
        // In a real application, this would trigger a data export
        alert('Data export functionality would be implemented here');
    }
}

function clearCache() {
    if (confirm('This will clear your local cache and you may need to login again. Continue?')) {
        // Clear localStorage and sessionStorage
        localStorage.clear();
        sessionStorage.clear();
        // Clear cookies
        document.cookie.split(";").forEach(function(c) { 
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); 
        });
        alert('Cache cleared successfully');
        setTimeout(() => location.reload(), 1000);
    }
}

function viewActivity() {
    alert('Activity log would show your recent actions and system interactions');
}

function confirmDeactivate() {
    if (confirm('Are you sure you want to deactivate your account? You can reactivate it later by contacting an administrator.')) {
        if (confirm('This is a permanent action until reactivation. Are you absolutely sure?')) {
            // In a real application, this would submit a deactivation request
            alert('Account deactivation request would be submitted here');
        }
    }
}
</script>
@endsection
