@extends('layouts.dashboard')

@section('title', 'User Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title">User Management</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Add New User
        </a>
    </div>
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Student ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role_id == 3)
                                        <span class="badge badge-danger">Administrator</span>
                                    @elseif($user->role_id == 2)
                                        <span class="badge badge-success">Counselor</span>
                                    @else
                                        <span class="badge badge-info">Student</span>
                                    @endif
                                </td>
                                <td>{{ $user->student_id ?? '-' }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </a>
                                        @if($user->is_active)
                                            <button class="btn btn-warning btn-sm" onclick="deactivateUser({{ $user->id }})">
                                                <i class="bi bi-pause"></i>
                                                Deactivate
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" onclick="activateUser({{ $user->id }})">
                                                <i class="bi bi-play"></i>
                                                Activate
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people" style="font-size: 4rem; color: #cbd5e1;"></i>
                <h4 class="mt-3 text-muted">No Users Found</h4>
                <p class="text-muted">Get started by creating your first user account.</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Create First User
                </a>
            </div>
        @endif
    </div>
</div>

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
