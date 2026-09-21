@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-gear"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Settings</h1>
            <p class="modern-page-subtitle">Manage your preferences and account settings</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="modern-alert modern-alert-success" style="margin-bottom: 1.5rem;">
        <i class="bi bi-check-circle" style="font-size: 1.25rem; color: #10b981;"></i>
        <span style="flex: 1;">{{ session('success') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.75rem;"></button>
    </div>
@endif
@if($errors->any())
    <div class="modern-alert modern-alert-danger" style="margin-bottom: 1.5rem;">
        <i class="bi bi-exclamation-circle" style="font-size: 1.25rem; color: #ef4444;"></i>
        <span style="flex: 1;">{{ $errors->first() }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.75rem;"></button>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 1.5rem;">
    <div>
        <!-- Notification Settings -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div class="modern-section-header" style="margin-bottom: 1.25rem;">
                <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                    <i class="bi bi-bell"></i>
                </div>
                <h2 class="modern-section-title" style="font-size: 1.15rem;">Notification Settings</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.notifications') }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Email Notifications</h6>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="email_concerns" name="email_concerns" {{ ($settings['email_concerns'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_concerns" style="font-size: 0.9rem; color: var(--text-dark);">
                            Concern updates and responses
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="email_appointments" name="email_appointments" {{ ($settings['email_appointments'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_appointments" style="font-size: 0.9rem; color: var(--text-dark);">
                            Appointment reminders and updates
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="email_system" name="email_system" {{ ($settings['email_system'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_system" style="font-size: 0.9rem; color: var(--text-dark);">
                            System announcements and updates
                        </label>
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">In-App Notifications</h6>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="app_concerns" name="app_concerns" {{ ($settings['app_concerns'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="app_concerns" style="font-size: 0.9rem; color: var(--text-dark);">
                            New concerns and responses
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="app_appointments" name="app_appointments" {{ ($settings['app_appointments'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="app_appointments" style="font-size: 0.9rem; color: var(--text-dark);">
                            Appointment notifications
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="app_messages" name="app_messages" {{ ($settings['app_messages'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="app_messages" style="font-size: 0.9rem; color: var(--text-dark);">
                            Messages and communications
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-bell"></i>
                    <span>Save Notification Settings</span>
                </button>
            </form>
        </div>
        
        <!-- Privacy Settings -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <div class="modern-section-header" style="margin-bottom: 1.25rem;">
                <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.08)); color: #10b981;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h2 class="modern-section-title" style="font-size: 1.15rem;">Privacy Settings</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.privacy') }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Profile Visibility</h6>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="show_email" name="show_email" {{ ($settings['show_email'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_email" style="font-size: 0.9rem; color: var(--text-dark);">
                            Show email address to other users
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="show_phone" name="show_phone" {{ ($settings['show_phone'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_phone" style="font-size: 0.9rem; color: var(--text-dark);">
                            Show phone number to counselors
                        </label>
                    </div>
                    @if(Auth::user()->isStudent())
                    <div class="form-check form-switch" style="margin-bottom: 0; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="anonymous_default" name="anonymous_default" {{ ($settings['anonymous_default'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="anonymous_default" style="font-size: 0.9rem; color: var(--text-dark);">
                            Submit concerns anonymously by default
                        </label>
                    </div>
                    @endif
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Data & Privacy</h6>
                    <div class="form-check form-switch" style="margin-bottom: 0.75rem; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="data_analytics" name="data_analytics" {{ ($settings['data_analytics'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="data_analytics" style="font-size: 0.9rem; color: var(--text-dark);">
                            Allow usage analytics for improvement
                        </label>
                    </div>
                    <div class="form-check form-switch" style="margin-bottom: 0; padding-left: 2.5rem;">
                        <input class="form-check-input" type="checkbox" id="remember_login" name="remember_login" {{ ($settings['remember_login'] ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember_login" style="font-size: 0.9rem; color: var(--text-dark);">
                            Remember login session
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-shield-check"></i>
                    <span>Save Privacy Settings</span>
                </button>
            </form>
        </div>
        
        @if(Auth::user()->isStudent())
        <!-- Counseling Preferences -->
        <div class="modern-card" style="padding: 1.5rem;">
            <div class="modern-section-header" style="margin-bottom: 1.25rem;">
                <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(168, 85, 247, 0.15), rgba(168, 85, 247, 0.08)); color: #a855f7;">
                    <i class="bi bi-person-heart"></i>
                </div>
                <h2 class="modern-section-title" style="font-size: 1.15rem;">Counseling Preferences</h2>
            </div>
            
            <form method="POST" action="{{ route('settings.counseling') }}">
                @csrf
                @method('PUT')
                
                <div style="margin-bottom: 1rem;">
                    <label for="preferred_counselor" class="form-label" style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Preferred Counselor</label>
                    <select class="modern-form-control" id="preferred_counselor" name="preferred_counselor" style="font-size: 0.9rem;">
                        <option value="">No Preference</option>
                        @foreach(App\Models\User::whereHas('role', fn($q) => $q->where('name', 'counselor'))->where('is_active', 1)->get() as $counselor)
                            <option value="{{ $counselor->id }}" {{ ($settings['preferred_counselor'] ?? '') == $counselor->id ? 'selected' : '' }}>{{ $counselor->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-bottom: 1rem;">
                    <label for="appointment_reminder" class="form-label" style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Appointment Reminder Time</label>
                    <select class="modern-form-control" id="appointment_reminder" name="appointment_reminder" style="font-size: 0.9rem;">
                        <option value="15" {{ ($settings['appointment_reminder'] ?? '30') == '15' ? 'selected' : '' }}>15 minutes before</option>
                        <option value="30" {{ ($settings['appointment_reminder'] ?? '30') == '30' ? 'selected' : '' }}>30 minutes before</option>
                        <option value="60" {{ ($settings['appointment_reminder'] ?? '30') == '60' ? 'selected' : '' }}>1 hour before</option>
                        <option value="1440" {{ ($settings['appointment_reminder'] ?? '30') == '1440' ? 'selected' : '' }}>1 day before</option>
                    </select>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="contact_method" class="form-label" style="font-size: 0.9rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Preferred Contact Method</label>
                    <select class="modern-form-control" id="contact_method" name="contact_method" style="font-size: 0.9rem;">
                        <option value="email" {{ ($settings['contact_method'] ?? 'email') == 'email' ? 'selected' : '' }}>Email</option>
                        <option value="phone" {{ ($settings['contact_method'] ?? 'email') == 'phone' ? 'selected' : '' }}>Phone</option>
                        <option value="both" {{ ($settings['contact_method'] ?? 'email') == 'both' ? 'selected' : '' }}>Both</option>
                    </select>
                </div>
                
                <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                    <i class="bi bi-person-heart"></i>
                    <span>Save Counseling Preferences</span>
                </button>
            </form>
        </div>
        @endif
    </div>
    
    <!-- Sidebar -->
    <div>
        <!-- Account Actions -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Account Actions</h6>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <button class="modern-btn modern-btn-secondary" onclick="exportData()" style="padding: 0.625rem 1rem; font-size: 0.875rem; justify-content: flex-start;">
                    <i class="bi bi-download"></i>
                    <span>Export My Data</span>
                </button>
                <button class="modern-btn modern-btn-secondary" onclick="clearCache()" style="padding: 0.625rem 1rem; font-size: 0.875rem; justify-content: flex-start;">
                    <i class="bi bi-arrow-clockwise"></i>
                    <span>Clear Cache</span>
                </button>
                <button class="modern-btn modern-btn-secondary" onclick="viewActivity()" style="padding: 0.625rem 1rem; font-size: 0.875rem; justify-content: flex-start;">
                    <i class="bi bi-clock-history"></i>
                    <span>View Activity Log</span>
                </button>
                <hr style="margin: 0.5rem 0; border-color: rgba(13, 45, 82, 0.1);">
                <button class="modern-btn" onclick="confirmDeactivate()" style="background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(239, 68, 68, 0.05)); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 0.625rem 1rem; font-size: 0.875rem; justify-content: flex-start;">
                    <i class="bi bi-pause-circle"></i>
                    <span>Deactivate Account</span>
                </button>
            </div>
        </div>
        
        <!-- System Information -->
        <div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">System Information</h6>
            <div style="display: flex; flex-direction: column; gap: 0.875rem;">
                <div>
                    <small style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Version</small>
                    <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">v2.0.0</div>
                </div>
                <div>
                    <small style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Last Login</small>
                    <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('M d, Y h:i A') : 'First time' }}</div>
                </div>
                <div>
                    <small style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Account Created</small>
                    <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">{{ Auth::user()->created_at->format('M d, Y') }}</div>
                </div>
                <div>
                    <small style="font-size: 0.75rem; color: var(--text-muted); display: block; margin-bottom: 0.25rem;">Storage Used</small>
                    <div style="font-size: 0.9rem; font-weight: 600; color: var(--navy);">2.3 MB</div>
                </div>
            </div>
        </div>
        
        <!-- Help & Support -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">Help & Support</h6>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="#" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem; text-decoration: none; justify-content: flex-start;">
                    <i class="bi bi-question-circle"></i>
                    <span>Help Center</span>
                </a>
                <a href="#" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem; text-decoration: none; justify-content: flex-start;">
                    <i class="bi bi-book"></i>
                    <span>User Guide</span>
                </a>
                <a href="#" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1rem; font-size: 0.875rem; text-decoration: none; justify-content: flex-start;">
                    <i class="bi bi-envelope"></i>
                    <span>Contact Support</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-page-header + div {
        grid-template-columns: 1fr !important;
    }
}
</style>

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
