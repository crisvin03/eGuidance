@extends('layouts.dashboard')

@section('title', 'Assessment History')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clock-history"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Assessment History</h1>
            <p class="modern-page-subtitle">View your past mental health screenings</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('student.mind-check.history') }}" class="row g-3">
        <div class="col-md-3">
            <label class="form-label fw-semibold" style="font-size: 0.875rem; color: var(--navy);">
                <i class="bi bi-filter me-1"></i>Assessment Type
            </label>
            <select name="type" class="form-select" onchange="this.form.submit()" style="border-radius: 10px;">
                <option value="">All Types</option>
                <option value="headss" {{ request('type') === 'headss' ? 'selected' : '' }}>HEADSS</option>
                <option value="gad7" {{ request('type') === 'gad7' ? 'selected' : '' }}>GAD-7</option>
                <option value="phq9" {{ request('type') === 'phq9' ? 'selected' : '' }}>PHQ-9</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold" style="font-size: 0.875rem; color: var(--navy);">
                <i class="bi bi-calendar-range me-1"></i>Date Range
            </label>
            <select name="period" class="form-select" onchange="this.form.submit()" style="border-radius: 10px;">
                <option value="">All Time</option>
                <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="quarter" {{ request('period') === 'quarter' ? 'selected' : '' }}>Last 90 Days</option>
                <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Last Year</option>
            </select>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            @if(request()->hasAny(['type', 'period']))
                <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-clipboard2-pulse"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalCount }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-person-heart"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $headssCount }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">HEADSS</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-activity"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $gad7Count }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">GAD-7</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-heart-pulse"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $phq9Count }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">PHQ-9</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        @if($assessments->count() > 0)
            @foreach($assessments as $assessment)
                <div class="modern-card mb-3" style="padding: 1.5rem;">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <!-- Date Badge -->
                        <div class="text-center" style="min-width: 70px;">
                            <div class="fw-bold" style="font-size: 1.75rem; line-height: 1; color: var(--green);">
                                {{ $assessment->created_at->format('d') }}
                            </div>
                            <small class="text-muted" style="font-size: 0.8rem;">{{ $assessment->created_at->format('M Y') }}</small>
                        </div>

                        <!-- Content -->
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: start; gap: 1rem; margin-bottom: 0.75rem;">
                                <div>
                                    @if($assessment->assessment_type === 'headss')
                                        <h6 class="fw-bold mb-1" style="color: var(--navy); font-size: 1rem;">
                                            <i class="bi bi-person-heart me-1" style="color: var(--green);"></i>
                                            HEADSS Psychosocial Assessment
                                        </h6>
                                    @elseif($assessment->assessment_type === 'gad7')
                                        <h6 class="fw-bold mb-1" style="color: var(--navy); font-size: 1rem;">
                                            <i class="bi bi-activity me-1" style="color: var(--green);"></i>
                                            GAD-7 Anxiety Screening
                                        </h6>
                                    @elseif($assessment->assessment_type === 'phq9')
                                        <h6 class="fw-bold mb-1" style="color: var(--navy); font-size: 1rem;">
                                            <i class="bi bi-heart-pulse me-1" style="color: var(--green);"></i>
                                            PHQ-9 Depression Screening
                                        </h6>
                                    @endif
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>{{ $assessment->created_at->format('g:i A') }}
                                    </small>
                                </div>
                                
                                <span class="badge" style="background: var(--green); color: white; font-size: 0.8rem; padding: 0.35rem 0.75rem;">
                                    <i class="bi bi-check-circle me-1"></i>Submitted
                                </span>
                            </div>

                            <p class="text-muted small mb-0" style="font-size: 0.875rem;">
                                @if($assessment->assessment_type !== 'headss')
                                    Submitted {{ $assessment->created_at->diffForHumans() }} - Your responses are being reviewed by the CARE Team
                                @else
                                    Comprehensive psychosocial evaluation - Submitted {{ $assessment->created_at->diffForHumans() }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            @if($assessments->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $assessments->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="modern-card" style="padding: 3rem 2rem; text-align: center;">
                <div class="modern-empty-icon mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clipboard-data"></i>
                </div>
                <h6 class="fw-bold mb-2" style="color: var(--navy);">No Assessments Yet</h6>
                <p class="text-muted mb-3" style="font-size: 0.9rem;">
                    @if(request()->has('type') || request()->has('period'))
                        No assessments match your filter criteria.
                    @else
                        You haven't completed any mental health assessments yet.
                    @endif
                </p>
                @if(request()->has('type') || request()->has('period'))
                    <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                @else
                    <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary">
                        <i class="bi bi-plus-circle"></i> Take an Assessment
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
