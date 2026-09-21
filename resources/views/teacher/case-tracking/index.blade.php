@extends('layouts.dashboard')
@section('title', 'Case Tracking')

@section('content')
@include('student.partials.modern-styles')

<style>
@media (max-width: 768px) {
    .modern-page-header { padding: 1rem !important; }
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
    .filter-form .modern-btn {
        width: 100% !important;
        border-radius: 0.5rem !important;
    }
    
    .btn span:not([class*="bi"]) { display: none !important; }
    .btn i.bi { margin: 0 !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clipboard-check-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Case Tracking</h1>
            <p class="modern-page-subtitle">Monitor the status of your submitted incident reports and referrals</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" class="filter-form" style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by case/ref no, student name..." value="{{ request('search') }}" style="border-radius: 10px;">
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
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>
<!-- Incident Reports -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <h6 class="fw-bold mb-3" style="font-size: 1rem; color: var(--navy);">
        <i class="bi bi-file-earmark-text me-2" style="color: var(--green);"></i>Incident Reports
    </h6>
    
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
                                    @if($report->counselor)
                                        <span>
                                            <i class="bi bi-person-badge"></i> 
                                            {{ $report->counselor->name }}
                                        </span>
                                    @endif
                                    <span>
                                        <i class="bi bi-clock-history"></i> 
                                        {{ $report->updated_at->format('M d, Y') }}
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
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="modern-empty-title">No incident reports found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['search', 'status']))
                    No reports match your filter criteria.
                @else
                    You haven't submitted any incident reports yet.
                @endif
            </p>
        </div>
    @endif
</div>
<!-- Student Referrals -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <h6 class="fw-bold mb-3" style="font-size: 1rem; color: var(--navy);">
        <i class="bi bi-person-check me-2" style="color: var(--green);"></i>Student Referrals
    </h6>
    
    @if($referrals->count() > 0)
        <div class="modern-list">
            @foreach($referrals as $referral)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Referral Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Student Avatar -->
                            <div>
                                <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                    {{ strtoupper(substr($referral->student_name, 0, 2)) }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--green); margin: 0;">{{ $referral->referral_number }}</h3>
                                    
                                    @if($referral->status == 'pending')
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock-fill"></i> Pending
                                        </span>
                                    @elseif($referral->status == 'ongoing')
                                        <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;">
                                            <i class="bi bi-arrow-repeat"></i> Ongoing
                                        </span>
                                    @else
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill"></i> Closed
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                                    <span>
                                        <i class="bi bi-person-fill"></i> 
                                        {{ $referral->student_name }}
                                    </span>
                                    <span>
                                        <i class="bi bi-mortarboard-fill"></i> 
                                        {{ $referral->grade_section }}
                                    </span>
                                    @if($referral->counselor)
                                        <span>
                                            <i class="bi bi-person-badge"></i> 
                                            {{ $referral->counselor->name }}
                                        </span>
                                    @endif
                                    <span>
                                        <i class="bi bi-clock-history"></i> 
                                        {{ $referral->updated_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Actions -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('teacher.referrals.show', $referral) }}" 
                               class="modern-btn modern-btn-secondary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> <span>View</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($referrals->hasPages())
            <div style="margin-top: 1.5rem;">{{ $referrals->links() }}</div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="modern-empty-title">No referrals found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['search', 'status']))
                    No referrals match your filter criteria.
                @else
                    You haven't submitted any student referrals yet.
                @endif
            </p>
        </div>
    @endif
</div>

<!-- Confidentiality Notice -->
<div class="modern-card" style="padding: 1.25rem; background: rgba(100, 116, 139, 0.06); border-left: 3px solid #64748b;">
    <div style="display: flex; gap: 0.75rem; align-items: start;">
        <i class="bi bi-shield-lock" style="font-size: 1.25rem; color: #64748b; flex-shrink: 0;"></i>
        <div>
            <h6 class="fw-bold mb-1" style="font-size: 0.875rem; color: var(--navy);">Confidentiality Notice</h6>
            <p class="mb-0" style="font-size: 0.8rem; color: #6b7280; line-height: 1.6;">
                You can only view the status, assigned counselor, and last update of your submitted cases. Detailed counseling session notes are restricted to maintain student confidentiality.
            </p>
        </div>
    </div>
</div>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: 2fr 1fr auto"] {
        grid-template-columns: 1fr 1fr auto !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: 2fr 1fr auto"],
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
