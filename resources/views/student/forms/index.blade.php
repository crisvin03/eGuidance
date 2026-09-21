@extends('layouts.dashboard')

@section('title', 'My Forms')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-file-earmark-text-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Forms</h1>
            <p class="modern-page-subtitle">Submit and track your guidance forms</p>
        </div>
    </div>
</div>

<!-- Available Forms -->
<div class="modern-grid-3 mb-4" style="gap: 1.5rem;">
    <!-- Exit Survey -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
            <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div style="flex: 1;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Curriculum Exit Survey</h6>
                <small style="color: var(--text-muted); font-size: 0.85rem;">Annex B - Senior High Graduates</small>
            </div>
        </div>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5;">
            Required survey for all graduating Senior High School learners
        </p>
        <a href="{{ route('student.forms.show', 'exit-survey') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.25rem; font-size: 0.9rem;">
            <i class="bi bi-plus-circle"></i>
            <span>Fill Out Survey</span>
        </a>
    </div>

    <!-- Personal Inventory -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
            <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div style="flex: 1;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Personal Inventory</h6>
                <small style="color: var(--text-muted); font-size: 0.85rem;">Annex C</small>
            </div>
        </div>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5;">
            Personal information and background inventory
        </p>
        <a href="{{ route('student.forms.show', 'personal-inventory') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.25rem; font-size: 0.9rem;">
            <i class="bi bi-plus-circle"></i>
            <span>Fill Out Form</span>
        </a>
    </div>

    <!-- Clearance to Return -->
    <div class="modern-card" style="padding: 1.5rem;">
        <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1rem;">
            <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                <i class="bi bi-shield-check"></i>
            </div>
            <div style="flex: 1;">
                <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.25rem;">Reintegration Clearance</h6>
                <small style="color: var(--text-muted); font-size: 0.85rem;">Annex D</small>
            </div>
        </div>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; line-height: 1.5;">
            Form for students returning after suspension/leave
        </p>
        <a href="{{ route('student.forms.show', 'clearance-return') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.25rem; font-size: 0.9rem;">
            <i class="bi bi-plus-circle"></i>
            <span>Fill Out Form</span>
        </a>
    </div>
</div>

<!-- My Submissions -->
<div class="modern-card" style="padding: 1.5rem;">
    <div class="modern-section-header">
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
                You haven't submitted any forms yet. Choose a form above to get started.
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
                                {{ $submission->form_type_name }}
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
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="modern-badge modern-badge-{{ $submission->status_badge }}" style="font-size: 0.8rem;">
                            {{ ucfirst($submission->status) }}
                        </span>
                        <a href="{{ route('student.forms.view', $submission) }}" 
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
.modern-grid-3 > .modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modern-grid-3 {
        grid-template-columns: 1fr;
    }
    
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
}
</style>
@endsection
