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
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Assessment History</h1>
            <p class="modern-page-subtitle">View your past mental health screenings</p>
        </div>
        <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Mind Check</span>
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clipboard-check"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $totalCount }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-person-heart"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $headssCount }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">HEADSS</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-activity"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $gad7Count }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">GAD-7</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-heart-pulse"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $phq9Count }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">PHQ-9</div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('student.mind-check.history') }}" style="display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Assessment Type</label>
            <select name="type" class="form-select" style="border-radius: 10px;" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="headss" {{ request('type') === 'headss' ? 'selected' : '' }}>HEADSS</option>
                <option value="gad7" {{ request('type') === 'gad7' ? 'selected' : '' }}>GAD-7</option>
                <option value="phq9" {{ request('type') === 'phq9' ? 'selected' : '' }}>PHQ-9</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Date Range</label>
            <select name="period" class="form-select" style="border-radius: 10px;" onchange="this.form.submit()">
                <option value="">All Time</option>
                <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="quarter" {{ request('period') === 'quarter' ? 'selected' : '' }}>Last 90 Days</option>
                <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Last Year</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: end;">
            @if(request()->hasAny(['type', 'period']))
                <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                    <i class="bi bi-x-circle"></i> Clear
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Assessments List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($assessments->isEmpty())
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-clipboard-data"></i>
            </div>
            <h3 class="modern-empty-title">No Assessments Found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['type', 'period']))
                    No assessments match your filter criteria. Try adjusting your filters.
                @else
                    You haven't completed any mental health assessments yet.
                @endif
            </p>
            @if(request()->hasAny(['type', 'period']))
                <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @else
                <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-plus-circle"></i> Take an Assessment
                </a>
            @endif
        </div>
    @else
        <div class="modern-list">
            @foreach($assessments as $assessment)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; gap: 1rem; align-items: start;">
                        <!-- Icon -->
                        <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                            @if($assessment->assessment_type === 'headss')
                                <i class="bi bi-person-heart"></i>
                            @elseif($assessment->assessment_type === 'gad7')
                                <i class="bi bi-activity"></i>
                            @else
                                <i class="bi bi-heart-pulse"></i>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items-center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">
                                    @if($assessment->assessment_type === 'headss')
                                        HEADSS Psychosocial Assessment
                                    @elseif($assessment->assessment_type === 'gad7')
                                        GAD-7 Anxiety Screening
                                    @else
                                        PHQ-9 Depression Screening
                                    @endif
                                </h3>
                                
                                <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                    <i class="bi bi-check-circle-fill"></i> Submitted
                                </span>
                            </div>
                            
                            <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                                <span>
                                    <i class="bi bi-calendar-fill"></i> 
                                    {{ $assessment->created_at->format('M d, Y h:i A') }}
                                </span>
                                <span>
                                    <i class="bi bi-clock-fill"></i> 
                                    {{ $assessment->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($assessments->hasPages())
            <div style="margin-top: 1.5rem;">{{ $assessments->links() }}</div>
        @endif
    @endif
</div>

<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
    div[style*="grid-template-columns: repeat(3, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
    
    .modern-page-header-compact {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 1rem !important;
    }
    
    .modern-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
