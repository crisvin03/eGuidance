@extends('layouts.dashboard')

@section('title', 'New Here?')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-plus-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">New Here?</h1>
            <p class="modern-page-subtitle">Welcome! Help us get to know you better.</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="modern-alert modern-alert-success mb-4">
        <div class="modern-alert-icon">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- Introduction Card -->
<div class="modern-alert modern-alert-info mb-4">
    <div class="modern-alert-icon">
        <i class="bi bi-info-circle-fill"></i>
    </div>
    <div>
        <h6 style="font-weight: 700; margin-bottom: 0.5rem; color: var(--green);">Personal Inventory Form (Annex C)</h6>
        <p style="margin: 0; font-size: 0.9rem; color: var(--text-muted); line-height: 1.6;">
            As a new student at Bulan High School, please complete the Personal Inventory Form to help our guidance team understand your background, interests, and support needs. All information will be kept confidential and used only by guidance counselors.
        </p>
    </div>
</div>

<!-- Submit Form Card -->
<div class="modern-card mb-4" style="padding: 1.5rem; text-align: center;">
    <div class="modern-section-icon" style="margin: 0 auto 1.25rem; width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
        <i class="bi bi-clipboard-check"></i>
    </div>
    <h5 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem;">Personal Inventory Form</h5>
    <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem;">Annex C</p>
    <p style="font-size: 0.9rem; color: var(--text-body); margin-bottom: 1.5rem; line-height: 1.5; padding: 0 1rem;">
        Share information about your personal background, family, educational history, interests, and support needs to help us support you better.
    </p>
    <div style="margin-bottom: 1.25rem;">
        <small style="color: var(--text-muted); display: block;">
            <i class="bi bi-clock"></i>
            ~10-15 minutes to complete
        </small>
    </div>
    <a href="{{ route('student.new-here.form') }}" class="modern-btn modern-btn-primary" style="padding: 0.875rem 1.5rem; font-size: 0.95rem; display: inline-flex; align-items: center; justify-content: center;">
        <i class="bi bi-pencil-square"></i>
        <span>Fill Out Form</span>
    </a>
</div>

<!-- Submission History -->
@if($submissions->count() > 0)
    <div class="modern-card" style="padding: 1.5rem;">
        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 1rem;">
            <i class="bi bi-clock-history me-2" style="font-size: 1.1rem;"></i>
            My Submissions
        </h6>

        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($submissions as $submission)
                <div style="padding: 1.25rem; border: 1px solid rgba(30, 122, 74, 0.12); border-radius: 14px; background: rgba(255, 255, 255, 0.5);">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="bi bi-file-earmark-text" style="color: var(--green); font-size: 1.1rem;"></i>
                                <h6 style="font-size: 0.95rem; font-weight: 700; color: var(--navy); margin: 0;">{{ $submission->form_title }}</h6>
                            </div>
                            <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0;">
                                <i class="bi bi-calendar3"></i>
                                Submitted {{ $submission->created_at->format('M d, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            @if($submission->status === 'submitted')
                                <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;">Pending Review</span>
                            @elseif($submission->status === 'reviewed')
                                <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;">Reviewed</span>
                            @elseif($submission->status === 'requires_action')
                                <span class="modern-badge modern-badge-danger" style="font-size: 0.8rem;">Action Required</span>
                            @endif
                            <a href="{{ route('student.new-here.view', $submission->id) }}" 
                               class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="bi bi-eye"></i>
                                <span>View</span>
                            </a>
                        </div>
                    </div>

                    @if($submission->counselor_notes)
                        <div class="modern-alert" style="margin-top: 1rem; background: rgba(59, 130, 246, 0.08); border-left: 4px solid #3b82f6;">
                            <div style="display: flex; align-items: start; gap: 0.75rem;">
                                <i class="bi bi-chat-left-text-fill" style="font-size: 1rem; color: #3b82f6; flex-shrink: 0;"></i>
                                <div>
                                    <strong style="font-size: 0.85rem; color: #3b82f6;">Counselor's Note:</strong>
                                    <p style="font-size: 0.85rem; color: var(--text-muted); margin: 0.25rem 0 0;">{{ $submission->counselor_notes }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="modern-card mb-4" style="padding: 2rem 1rem; text-align: center;">
        <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 0.5rem;"></i>
        <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 1rem 0 0.5rem;">No Submissions Yet</h6>
        <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0; line-height: 1.5; padding: 0 1rem;">Click "Fill Out Form" above to submit your first Personal Inventory form.</p>
    </div>
@endif

<style>
@media (max-width: 768px) {
    .modern-card {
        padding: 1rem !important;
    }
    
    .modern-page-header {
        padding: 1rem !important;
    }
    
    .modern-page-title {
        font-size: 1.25rem !important;
    }
    
    .modern-page-subtitle {
        font-size: 0.85rem !important;
    }
}
</style>
@endsection
