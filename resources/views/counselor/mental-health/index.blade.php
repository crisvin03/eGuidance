@extends('layouts.dashboard')

@section('title', 'Mental Health Assessments')

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
    .modern-btn { width: 100% !important; }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-heart-pulse-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Mental Health Assessments</h1>
            <p class="modern-page-subtitle">View and manage student mental health screening submissions</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; margin-bottom: 1.5rem;">
    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clipboard2-pulse"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ $assessments->total() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Total</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\MentalHealthAssessment::whereIn('risk_level', ['high', 'moderately-high'])->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">High Risk</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\MentalHealthAssessment::where('follow_up_scheduled', true)->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Scheduled</div>
        </div>
    </div>

    <div class="modern-card" style="padding: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <div class="modern-section-icon modern-page-icon-green" style="width: 48px; height: 48px; font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--green); line-height: 1; margin-bottom: 0.25rem;">{{ \App\Models\MentalHealthAssessment::where('follow_up_scheduled', false)->count() }}</div>
            <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pending</div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="modern-card" style="padding: 1.5rem; margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('counselor.mental-health.index') }}" class="filter-form" style="display: grid; grid-template-columns: repeat(4, 1fr) auto; gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Assessment Type</label>
            <select class="form-select" name="type" style="border-radius: 10px;">
                <option value="">All Types</option>
                <option value="headss" {{ request('type') == 'headss' ? 'selected' : '' }}>HEADSS Assessment</option>
                <option value="gad7" {{ request('type') == 'gad7' ? 'selected' : '' }}>GAD-7 (Anxiety)</option>
                <option value="phq9" {{ request('type') == 'phq9' ? 'selected' : '' }}>PHQ-9 (Depression)</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Risk Level</label>
            <select class="form-select" name="risk_level" style="border-radius: 10px;">
                <option value="">All Levels</option>
                <option value="low" {{ request('risk_level') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="mild" {{ request('risk_level') == 'mild' ? 'selected' : '' }}>Mild</option>
                <option value="moderate" {{ request('risk_level') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="moderately-high" {{ request('risk_level') == 'moderately-high' ? 'selected' : '' }}>Moderately High</option>
                <option value="high" {{ request('risk_level') == 'high' ? 'selected' : '' }}>High Risk</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Follow-up Status</label>
            <select class="form-select" name="follow_up" style="border-radius: 10px;">
                <option value="">All</option>
                <option value="scheduled" {{ request('follow_up') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="pending" {{ request('follow_up') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--navy); margin-bottom: 0.5rem;">Search Student</label>
            <input type="text" class="form-control" name="search" placeholder="Name or email" value="{{ request('search') }}" style="border-radius: 10px;">
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem; white-space: nowrap;">
                <i class="bi bi-funnel-fill"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Assessments List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($assessments->isEmpty())
        <div class="modern-empty-state" style="padding: 3rem 1.5rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2rem;">
                <i class="bi bi-clipboard2-pulse"></i>
            </div>
            <h3 class="modern-empty-title">No assessments found</h3>
            <p class="modern-empty-text">
                @if(request()->hasAny(['type', 'risk_level', 'follow_up', 'search']))
                    No assessments match your filter criteria. Try adjusting your filters.
                @else
                    No mental health assessments have been submitted yet.
                @endif
            </p>
            @if(request()->hasAny(['type', 'risk_level', 'follow_up', 'search']))
                <a href="{{ route('counselor.mental-health.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
            @endif
        </div>
    @else
        <div class="modern-list">
            @foreach($assessments as $assessment)
                <div class="modern-list-item" style="padding: 1.25rem; border-bottom: 1px solid #e5e7eb; display: block;">
                    <div style="display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start;">
                        <!-- Left: Assessment Info -->
                        <div style="display: flex; gap: 1rem;">
                            <!-- Student Avatar -->
                            <div>
                                <div class="modern-section-icon" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--green), var(--green-dark)); color: white; font-size: 0.9rem; font-weight: 700;">
                                    {{ strtoupper(substr($assessment->user->name, 0, 2)) }}
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; flex-wrap: wrap;">
                                    <h3 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin: 0;">{{ $assessment->user->name }}</h3>
                                    
                                    <span class="modern-badge modern-badge-info" style="font-size: 0.75rem;">
                                        <i class="bi bi-clipboard2-pulse"></i> {{ $assessment->assessment_name }}
                                    </span>
                                    
                                    <span class="modern-badge bg-{{ $assessment->risk_level_color }}" style="font-size: 0.75rem;">
                                        {{ $assessment->risk_level_text }}
                                    </span>
                                    
                                    @if($assessment->follow_up_scheduled)
                                        <span class="modern-badge modern-badge-success" style="font-size: 0.75rem;">
                                            <i class="bi bi-check-circle-fill"></i> Follow-up: {{ $assessment->follow_up_date?->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="modern-badge modern-badge-warning" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock-fill"></i> Pending Follow-up
                                        </span>
                                    @endif
                                </div>
                                
                                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.875rem; color: var(--text-muted);">
                                    <span>
                                        <i class="bi bi-envelope-fill"></i> 
                                        {{ $assessment->user->email }}
                                    </span>
                                    <span style="font-weight: 600; color: var(--green);">
                                        <i class="bi bi-bar-chart-fill"></i> 
                                        Score: {{ $assessment->score ?? 'N/A' }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock"></i> 
                                        {{ $assessment->created_at->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Actions -->
                        <div style="display: flex; gap: 0.5rem; flex-shrink: 0;">
                            <a href="{{ route('counselor.mental-health.show', $assessment) }}" 
                               class="modern-btn modern-btn-primary" 
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; white-space: nowrap;">
                                <i class="bi bi-eye"></i> View Details
                            </a>
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
.bg-success { background: rgba(34, 197, 94, 0.1) !important; color: #16a34a !important; }
.bg-warning { background: rgba(234, 179, 8, 0.1) !important; color: #ca8a04 !important; }
.bg-danger { background: rgba(239, 68, 68, 0.1) !important; color: #dc2626 !important; }
.bg-info { background: rgba(59, 130, 246, 0.1) !important; color: #2563eb !important; }

@media (max-width: 1200px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(4, 1fr)"],
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
