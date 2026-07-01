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
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm" title="Edit user">
                                            <i class="bi bi-pencil"></i>
                                            <span class="btn-label">Edit</span>
                                        </a>
                                        @if($user->is_active)
                                            <button class="btn btn-warning btn-sm" onclick="deactivateUser({{ $user->id }})" title="Deactivate user">
                                                <i class="bi bi-pause"></i>
                                                <span class="btn-label">Deactivate</span>
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" onclick="activateUser({{ $user->id }})" title="Activate user">
                                                <i class="bi bi-play"></i>
                                                <span class="btn-label">Activate</span>
                                            </button>
                                        @endif
                                        @if($user->id !== Auth::id())
                                        <button class="btn btn-danger btn-sm" title="Delete account"
                                                onclick="confirmDeleteUser(
                                                    {{ $user->id }},
                                                    '{{ addslashes($user->name) }}',
                                                    '{{ addslashes($user->email) }}',
                                                    '{{ strtoupper(substr($user->name,0,2)) }}',
                                                    '{{ $user->role->name ?? 'user' }}'
                                                )">
                                            <i class="bi bi-trash3"></i>
                                            <span class="btn-label">Delete</span>
                                        </button>
                                        @else
                                        <button class="btn btn-outline-secondary btn-sm opacity-50" disabled title="Cannot delete your own account">
                                            <i class="bi bi-trash3"></i>
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

{{-- Professional Delete Confirmation Modal --}}
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content border-0" style="border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.18);">

            {{-- Danger stripe --}}
            <div style="height:5px;border-radius:20px 20px 0 0;background:linear-gradient(90deg,#ef4444,#dc2626);"></div>

            <div class="modal-body p-4">
                {{-- Icon --}}
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width:64px;height:64px;background:rgba(239,68,68,.1);">
                        <i class="bi bi-person-x-fill" style="font-size:1.75rem;color:#ef4444;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" style="color:#1e293b;">Delete User Account?</h5>
                    <p class="text-muted small mb-0">This will permanently remove the account and all associated data.</p>
                </div>

                {{-- User details card --}}
                <div class="rounded-3 p-3 mb-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white"
                             id="del_avatar"
                             style="width:44px;height:44px;min-width:44px;background:linear-gradient(135deg,#ef4444,#dc2626);font-size:.9rem;"></div>
                        <div>
                            <div class="fw-bold" id="del_name" style="color:#1e293b;"></div>
                            <div class="small text-muted" id="del_email"></div>
                            <span class="badge mt-1 text-capitalize" id="del_role"
                                  style="background:#fef3c7;color:#92400e;border:1px solid #fbbf24;font-size:.7rem;"></span>
                        </div>
                    </div>
                </div>

                {{-- Warning list --}}
                <div class="rounded-3 p-3" style="background:#fef2f2;border:1px solid #fecaca;">
                    <div class="d-flex align-items-start gap-2 mb-2">
                        <i class="bi bi-exclamation-triangle-fill text-danger mt-1" style="font-size:.85rem;"></i>
                        <div class="small text-danger fw-semibold">This action cannot be undone. The following will be deleted:</div>
                    </div>
                    <ul class="small text-danger mb-0 ps-4" style="line-height:1.8;">
                        <li>User account and login credentials</li>
                        <li>Profile photo and personal information</li>
                        <li>All associated records and submissions</li>
                    </ul>
                </div>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cancel
                </button>
                <form id="deleteUserForm" method="POST" class="flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 fw-semibold" style="border-radius:10px;">
                        <i class="bi bi-trash3 me-1"></i> Yes, Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteUser(id, name, email, initials, role) {
    document.getElementById('del_name').textContent     = name;
    document.getElementById('del_email').textContent    = email;
    document.getElementById('del_avatar').textContent   = initials;
    document.getElementById('del_role').textContent     = role.charAt(0).toUpperCase() + role.slice(1);
    document.getElementById('deleteUserForm').action    = '/admin/users/' + id;
    new bootstrap.Modal(document.getElementById('deleteUserModal')).show();
}

function deactivateUser(userId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/users/${userId}/deactivate`;
    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
}

function activateUser(userId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/users/${userId}/activate`;
    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
    form.appendChild(csrf);
    document.body.appendChild(form);
    form.submit();
}

// Auto-dismiss toast
function dismissToast() {
    const t = document.getElementById('flashToast');
    if (!t) return;
    t.style.animation = 'slideOutRight .35s ease forwards';
    setTimeout(() => t.remove(), 350);
}
// Auto-dismiss after 4 seconds
window.addEventListener('DOMContentLoaded', () => {
    const t = document.getElementById('flashToast');
    if (t) setTimeout(() => dismissToast(), 4000);
});
</script>
@endsection
