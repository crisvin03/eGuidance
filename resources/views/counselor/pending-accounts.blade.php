@extends('layouts.dashboard')
@section('title', 'Pending Account Approvals')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-stats-grid { grid-template-columns: 1fr !important; gap: 0.75rem !important; }
    .table-responsive { font-size: 0.875rem !important; }
    .badge { font-size: 0.7rem !important; padding: 0.25rem 0.5rem !important; }
    .btn { font-size: 0.875rem !important; padding: 0.5rem 1rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-check-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Pending Account Approvals</h1>
            <p class="modern-page-subtitle">Review and approve new teacher accounts before they can access the portal</p>
        </div>
        <span class="modern-badge modern-badge-info" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
            <i class="bi bi-hourglass-split"></i> {{ $pending->count() }} Pending
        </span>
    </div>
</div>

@if($pending->isEmpty())
    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body text-center py-5">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                 style="width:72px;height:72px;background:rgba(30,122,74,.08);">
                <i class="bi bi-person-check fs-2" style="color:#1e7a4a;"></i>
            </div>
            <h5 class="fw-semibold mb-1" style="color:#0d2d52;">All caught up!</h5>
            <p class="text-muted mb-0">No pending account approvals at this time.</p>
        </div>
    </div>
@else
    <div class="card border-0 shadow-sm" style="border-radius:16px;overflow:hidden;">
        <div class="card-header border-0 d-flex align-items-center gap-2 px-4 py-3"
             style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
            <i class="bi bi-people" style="color:#1e7a4a;font-size:1.1rem;"></i>
            <span class="fw-semibold" style="color:#1e293b;">Pending Registrations</span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:.9rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th class="px-4 py-3" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Name</th>
                        <th class="px-4 py-3" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Email</th>
                        <th class="px-4 py-3" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Role</th>
                        <th class="px-4 py-3" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Employee ID</th>
                        <th class="px-4 py-3" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Registered</th>
                        <th class="px-4 py-3 text-end" style="color:#475569;font-weight:600;border-bottom:1px solid #e2e8f0;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending as $user)
                    <tr style="border-bottom:1px solid #f1f5f9;transition:background .2s;"
                        onmouseover="this.style.background='#f8fafc'"
                        onmouseout="this.style.background=''">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                                     style="width:36px;height:36px;background:linear-gradient(135deg,#1e7a4a,#145e38);font-size:.8rem;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-semibold" style="color:#1e293b;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3" style="color:#475569;">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="badge rounded-pill px-3"
                                  style="background:rgba(46,123,207,.1);color:#2e7bcf;font-size:.78rem;">
                                {{ ucfirst($user->role->name ?? '—') }}
                            </span>
                        </td>
                        <td class="px-4 py-3" style="color:#64748b;">{{ $user->student_id ?? '—' }}</td>
                        <td class="px-4 py-3" style="color:#64748b;">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-end">
                            <div class="d-inline-flex gap-2">
                                <button type="button"
                                        class="btn btn-sm fw-semibold d-inline-flex align-items-center gap-1"
                                        style="background:rgba(30,122,74,.1);color:#1e7a4a;border-radius:8px;padding:.35rem .85rem;font-size:.8rem;border:none;"
                                        onclick="openApprove({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                                <button type="button"
                                        class="btn btn-sm fw-semibold d-inline-flex align-items-center gap-1"
                                        style="background:rgba(220,38,38,.08);color:#dc2626;border:1px solid rgba(220,38,38,.15);border-radius:8px;padding:.35rem .85rem;font-size:.8rem;"
                                        onclick="openReject({{ $user->id }}, '{{ addslashes($user->name) }}')">
                                    <i class="bi bi-x-lg"></i> Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- Hidden forms --}}
<form id="approveForm" method="POST" action="">
    @csrf
</form>
<form id="rejectForm" method="POST" action="">
    @csrf
    @method('DELETE')
</form>

{{-- APPROVE MODAL --}}
<div id="approveModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(13,45,82,.45);backdrop-filter:blur(4px);" onclick="closeModals()"></div>
    <div style="position:relative;background:#fff;border-radius:20px;padding:2rem;width:min(440px,92vw);box-shadow:0 24px 60px rgba(13,45,82,.18);animation:slideUp .25s ease;">
        <div class="text-center mb-3">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                 style="width:64px;height:64px;background:rgba(30,122,74,.1);">
                <i class="bi bi-person-check-fill" style="font-size:1.8rem;color:#1e7a4a;"></i>
            </div>
            <h5 class="fw-bold mb-1" style="color:#0d2d52;">Approve Account</h5>
            <p class="text-muted mb-0" style="font-size:.9rem;">
                You are about to approve the account for<br>
                <strong id="approveUserName" style="color:#1e7a4a;"></strong>
            </p>
        </div>
        <div class="p-3 mb-3 rounded" style="background:#f0fdf4;border:1px solid #bbf7d0;">
            <div class="d-flex gap-2 align-items-start">
                <i class="bi bi-info-circle-fill mt-1" style="color:#1e7a4a;flex-shrink:0;"></i>
                <small style="color:#166534;">This will grant the user full access to their dashboard. They can log in immediately after approval.</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="button" onclick="closeModals()"
                    class="btn flex-fill fw-semibold"
                    style="background:#f1f5f9;color:#475569;border-radius:10px;padding:.65rem;">
                Cancel
            </button>
            <button type="button" onclick="submitApprove()"
                    class="btn flex-fill fw-semibold"
                    style="background:#1e7a4a;color:#fff;border-radius:10px;padding:.65rem;">
                <i class="bi bi-check-lg me-1"></i> Approve
            </button>
        </div>
    </div>
</div>

{{-- REJECT MODAL --}}
<div id="rejectModal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;">
    <div style="position:absolute;inset:0;background:rgba(13,45,82,.45);backdrop-filter:blur(4px);" onclick="closeModals()"></div>
    <div style="position:relative;background:#fff;border-radius:20px;padding:2rem;width:min(440px,92vw);box-shadow:0 24px 60px rgba(13,45,82,.18);animation:slideUp .25s ease;">
        <div class="text-center mb-3">
            <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                 style="width:64px;height:64px;background:#fef2f2;">
                <i class="bi bi-person-x-fill" style="font-size:1.8rem;color:#dc2626;"></i>
            </div>
            <h5 class="fw-bold mb-1" style="color:#0d2d52;">Reject Account</h5>
            <p class="text-muted mb-0" style="font-size:.9rem;">
                You are about to reject and delete the account for<br>
                <strong id="rejectUserName" style="color:#dc2626;"></strong>
            </p>
        </div>
        <div class="p-3 mb-3 rounded" style="background:#fef2f2;border:1px solid #fecaca;">
            <div class="d-flex gap-2 align-items-start">
                <i class="bi bi-exclamation-triangle-fill mt-1" style="color:#dc2626;flex-shrink:0;"></i>
                <small style="color:#dc2626;">This action is permanent. The account will be deleted and the user will need to register again.</small>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button type="button" onclick="closeModals()"
                    class="btn flex-fill fw-semibold"
                    style="background:#f1f5f9;color:#475569;border-radius:10px;padding:.65rem;">
                Cancel
            </button>
            <button type="button" onclick="submitReject()"
                    class="btn flex-fill fw-semibold"
                    style="background:#dc2626;color:#fff;border-radius:10px;padding:.65rem;">
                <i class="bi bi-trash me-1"></i> Reject & Delete
            </button>
        </div>
    </div>
</div>

<style>
@keyframes slideUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
}
</style>

<script>
let currentUserId = null;

function openApprove(id, name) {
    currentUserId = id;
    document.getElementById('approveUserName').textContent = name;
    const modal = document.getElementById('approveModal');
    modal.style.display = 'flex';
}

function openReject(id, name) {
    currentUserId = id;
    document.getElementById('rejectUserName').textContent = name;
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'flex';
}

function closeModals() {
    document.getElementById('approveModal').style.display = 'none';
    document.getElementById('rejectModal').style.display = 'none';
    currentUserId = null;
}

function submitApprove() {
    const form = document.getElementById('approveForm');
    form.action = `/counselor/pending-accounts/${currentUserId}/approve`;
    form.submit();
}

function submitReject() {
    const form = document.getElementById('rejectForm');
    form.action = `/counselor/pending-accounts/${currentUserId}/reject`;
    form.submit();
}

// Close on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModals(); });
</script>
@endsection
