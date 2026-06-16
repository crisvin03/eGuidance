@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')
<style>
.user-avatar-sm {
    width:32px;height:32px;font-size:0.75rem;
    background:linear-gradient(135deg,#20B2AA,#008B8B);
    border-radius:50%;display:flex;align-items:center;
    justify-content:center;color:white;font-weight:600;
    flex-shrink:0;
}
</style>
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1">User Management</h5>
            <small class="text-muted">Manage all user accounts, roles, and access levels.</small>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
            <i class="bi bi-plus-circle me-1"></i> Add New User
        </a>
    </div>
</div>

<!-- Search & Filter -->
<form method="GET" class="mb-4">
    <div class="row g-2">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, email, or ID..." value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                <option value="student" {{ request('role')=='student' ? 'selected' : '' }}>Student</option>
                <option value="counselor" {{ request('role')=='counselor' ? 'selected' : '' }}>Counselor</option>
                <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ request('role')=='teacher' ? 'selected' : '' }}>Teacher</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn w-100 text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
        </div>
    </div>
</form>

@if($users->count() > 0)
    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th class="table-hide-mobile">Email</th>
                            <th>Role</th>
                            <th class="table-hide-mobile">Student ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar-sm">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="fw-medium">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="table-hide-mobile">{{ $user->email }}</td>
                                <td>
                                    @if($user->isAdmin())
                                        <span class="badge badge-danger">Administrator</span>
                                    @elseif($user->isCounselor())
                                        <span class="badge badge-success">Counselor</span>
                                    @elseif($user->isTeacher())
                                        <span class="badge" style="background:#eff6ff;color:#7c3aed;">Teacher</span>
                                    @else
                                        <span class="badge badge-info">Student</span>
                                    @endif
                                </td>
                                <td class="table-hide-mobile">{{ $user->student_id ?? '-' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge" style="background:#f1f5f9;color:#64748b;">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            <span class="btn-label">Edit</span>
                                        </a>
                                        @if($user->is_active)
                                            <button class="btn btn-warning btn-sm" onclick="deactivateUser({{ $user->id }})">
                                                <i class="bi bi-pause"></i>
                                                <span class="btn-label">Deactivate</span>
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" onclick="activateUser({{ $user->id }})">
                                                <i class="bi bi-play"></i>
                                                <span class="btn-label">Activate</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3 px-2">
            <small class="text-muted">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results</small>
            <nav>{{ $users->onEachSide(1)->links('pagination::simple-bootstrap-5') }}</nav>
        </div>
    @endif
@else
    <div class="text-center py-5">
        <i class="bi bi-people" style="font-size: 4rem; color: #cbd5e1;"></i>
        <h4 class="mt-3 text-muted">No Users Found</h4>
        @if(request('search') || request('role') || request('status'))
            <p class="text-muted">No users match your filters. <a href="{{ route('admin.users.index') }}">Clear filters</a></p>
        @else
            <p class="text-muted">Get started by creating your first user account.</p>
            <a href="{{ route('admin.users.create') }}" class="btn text-white" style="background:linear-gradient(135deg,#20B2AA,#008B8B);">
                <i class="bi bi-plus-circle me-1"></i> Create First User
            </a>
        @endif
    </div>
@endif

<script>
function deactivateUser(userId) {
    if (confirm('Are you sure you want to deactivate this user?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}/deactivate`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function activateUser(userId) {
    if (confirm('Are you sure you want to activate this user?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${userId}/activate`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
