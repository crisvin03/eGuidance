@extends('layouts.dashboard')
@section('title', 'Incident Reports')

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
    
    .modern-btn { width: 100% !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Incident Reports</h1>
            <p class="modern-page-subtitle">All incident reports you have submitted</p>
        </div>
        <a href="{{ route('teacher.incident-reports.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
            <i class="bi bi-plus-lg"></i> New Report
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Case no, student, grade..." value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select name="status" class="form-select" style="border-radius: 10px;">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="ongoing" {{ request('status')=='ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Urgency Level</label>
            <select name="urgency" class="form-select" style="border-radius: 10px;">
                <option value="">All Urgency Levels</option>
                <option value="low" {{ request('urgency')=='low' ? 'selected' : '' }}>Low</option>
                <option value="moderate" {{ request('urgency')=='moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="high" {{ request('urgency')=='high' ? 'selected' : '' }}>High</option>
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Incident Reports List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($reports->count() > 0)
        <div class="modern-list">
            @foreach($reports as $report)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Report Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Student Avatar -->
                            <div>
                                <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                    {{ strtoupper(substr($report->student_name, 0, 2)) }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--green); margin: 0;">{{ $report->case_number }}</h3>
                                    
                                    @if($report->urgency_level == 'high')
                                        <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.75rem;">
                                            <i class="bi bi-exclamation-circle-fill"></i> High Urgency
                                        </span>
                                    @elseif($report->urgency_level == 'moderate')
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;">
                                            <i class="bi bi-dash-circle-fill"></i> Moderate
                                        </span>
                                    @else
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill"></i> Low
                                        </span>
                                    @endif
                                    
                                    @if($report->status == 'pending')
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock-fill"></i> Pending
                                        </span>
                                    @elseif($report->status == 'ongoing')
                                        <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;">
                                            <i class="bi bi-arrow-repeat"></i> Ongoing
                                        </span>
                                    @else
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill"></i> Closed
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                                    <span>
                                        <i class="bi bi-person-fill"></i> 
                                        {{ $report->student_name }}
                                    </span>
                                    <span>
                                        <i class="bi bi-mortarboard-fill"></i> 
                                        {{ $report->grade_section }}
                                    </span>
                                    <span>
                                        <i class="bi bi-tag-fill"></i> 
                                        {{ $report->incident_category_label }}
                                    </span>
                                    <span>
                                        <i class="bi bi-calendar3"></i> 
                                        {{ $report->date_of_referral->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Actions -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('teacher.incident-reports.show', $report) }}" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> <span>View</span>
                            </a>
                            @if($report->status === 'pending')
                            <button type="button" class="modern-btn" 
                                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 0.5rem 1rem; font-size: 0.875rem;"
                                    onclick="confirmDelete(
                                        {{ $report->id }},
                                        '{{ $report->case_number }}',
                                        '{{ addslashes($report->student_name) }}',
                                        '{{ $report->date_of_referral->format('M d, Y') }}'
                                    )">
                                <i class="bi bi-trash"></i>
                            </button>
                            @else
                            <button type="button" class="modern-btn" 
                                    style="background: rgba(100, 116, 139, 0.1); color: #64748b; padding: 0.5rem 1rem; font-size: 0.875rem; opacity: 0.5; cursor: not-allowed;"
                                    title="Cannot delete — report is {{ $report->status }}" disabled>
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($reports->hasPages())
            <div style="margin-top: 1.5rem;">{{ $reports->links() }}</div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <h3 class="modern-empty-title">No incident reports found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['search', 'status', 'urgency']))
                    No reports match your filter criteria. Try adjusting your filters.
                @else
                    You haven't submitted any incident reports yet.
                @endif
            </p>
            @if(request()->hasAny(['search', 'status', 'urgency']))
                <a href="{{ route('teacher.incident-reports.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; margin-top: 1rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @else
                <a href="{{ route('teacher.incident-reports.create') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; margin-top: 1rem;">
                    <i class="bi bi-plus-lg"></i> Submit Report
                </a>
            @endif
        </div>
    @endif
</div>

{{-- Professional Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content border-0" style="border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,.18);">

            {{-- Danger stripe --}}
            <div style="height:5px;border-radius:20px 20px 0 0;background:linear-gradient(90deg,#ef4444,#dc2626);"></div>

            <div class="modal-body p-4">
                {{-- Icon --}}
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                         style="width:64px;height:64px;background:rgba(239,68,68,.1);">
                        <i class="bi bi-trash3-fill" style="font-size:1.6rem;color:#ef4444;"></i>
                    </div>
                    <h5 class="fw-bold mb-1" id="deleteModalLabel" style="color:#1e293b;">Delete Incident Report?</h5>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>

                {{-- Report details card --}}
                <div class="rounded-3 p-3 mb-4" style="background:#f8fafc;border:1px solid #e2e8f0;">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="fw-bold small" style="color:#1e7a4a;" id="del_case_no"></div>
                            <div class="fw-semibold" id="del_student" style="font-size:.95rem;color:#1e293b;"></div>
                        </div>
                        <span class="badge" style="background:#fef3c7;color:#92400e;border:1px solid #fbbf24;">Pending</span>
                    </div>
                    <div class="d-flex align-items-center gap-1 text-muted small">
                        <i class="bi bi-calendar3"></i>
                        <span id="del_date"></span>
                    </div>
                </div>

                <p class="small text-muted text-center mb-0">
                    Only <strong>pending</strong> reports can be deleted. Once deleted, the record and any attached files will be permanently removed.
                </p>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-secondary flex-fill" style="border-radius:10px;" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i> Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-fill">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100 fw-semibold" style="border-radius:10px;">
                        <i class="bi bi-trash3 me-1"></i> Yes, Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, caseNo, student, date) {
    document.getElementById('del_case_no').textContent  = caseNo;
    document.getElementById('del_student').textContent  = student;
    document.getElementById('del_date').textContent     = date;
    document.getElementById('deleteForm').action = '/teacher/incident-reports/' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: 1fr 1fr !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(3, 1fr)"],
    div[style*="grid-template-columns: 1fr auto"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-list-item > div {
        flex-direction: column;
    }
    
    .modern-list-item > div > div:last-child {
        width: 100%;
    }
    
    .modern-list-item > div > div:last-child > div {
        width: 100%;
        justify-content: stretch;
    }
    
    .modern-list-item > div > div:last-child button,
    .modern-list-item > div > div:last-child a {
        flex: 1;
    }
}

.pagination { margin: 0; gap: 3px; }
.pagination .page-link { border-radius: 8px !important; border: 1px solid #e2e8f0; color: #475569; font-size: 0.875rem; padding: 0.4rem 0.75rem; transition: all .2s; }
.pagination .page-link:hover { background: rgba(32,178,170,.1); border-color: #1e7a4a; color: #1e7a4a; }
.pagination .page-item.active .page-link { background: #1e7a4a; border-color: #1e7a4a; color: #fff; }
.pagination .page-item.disabled .page-link { opacity: .5; }
</style>

@endsection
