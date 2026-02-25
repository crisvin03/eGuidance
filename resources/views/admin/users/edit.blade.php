@extends('layouts.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Edit User</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Name <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role_id" class="col-md-4 col-form-label text-md-end">Role <span class="text-danger">*</span></label>
                        <div class="col-md-6">
                            <select id="role_id" class="form-select @error('role_id') is-invalid @enderror"
                                name="role_id" required onchange="toggleStudentFields()">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div id="student_fields" style="display: {{ $user->role_id == 1 ? 'block' : 'none' }};">
                        <div class="row mb-3">
                            <label for="student_id" class="col-md-4 col-form-label text-md-end">Student ID</label>
                            <div class="col-md-6">
                                <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror"
                                    name="student_id" value="{{ old('student_id', $user->student_id) }}">
                                @error('student_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                        <div class="col-md-6">
                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="date_of_birth" class="col-md-4 col-form-label text-md-end">Date of Birth</label>
                        <div class="col-md-6">
                            <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}">
                            @error('date_of_birth')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">Gender</label>
                        <div class="col-md-6">
                            <select id="gender" class="form-select @error('gender') is-invalid @enderror" name="gender">
                                <option value="">Select gender</option>
                                <option value="male"   {{ old('gender', $user->gender) == 'male'   ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other"  {{ old('gender', $user->gender) == 'other'  ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="address" class="col-md-4 col-form-label text-md-end">Address</label>
                        <div class="col-md-6">
                            <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <h6 class="text-muted mb-3 ms-md-4 ps-md-2">Change Password <small class="text-muted">(leave blank to keep current)</small></h6>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                        <div class="col-md-6">
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-md-4 col-form-label text-md-end">Account Status</label>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                    value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">User Info</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="user-avatar mx-auto mb-2" style="width:56px;height:56px;font-size:1.4rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                    <strong>{{ $user->name }}</strong><br>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>
                <hr>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-calendar3 text-muted me-2"></i>
                    <small class="text-muted">Joined {{ $user->created_at->format('M d, Y') }}</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    <small class="text-muted">Leave password blank to keep unchanged</small>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check text-success me-2"></i>
                    <small class="text-muted">Student ID only applies to student accounts</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleStudentFields() {
    const roleSelect = document.getElementById('role_id');
    const studentFields = document.getElementById('student_fields');
    studentFields.style.display = roleSelect.value == '1' ? 'block' : 'none';
}
</script>
@endsection
