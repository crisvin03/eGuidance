@extends('layouts.dashboard')
@section('title', 'My Submitted Forms')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    
    /* Filter Form - Stack Vertically */
    .filter-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        align-items: stretch !important;
        grid-template-columns: unset !important;
    }
    .filter-form > div {
        width: 100% !important;
    }
    .filter-form .form-control,
    .filter-form .form-select {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    .filter-form .modern-btn,
    .filter-form button[type="submit"] {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    
    /* Table Action Buttons - Icon Only */
    .btn span:not([class*="bi"]),
    .btn-sm span:not([class*="bi"]) { 
        display: none !important; 
    }
    .btn i.bi,
    .btn-sm i.bi { 
        margin: 0 !important; 
    }
    .btn-sm { 
        padding: 0.5rem 0.75rem !important; 
        min-width: auto !important; 
    }
    
    .table-hide-mobile { display: none !important; }
    .modern-btn { width: 100% !important; justify-content: center !important; }
}
.pagination { margin: 0; gap: 3px; }
.pagination .page-link { border-radius: 8px !important; border: 1px solid #e2e8f0; color: #475569; font-size: 0.875rem; padding: 0.4rem 0.75rem; transition: all .2s; }
.pagination .page-link:hover { background: rgba(32,178,170,.1); border-color: #1e7a4a; color: #1e7a4a; }
.pagination .page-item.active .page-link { background: #1e7a4a; border-color: #1e7a4a; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .5; }
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Submitted Forms</h1>
            <p class="modern-page-subtitle">All forms you have generated and sent to the counselor</p>
        </div>
        <a href="{{ route('teacher.forms.index') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-file-earmark-plus"></i>
            <span>Generate New Form</span>
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Student name or form title..." value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Form Type</label>
            <select name="form_type" class="form-select" style="border-radius: 10px;">
                <option value="">All Form Types</option>
                <option value="confiscation-electronic" {{ request('form_type') == 'confiscation-electronic' ? 'selected' : '' }}>Confiscation (Electronic)</option>
                <option value="call-slip"               {{ request('form_type') == 'call-slip'               ? 'selected' : '' }}>Call Slip</option>
                <option value="risk-assessment"         {{ request('form_type') == 'risk-assessment'         ? 'selected' : '' }}>Risk Assessment</option>
                <option value="confiscation-prohibited" {{ request('form_type') == 'confiscation-prohibited' ? 'selected' : '' }}>Confiscation (Prohibited)</option>
                <option value="bag-search"              {{ request('form_type') == 'bag-search'              ? 'selected' : '' }}>Bag Search Plan</option>
                <option value="good-moral"              {{ request('form_type') == 'good-moral'              ? 'selected' : '' }}>Good Moral</option>
                <option value="home-visitation"         {{ request('form_type') == 'home-visitation'         ? 'selected' : '' }}>Home Visitation</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-select" style="border-radius: 10px;">
                <option value="">All Statuses</option>
                <option value="submitted"    {{ request('status') == 'submitted'    ? 'selected' : '' }}>Submitted</option>
                <option value="reviewed"     {{ request('status') == 'reviewed'     ? 'selected' : '' }}>Reviewed</option>
                <option value="acknowledged" {{ request('status') == 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>

{{-- Submissions list --}}
<div class="modern-card">
    <div class="p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="px-4 py-3 fw-semibold text-muted small">Form Type</th>
                        <th class="py-3 fw-semibold text-muted small">Student</th>
                        <th class="py-3 fw-semibold text-muted small table-hide-mobile">Date Sent</th>
                        <th class="py-3 fw-semibold text-muted small">Status</th>
                        <th class="py-3 fw-semibold text-muted small">Counselor Notes</th>
                        <th class="py-3 fw-semibold text-muted small">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold small" style="color:#1e7a4a;">{{ $submission->form_title }}</div>
                            </td>
                            <td class="py-3">
                                @if($submission->student_name)
                                    <div class="fw-semibold small">{{ $submission->student_name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $submission->grade_section }}</div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="py-3 table-hide-mobile small text-muted">
                                {{ $submission->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td class="py-3">
                                @php
                                    $badgeStyle = match($submission->status) {
                                        'submitted'    => 'background:#fef3c7;color:#92400e;border:1px solid #fbbf24',
                                        'reviewed'     => 'background:#eff6ff;color:#1e40af;border:1px solid #93c5fd',
                                        'acknowledged' => 'background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7',
                                        default        => 'background:#f1f5f9;color:#475569;border:1px solid #cbd5e1',
                                    };
                                @endphp
                                <span class="modern-badge" style="{{ $badgeStyle }}">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                            <td class="py-3 small text-muted">
                                {{ $submission->counselor_notes ? \Str::limit($submission->counselor_notes, 50) : '—' }}
                            </td>
                            <td class="py-3">
                                <div class="d-flex gap-1">
                                    <a href="{{ route('teacher.forms.submissions.show', $submission->id) }}"
                                       class="btn btn-sm py-1 px-2 text-white" style="font-size:.78rem;background:#1e7a4a;"><i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm py-1 px-2" style="font-size:.78rem;"
                                        onclick="confirmDelete('{{ route('teacher.forms.submissions.destroy', $submission->id) }}', '{{ addslashes($submission->form_title) }}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No submitted forms yet.
                                <a href="{{ route('teacher.forms.index') }}" style="color:#1e7a4a;">Generate one now.</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="px-4 py-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
            <small class="text-muted">
                @if($submissions->total() > 0)
                    Showing <strong>{{ $submissions->firstItem() }}–{{ $submissions->lastItem() }}</strong>
                    of <strong>{{ $submissions->total() }}</strong> submitted forms
                @else
                    No records found
                @endif
            </small>
            @if($submissions->hasPages())
                <div>{{ $submissions->onEachSide(1)->links() }}</div>
            @endif
        </div>
    </div>
</div>

{{-- Legend --}}
<div class="d-flex gap-3 mt-3 flex-wrap">
    <small class="text-muted"><span class="modern-badge" style="background:#fef3c7;color:#92400e;border:1px solid #fbbf24">Submitted</span> <span class="ms-1">Sent, awaiting counselor review</span></small>
    <small class="text-muted"><span class="modern-badge" style="background:#eff6ff;color:#1e40af;border:1px solid #93c5fd">Reviewed</span> <span class="ms-1">Counselor has reviewed it</span></small>
    <small class="text-muted"><span class="modern-badge" style="background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7">Acknowledged</span> <span class="ms-1">Counselor has acknowledged and acted on it</span></small>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="border-radius:20px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,0.18);">
            <div class="modal-body text-center p-4">
                <div class="mb-3">
                    <div style="width:60px;height:60px;background:rgba(239,68,68,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                        <i class="bi bi-trash3-fill text-danger fs-4"></i>
                    </div>
                </div>
                <h6 class="fw-bold mb-1">Delete Form?</h6>
                <p class="text-muted small mb-3">
                    <strong id="deleteFormTitle" class="text-dark"></strong><br>
                    This action cannot be undone.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-3">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(url, title) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteFormTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

@endsection
