@extends('layouts.dashboard')

@section('title', 'Assessment History')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--navy); margin: 0 0 0.5rem 0;">
                <i class="bi bi-clock-history me-2" style="color: var(--green);"></i>Assessment History
            </h1>
            <p style="color: var(--text-muted); margin: 0;">View your past mental health screenings</p>
        </div>
        <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
            <i class="bi bi-arrow-left"></i> Back to Mind Check
        </a>
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

<div class="row">
    <div class="col-lg-8">
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

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="modern-card mb-3" style="padding: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-bar-chart-fill me-2" style="color: var(--green);"></i>Your Statistics
            </h6>
            <div class="mb-3 pb-3" style="border-bottom: 1px solid #e5e7eb;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.8rem;">Total Assessments</small>
                        <h4 class="fw-bold mb-0" style="color: var(--green);">{{ $totalCount }}</h4>
                    </div>
                    <div class="modern-section-icon" style="width: 45px; height: 45px; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.85rem;">
                        <i class="bi bi-person-heart me-1"></i>HEADSS
                    </small>
                    <small class="fw-semibold">{{ $headssCount }}</small>
                </div>
                <div class="progress" style="height: 6px; border-radius: 6px; background: #e5e7eb;">
                    <div class="progress-bar" style="width: {{ $totalCount > 0 ? ($headssCount / $totalCount * 100) : 0 }}%; background: var(--green);"></div>
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.85rem;">
                        <i class="bi bi-activity me-1"></i>GAD-7
                    </small>
                    <small class="fw-semibold">{{ $gad7Count }}</small>
                </div>
                <div class="progress" style="height: 6px; border-radius: 6px; background: #e5e7eb;">
                    <div class="progress-bar" style="width: {{ $totalCount > 0 ? ($gad7Count / $totalCount * 100) : 0 }}%; background: var(--green);"></div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.85rem;">
                        <i class="bi bi-heart-pulse me-1"></i>PHQ-9
                    </small>
                    <small class="fw-semibold">{{ $phq9Count }}</small>
                </div>
                <div class="progress" style="height: 6px; border-radius: 6px; background: #e5e7eb;">
                    <div class="progress-bar" style="width: {{ $totalCount > 0 ? ($phq9Count / $totalCount * 100) : 0 }}%; background: var(--green);"></div>
                </div>
            </div>
        </div>

        @if($latestAssessment)
            <!-- Most Recent -->
            <div class="modern-card mb-3" style="padding: 1.5rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08));">
                <h6 class="fw-bold mb-3" style="color: var(--navy);">
                    <i class="bi bi-star-fill me-2" style="color: var(--green);"></i>Most Recent
                </h6>
                <div class="mb-2">
                    <small class="text-muted">{{ $latestAssessment->created_at->diffForHumans() }}</small>
                </div>
                <div class="fw-semibold mb-2" style="color: var(--green); font-size: 1.1rem;">
                    {{ strtoupper($latestAssessment->assessment_type) }}
                </div>
                <span class="badge" style="background: var(--green); color: white;">
                    <i class="bi bi-check-circle me-1"></i>Submitted
                </span>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="modern-card" style="padding: 1.5rem;">
            <h6 class="fw-bold mb-3" style="color: var(--navy);">
                <i class="bi bi-lightning-charge-fill me-2" style="color: var(--green);"></i>Quick Actions
            </h6>
            <div class="d-grid gap-2">
                <a href="{{ route('student.mind-check.headss') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-person-heart"></i> Take HEADSS
                </a>
                <a href="{{ route('student.mind-check.gad7') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-activity"></i> Take GAD-7
                </a>
                <a href="{{ route('student.mind-check.phq9') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-heart-pulse"></i> Take PHQ-9
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
