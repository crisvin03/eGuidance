@extends('layouts.dashboard')

@section('title', 'Student Form Submissions')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
    .modern-page-header-compact { flex-direction: column !important; align-items: flex-start !important; gap: 1rem !important; }
    .modern-card { padding: 1rem !important; margin-bottom: 1rem !important; }
    .modern-stats-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 0.75rem !important; }
    
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
    
    div[style*="display: grid"][style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
    .table-responsive { font-size: 0.875rem !important; }
    .badge { font-size: 0.7rem !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-file-earmark-check-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Student Form Submissions</h1>
            <p class="modern-page-subtitle">Review and manage student form submissions</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-file-earmark-text"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $submissions->total() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total Forms</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\StudentFormSubmission::where('status', 'submitted')->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\StudentFormSubmission::where('status', 'approved')->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Approved</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-x-circle-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\StudentFormSubmission::where('status', 'rejected')->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Rejected</div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('counselor.student-forms.index') }}" class="filter-form" style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Form Type</label>
            <select class="form-select" name="type" style="border-radius: 10px;">
                <option value="">All Types</option>
                <option value="exit_survey" {{ request('type') == 'exit_survey' ? 'selected' : '' }}>Exit Survey (Annex B)</option>
                <option value="personal_inventory" {{ request('type') == 'personal_inventory' ? 'selected' : '' }}>Personal Inventory (Annex C)</option>
                <option value="clearance_return" {{ request('type') == 'clearance_return' ? 'selected' : '' }}>Clearance to Return (Annex D)</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select class="form-select" name="status" style="border-radius: 10px;">
                <option value="">All Status</option>
                <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search Student</label>
            <input type="text" class="form-control" name="search" placeholder="Student name or email" value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Submissions List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($submissions->isEmpty())
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-file-earmark-check"></i>
            </div>
            <h3 class="modern-empty-title">No form submissions found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['type', 'status', 'search']))
                    No submissions match your filter criteria. Try adjusting your filters.
                @else
                    No student form submissions have been received yet.
                @endif
            </p>
            @if(request()->hasAny(['type', 'status', 'search']))
                <a href="{{ route('counselor.student-forms.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @endif
        </div>
    @else
        <div class="modern-list">
            @foreach($submissions as $submission)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Submission Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Student Avatar -->
                            <div>
                                <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                    {{ strtoupper(substr($submission->student->name, 0, 2)) }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">{{ $submission->student->name }}</h3>
                                    
                                    <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;">
                                        <i class="bi bi-file-earmark-text"></i> {{ $submission->form_type_name }}
                                    </span>
                                    
                                    @if($submission->status == 'submitted')
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock-fill"></i> Submitted
                                        </span>
                                    @elseif($submission->status == 'reviewed')
                                        <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;">
                                            <i class="bi bi-eye-fill"></i> Reviewed
                                        </span>
                                    @elseif($submission->status == 'approved')
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill"></i> Approved
                                        </span>
                                    @else
                                        <span class="modern-badge" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; font-size: 0.75rem;">
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                                    <span>
                                        <i class="bi bi-envelope-fill"></i> 
                                        {{ $submission->student->email }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock"></i> 
                                        {{ $submission->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Actions -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('counselor.student-forms.show', $submission) }}" 
                               class="modern-btn modern-btn-primary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> Review
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($submissions->hasPages())
            <div style="margin-top: 1.5rem;">{{ $submissions->links() }}</div>
        @endif
    @endif
</div>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
    div[style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
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
</style>
@endsection
