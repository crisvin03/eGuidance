@extends('layouts.dashboard')

@section('title', 'Mind Check')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Mind Check</h1>
            <p class="modern-page-subtitle">Something feels off? Let's check in with yourself.</p>
        </div>
    </div>
</div>

<!-- Disclaimer Alert -->
<div class="modern-alert modern-alert-warning mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: #d97706;">Important Notice</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted);">
            These self-screening tools <strong>do not provide a diagnosis</strong>. 
            Your responses help the CARE Team better understand your concerns and determine appropriate support.
        </p>
    </div>
</div>

<!-- Assessment Cards -->
<div class="modern-grid-3 mb-4" style="gap: 1.5rem;">
    <!-- HEADSS Assessment -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center;">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-heart"></i>
        </div>
        <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">HEADSS</h5>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Psychosocial Assessment</p>
        <p style="font-size: 0.9rem; color: var(--text-body); margin-bottom: 1.5rem; line-height: 1.5;">
            Explores your Home, Education, Activities, Drugs, Sexuality, and Suicide/Depression concerns.
        </p>
        <div style="margin-bottom: 1.25rem;">
            <small style="color: var(--text-muted);">
                <i class="bi bi-clock"></i>
                ~10-15 minutes
            </small>
        </div>
        <a href="{{ route('student.mind-check.headss') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Start Assessment</span>
        </a>
    </div>

    <!-- GAD-7 Assessment -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center;">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-emoji-frown"></i>
        </div>
        <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">GAD-7</h5>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Anxiety Screening</p>
        <p style="font-size: 0.9rem; color: var(--text-body); margin-bottom: 1.5rem; line-height: 1.5;">
            Measures anxiety levels through 7 questions about your feelings over the past 2 weeks.
        </p>
        <div style="margin-bottom: 1.25rem;">
            <small style="color: var(--text-muted);">
                <i class="bi bi-clock"></i>
                ~3-5 minutes
            </small>
        </div>
        <a href="{{ route('student.mind-check.gad7') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Start Screening</span>
        </a>
    </div>

    <!-- PHQ-9 Assessment -->
    <div class="modern-card" style="padding: 1.5rem; text-align: center;">
        <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-cloud-drizzle"></i>
        </div>
        <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">PHQ-9</h5>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Depression Screening</p>
        <p style="font-size: 0.9rem; color: var(--text-body); margin-bottom: 1.5rem; line-height: 1.5;">
            Assesses depression severity through 9 questions about your mood and behavior.
        </p>
        <div style="margin-bottom: 1.25rem;">
            <small style="color: var(--text-muted);">
                <i class="bi bi-clock"></i>
                ~3-5 minutes
            </small>
        </div>
        <a href="{{ route('student.mind-check.phq9') }}" 
           class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-arrow-right-circle"></i>
            <span>Start Screening</span>
        </a>
    </div>
</div>

<!-- Recent Assessments -->
@if($recentAssessments && $recentAssessments->count() > 0)
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <div class="modern-section-header">
        <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1.1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clock-history"></i>
        </div>
        <h2 class="modern-section-title" style="flex: 1; font-size: 1.15rem;">Recent Assessments</h2>
        <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
            View All
        </a>
    </div>
    
    <div class="modern-list">
        @foreach($recentAssessments as $assessment)
            <div class="modern-list-item" style="padding: 1rem 0;">
                <div style="display: flex; align-items: center; gap: 1rem; flex: 1;">
                    <div class="modern-section-icon" style="width: 40px; height: 40px; font-size: 1rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-file-earmark-medical"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 0.25rem;">{{ $assessment->assessment_name }}</div>
                        <small style="color: var(--text-muted); font-size: 0.85rem;">
                            <i class="bi bi-calendar3"></i>
                            {{ $assessment->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span class="modern-badge modern-badge-{{ $assessment->risk_level_color }}" style="font-size: 0.8rem;">
                        {{ $assessment->risk_level_text }}
                    </span>
                    <a href="{{ route('student.mind-check.results', $assessment->id) }}" 
                       class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                        <i class="bi bi-eye"></i>
                        <span>View</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Stats & Support -->
<div class="modern-grid-2" style="gap: 1.5rem; align-items: stretch;">
    <!-- Stats -->
    <div class="modern-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1.25rem;">Your Assessment Stats</h6>
        <div class="modern-grid-3" style="gap: 1rem; flex: 1; align-items: center;">
            <div style="text-align: center; padding: 1.25rem; border-radius: 12px; background: rgba(30, 122, 74, 0.08);">
                <div style="font-size: 2rem; font-weight: 800; color: var(--green); margin-bottom: 0.5rem;">{{ $assessmentCounts['headss'] ?? 0 }}</div>
                <small style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">HEADSS</small>
            </div>
            <div style="text-align: center; padding: 1.25rem; border-radius: 12px; background: rgba(30, 122, 74, 0.08);">
                <div style="font-size: 2rem; font-weight: 800; color: var(--green); margin-bottom: 0.5rem;">{{ $assessmentCounts['gad7'] ?? 0 }}</div>
                <small style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">GAD-7</small>
            </div>
            <div style="text-align: center; padding: 1.25rem; border-radius: 12px; background: rgba(30, 122, 74, 0.08);">
                <div style="font-size: 2rem; font-weight: 800; color: var(--green); margin-bottom: 0.5rem;">{{ $assessmentCounts['phq9'] ?? 0 }}</div>
                <small style="color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">PHQ-9</small>
            </div>
        </div>
    </div>

    <!-- Need Help -->
    <div class="modern-card" style="padding: 1.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(30, 122, 74, 0.04)); text-align: center; display: flex; flex-direction: column; justify-content: center;">
        <div style="margin-bottom: 1rem;">
            <i class="bi bi-people" style="font-size: 2.5rem; color: var(--green);"></i>
        </div>
        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Need to talk?</h6>
        <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">
            Connect with a counselor anytime.
        </p>
        <a href="{{ route('student.connect') }}" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-chat-dots"></i>
            <span>Connect Now</span>
        </a>
    </div>
</div>

<style>
/* Card hover effects */
.modern-grid-3 > .modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13, 45, 82, 0.15);
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .modern-grid-2 {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .modern-grid-3 {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
