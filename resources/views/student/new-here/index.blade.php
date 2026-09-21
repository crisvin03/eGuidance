@extends('layouts.dashboard')

@section('title', 'New Here? Let\'s Get Started')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-plus-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">New here? Let's get you sorted. 👋</h1>
            <p class="modern-page-subtitle">Complete your initial guidance assessment</p>
        </div>
    </div>
</div>

<!-- Info Card -->
<div class="modern-card mb-4" style="padding: 1.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08)); border-left: 4px solid var(--green);">
    <h6 class="fw-bold mb-3" style="color: #111827; font-size: 1rem;">
        <i class="bi bi-info-circle-fill me-2" style="color: var(--green);"></i>This section is for:
    </h6>
    <ul class="mb-0" style="color: #374151; line-height: 2; font-size: 0.9rem;">
        <li>🆕 <strong>New Enrollees</strong></li>
        <li>🔄 <strong>Transferees</strong></li>
        <li>📋 <strong>Students required to undergo initial guidance assessment</strong></li>
    </ul>
</div>

<!-- Process Steps -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <h6 class="fw-bold mb-3" style="color: #111827; font-size: 1rem;">
        <i class="bi bi-list-check me-2" style="color: var(--green);"></i>What happens here?
    </h6>
    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
            <div class="p-3 rounded h-100 d-flex flex-column" style="background: rgba(30, 122, 74, 0.05); border: 2px solid rgba(30, 122, 74, 0.15);">
                <div class="d-flex align-items-start gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: var(--green); color: white; font-weight: 700; font-size: 0.85rem;">1</div>
                    <strong style="color: #111827; font-size: 0.9rem; line-height: 1.3;">Fill Out Form</strong>
                </div>
                <small class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">Complete your basic information (Annex C)</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="p-3 rounded h-100 d-flex flex-column" style="background: rgba(30, 122, 74, 0.05); border: 2px solid rgba(30, 122, 74, 0.15);">
                <div class="d-flex align-items-start gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: var(--green); color: white; font-weight: 700; font-size: 0.85rem;">2</div>
                    <strong style="color: #111827; font-size: 0.9rem; line-height: 1.3;">Submit Assessment</strong>
                </div>
                <small class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">Submit enrollment assessment to guidance counselor</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="p-3 rounded h-100 d-flex flex-column" style="background: rgba(30, 122, 74, 0.05); border: 2px solid rgba(30, 122, 74, 0.15);">
                <div class="d-flex align-items-start gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: var(--green); color: white; font-weight: 700; font-size: 0.85rem;">3</div>
                    <strong style="color: #111827; font-size: 0.9rem; line-height: 1.3;">Assessment & Review</strong>
                </div>
                <small class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">Guidance counselor reviews your submission</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="p-3 rounded h-100 d-flex flex-column" style="background: rgba(30, 122, 74, 0.05); border: 2px solid rgba(30, 122, 74, 0.15);">
                <div class="d-flex align-items-start gap-2 mb-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; background: var(--green); color: white; font-weight: 700; font-size: 0.85rem;">4</div>
                    <strong style="color: #111827; font-size: 0.9rem; line-height: 1.3;">Get Clearance</strong>
                </div>
                <small class="text-muted" style="font-size: 0.85rem; line-height: 1.4;">Secure your clearance or approval</small>
            </div>
        </div>
    </div>
</div>

<!-- Reintegration Clearance Form Card -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-shield-check"></i>
        </div>
        <div style="flex: 1;">
            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Learner Reintegration Clearance</h6>
            <small style="color: var(--text-muted); font-size: 0.85rem;">For Return to Regular Classroom Participation</small>
        </div>
    </div>
    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5;">
        Complete this form if you're returning after intervention, suspension, or require initial assessment for enrollment.
    </p>
    <a href="{{ route('student.new-here.form') }}" 
       class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.25rem; font-size: 0.9rem; justify-content: center;">
        <i class="bi bi-pencil-square"></i>
        <span>Fill Out Clearance Form</span>
    </a>
</div>

<!-- My Submissions -->
<div class="modern-card" style="padding: 1.5rem;">
    <div class="modern-section-header" style="margin-bottom: 1.5rem;">
        <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-file-earmark-check"></i>
        </div>
        <h2 class="modern-section-title" style="font-size: 1.15rem;">My Submissions</h2>
    </div>
    
    @if($submissions->isEmpty())
        <div class="modern-empty-state" style="padding: 3rem 2rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="modern-empty-title" style="font-size: 1.15rem;">No Submissions Yet</h3>
            <p class="modern-empty-text" style="font-size: 0.95rem;">
                You haven't submitted any clearance forms yet. Fill out the form above to get started.
            </p>
        </div>
    @else
        <div class="modern-list">
            @foreach($submissions as $submission)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                        <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1rem; background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(99, 102, 241, 0.08)); color: #6366f1;">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">
                                Learner Reintegration Clearance
                            </div>
                            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; font-size: 0.85rem; color: var(--text-muted);">
                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    {{ $submission->created_at->format('M d, Y') }}
                                </span>
                                <span>
                                    <i class="bi bi-clock"></i>
                                    {{ $submission->created_at->format('h:i A') }}
                                </span>
                                @if($submission->reviewer)
                                <span>
                                    <i class="bi bi-person-check"></i>
                                    Reviewed by {{ $submission->reviewer->name }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($submission->status === 'submitted')
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;">Pending Review</span>
                        @elseif($submission->status === 'approved')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;">Approved</span>
                        @elseif($submission->status === 'reviewed')
                            <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;">Reviewed</span>
                        @else
                            <span class="modern-badge modern-badge-danger" style="font-size: 0.8rem;">{{ ucfirst($submission->status) }}</span>
                        @endif
                        <a href="{{ route('student.new-here.view', $submission->id) }}" 
                           class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-eye"></i>
                            <span>View</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
/* Card hover effects */
.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.12);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    /* List item adjustments */
    .modern-list-item {
        flex-direction: column;
        align-items: stretch;
    }
    
    .modern-list-item > div:last-child {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        margin-top: 0.75rem;
        gap: 0.5rem;
    }
    
    .modern-list-item > div:last-child .modern-btn {
        width: 100%;
        justify-content: center;
    }
    
    .modern-page-header {
        padding: 1rem !important;
    }
}
</style>
@endsection
