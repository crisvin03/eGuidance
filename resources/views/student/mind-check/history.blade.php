@extends('layouts.dashboard')

@section('title', 'Assessment History')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title">Assessment History</h1>
            <p class="modern-page-subtitle">View your past mental health screenings</p>
        </div>
        <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Mind Check</span>
        </a>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4">
    <form method="GET" action="{{ route('student.mind-check.history') }}" class="row g-3">
        <div class="col-md-4">
            <label class="form-label fw-semibold" style="font-size: 0.875rem; color: #374151;">Assessment Type</label>
            <select name="type" class="form-select modern-input" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="headss" {{ request('type') === 'headss' ? 'selected' : '' }}>HEADSS</option>
                <option value="gad7" {{ request('type') === 'gad7' ? 'selected' : '' }}>GAD-7</option>
                <option value="phq9" {{ request('type') === 'phq9' ? 'selected' : '' }}>PHQ-9</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold" style="font-size: 0.875rem; color: #374151;">Risk Level</label>
            <select name="risk" class="form-select modern-input" onchange="this.form.submit()">
                <option value="">All Levels</option>
                <option value="low" {{ request('risk') === 'low' ? 'selected' : '' }}>Low/Minimal</option>
                <option value="mild" {{ request('risk') === 'mild' ? 'selected' : '' }}>Mild</option>
                <option value="moderate" {{ request('risk') === 'moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="moderately-high" {{ request('risk') === 'moderately-high' ? 'selected' : '' }}>Moderately High</option>
                <option value="high" {{ request('risk') === 'high' ? 'selected' : '' }}>High/Severe</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold" style="font-size: 0.875rem; color: #374151;">Date Range</label>
            <select name="period" class="form-select modern-input" onchange="this.form.submit()">
                <option value="">All Time</option>
                <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Last 30 Days</option>
                <option value="quarter" {{ request('period') === 'quarter' ? 'selected' : '' }}>Last 90 Days</option>
                <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Last Year</option>
            </select>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-lg-8">
        @if($assessments->count() > 0)
            <!-- Timeline -->
            <div class="position-relative">
                @foreach($assessments as $assessment)
                    <div class="modern-card mb-3">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Date Badge -->
                            <div class="text-center" style="min-width:70px;">
                                <div class="fw-bold" style="font-size:1.5rem;line-height:1.2;color:var(--green);">
                                    {{ $assessment->created_at->format('d') }}
                                </div>
                                <small class="text-muted">{{ $assessment->created_at->format('M Y') }}</small>
                            </div>

                            <!-- Content -->
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div>
                                        @if($assessment->assessment_type === 'headss')
                                            <h6 class="fw-bold mb-1" style="color: #111827;">
                                                <i class="bi bi-person-heart" style="color:var(--green);"></i>
                                                HEADSS Psychosocial Assessment
                                            </h6>
                                        @elseif($assessment->assessment_type === 'gad7')
                                            <h6 class="fw-bold mb-1" style="color: #111827;">
                                                <i class="bi bi-activity" style="color:var(--green);"></i>
                                                GAD-7 Anxiety Screening
                                            </h6>
                                        @elseif($assessment->assessment_type === 'phq9')
                                            <h6 class="fw-bold mb-1" style="color: #111827;">
                                                <i class="bi bi-heart-pulse" style="color:var(--green);"></i>
                                                PHQ-9 Depression Screening
                                            </h6>
                                        @endif
                                        <small class="text-muted">{{ $assessment->created_at->format('g:i A') }}</small>
                                    </div>
                                    
                                    <!-- Risk Badge -->
                                    <span class="modern-badge {{ 
                                        $assessment->risk_level === 'low' ? 'modern-badge-success' :
                                        ($assessment->risk_level === 'mild' ? 'modern-badge-warning' :
                                        'modern-badge-danger') }}">
                                        {{ ucwords(str_replace('-', ' ', $assessment->risk_level)) }}
                                    </span>
                                </div>

                                @if($assessment->assessment_type !== 'headss')
                                    <div class="d-flex align-items-center gap-4 mb-3">
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.75rem;">Score</small>
                                            <span class="fw-bold" style="color:var(--green);font-size:1.1rem;">
                                                {{ $assessment->score }}<small class="text-muted">/{{ $assessment->assessment_type === 'gad7' ? '21' : '27' }}</small>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block mb-1" style="font-size: 0.75rem;">Severity</small>
                                            <div class="progress" style="height:6px;border-radius:6px;background:#e5e7eb;">
                                                <div class="progress-bar" role="progressbar" 
                                                     style="width:{{ ($assessment->score / ($assessment->assessment_type === 'gad7' ? 21 : 27)) * 100 }}%;background:var(--green);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted small mb-3">Comprehensive psychosocial evaluation covering home, education, activities, relationships, and mental health.</p>
                                @endif

                                <a href="{{ route('student.mind-check.results', $assessment->id) }}" 
                                   class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    <i class="bi bi-eye"></i>
                                    <span>View Details</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $assessments->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="modern-card">
                <div class="modern-empty-state">
                    <div class="modern-empty-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h6 class="modern-empty-title">No Assessments Yet</h6>
                    <p class="modern-empty-text">
                        @if(request()->has('type') || request()->has('risk') || request()->has('period'))
                            No assessments match your filter criteria.
                        @else
                            You haven't completed any mental health assessments yet.
                        @endif
                    </p>
                    @if(request()->has('type') || request()->has('risk') || request()->has('period'))
                        <a href="{{ route('student.mind-check.history') }}" class="modern-btn modern-btn-secondary">
                            <i class="bi bi-x-circle"></i>
                            <span>Clear Filters</span>
                        </a>
                    @else
                        <a href="{{ route('student.mind-check') }}" class="modern-btn modern-btn-primary">
                            <i class="bi bi-plus-circle"></i>
                            <span>Take an Assessment</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Statistics -->
        <div class="modern-card mb-3">
            <h6 class="fw-bold mb-3" style="color: #111827;">Your Statistics</h6>
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #e5e7eb;">
                <div>
                    <small class="text-muted d-block" style="font-size: 0.8rem;">Total Assessments</small>
                    <h5 class="fw-bold mb-0" style="color: var(--green);">{{ $totalCount }}</h5>
                </div>
                <div class="modern-section-icon" style="width: 40px; height: 40px;">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.8rem;">HEADSS</small>
                    <small class="fw-semibold">{{ $headssCount }}</small>
                </div>
                <div class="progress" style="height:4px;border-radius:4px;background:#e5e7eb;">
                    <div class="progress-bar" style="width:{{ $totalCount > 0 ? ($headssCount / $totalCount * 100) : 0 }}%;background:var(--green);"></div>
                </div>
            </div>
            <div class="mb-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.8rem;">GAD-7</small>
                    <small class="fw-semibold">{{ $gad7Count }}</small>
                </div>
                <div class="progress" style="height:4px;border-radius:4px;background:#e5e7eb;">
                    <div class="progress-bar" style="width:{{ $totalCount > 0 ? ($gad7Count / $totalCount * 100) : 0 }}%;background:var(--green);"></div>
                </div>
            </div>
            <div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted" style="font-size: 0.8rem;">PHQ-9</small>
                    <small class="fw-semibold">{{ $phq9Count }}</small>
                </div>
                <div class="progress" style="height:4px;border-radius:4px;background:#e5e7eb;">
                    <div class="progress-bar" style="width:{{ $totalCount > 0 ? ($phq9Count / $totalCount * 100) : 0 }}%;background:var(--green);"></div>
                </div>
            </div>
        </div>

        @if($latestAssessment)
            <!-- Most Recent -->
            <div class="modern-card mb-3" style="background: linear-gradient(135deg, rgba(30, 122, 74, 0.08), rgba(20, 94, 56, 0.08));">
                <h6 class="fw-bold mb-3" style="color: #111827;">Most Recent</h6>
                <div class="mb-2">
                    <small class="text-muted">{{ $latestAssessment->created_at->diffForHumans() }}</small>
                </div>
                <div class="fw-semibold mb-2" style="color: var(--green);">{{ strtoupper($latestAssessment->assessment_type) }}</div>
                <span class="modern-badge {{ 
                    $latestAssessment->risk_level === 'low' ? 'modern-badge-success' :
                    ($latestAssessment->risk_level === 'mild' ? 'modern-badge-warning' :
                    'modern-badge-danger') }}">
                    {{ ucwords(str_replace('-', ' ', $latestAssessment->risk_level)) }}
                </span>
                <div class="mt-3">
                    <a href="{{ route('student.mind-check.results', $latestAssessment->id) }}" 
                       class="modern-btn modern-btn-primary" style="width: 100%; justify-content: center;">
                        <i class="bi bi-eye"></i>
                        <span>View Results</span>
                    </a>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="modern-card">
            <h6 class="fw-bold mb-3" style="color: #111827;">Quick Actions</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('student.mind-check.headss') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-person-heart"></i>
                    <span>Take HEADSS</span>
                </a>
                <a href="{{ route('student.mind-check.gad7') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-activity"></i>
                    <span>Take GAD-7</span>
                </a>
                <a href="{{ route('student.mind-check.phq9') }}" class="modern-btn modern-btn-secondary" style="justify-content: flex-start;">
                    <i class="bi bi-heart-pulse"></i>
                    <span>Take PHQ-9</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
