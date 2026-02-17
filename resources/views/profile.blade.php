@extends('layouts.dashboard')

@section('title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <div class="user-avatar mx-auto mb-3" style="width: 80px; height: 80px; font-size: 1.5rem;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <h5 class="card-title">{{ Auth::user()->name }}</h5>
                <p class="card-text text-muted">{{ ucfirst(Auth::user()->role->name) }}</p>
                @if(Auth::user()->student_id)
                    <p class="card-text"><small class="text-muted">ID: {{ Auth::user()->student_id }}</small></p>
                @endif
                <div class="mt-3">
                    <span class="badge {{ Auth::user()->is_active ? 'badge-success' : 'badge-secondary' }}">
                        {{ Auth::user()->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title">Quick Stats</h6>
            </div>
            <div class="card-body">
                @if(Auth::user()->role_id == 1) <!-- Student -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Concerns Submitted</span>
                        <strong>{{ App\Models\Concern::where('student_id', Auth::user()->id)->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Appointments</span>
                        <strong>{{ App\Models\Appointment::where('student_id', Auth::user()->id)->count() }}</strong>
                    </div>
                @elseif(Auth::user()->role_id == 2) <!-- Counselor -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Concerns Handled</span>
                        <strong>{{ App\Models\Concern::count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Appointments</span>
                        <strong>{{ App\Models\Appointment::where('counselor_id', Auth::user()->id)->count() }}</strong>
                    </div>
                @else <!-- Admin -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Users</span>
                        <strong>{{ App\Models\User::count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Concerns</span>
                        <strong>{{ App\Models\Concern::count() }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Profile Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                    </div>
                    
                    @if(Auth::user()->student_id)
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" value="{{ Auth::user()->student_id }}" readonly>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ Auth::user()->date_of_birth ?? '' }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Save Changes
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title">Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-lock"></i>
                        Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
