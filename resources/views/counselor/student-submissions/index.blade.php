@extends('layouts.dashboard')

@section('title', 'Student Submissions Review')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-palette-fill"></i>
        </div>
        <div>
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Student Submissions Review</h1>
            <p class="modern-page-subtitle">Review and moderate student creative works</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('counselor.student-submissions.index') }}" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label class="modern-form-label">Search Submissions</label>
            <input type="text" class="form-control modern-form-control" name="search" value="{{ request('search') }}" placeholder="Search by title, student name...">
        </div>
        
        <div style="min-width: 150px;">
            <label class="modern-form-label">Type</label>
            <select class="form-control modern-form-control" name="type">
                <option value="">All Types</option>
                <option value="poetry" {{ request('type') === 'poetry' ? 'selected' : '' }}>Poetry</option>
                <option value="artwork" {{ request('type') === 'artwork' ? 'selected' : '' }}>Artwork</option>
                <option value="photography" {{ request('type') === 'photography' ? 'selected' : '' }}>Photography</option>
            </select>
        </div>
        
        <div style="min-width: 150px;">
            <label class="modern-form-label">Status</label>
            <select class="form-control modern-form-control" name="status">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i>
                <span>Filter</span>
            </button>
            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('counselor.student-submissions.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                    <i class="bi bi-x-circle"></i>
                    <span>Clear</span>
                </a>
            @endif
        </div>
    </form>
</div>

@if($submissions->count() > 0)
    <!-- Submissions Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        @foreach($submissions as $submission)
            <div class="modern-card" style="padding: 1.25rem; position: relative; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)';" onmouseout="this.style.transform=''; this.style.boxShadow='';">
                <!-- Featured Star -->
                @if($submission->is_featured)
                    <div style="position: absolute; top: 1rem; right: 1rem; color: #f59e0b; font-size: 1.25rem;">
                        <i class="bi bi-star-fill"></i>
                    </div>
                @endif
                
                <!-- Header -->
                <div style="margin-bottom: 1rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, rgba(30, 122, 74, 0.1), rgba(20, 94, 56, 0.1)); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 1.125rem; flex-shrink: 0;">
                            @if($submission->type === 'poetry')
                                <i class="bi bi-pencil-fill"></i>
                            @elseif($submission->type === 'artwork')
                                <i class="bi bi-palette-fill"></i>
                            @else
                                <i class="bi bi-camera-fill"></i>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h6 style="font-size: 1rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3;">
                                {{ $submission->title }}
                            </h6>
                            <div style="font-size: 0.75rem; display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                <span class="modern-badge modern-badge-secondary" style="font-size: 0.7rem;">
                                    {{ ucfirst($submission->type) }}
                                </span>
                                @if($submission->is_anonymous)
                                    <span class="modern-badge modern-badge-secondary" style="font-size: 0.7rem;">
                                        <i class="bi bi-incognito"></i> Anonymous
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Student Info -->
                    <div style="font-size: 0.8rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem;">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ $submission->is_anonymous ? 'Anonymous Student' : $submission->student->name }}</span>
                    </div>
                </div>
                
                <!-- Preview -->
                @if($submission->description)
                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($submission->description, 80) }}
                    </p>
                @endif
                
                <!-- Status & Meta -->
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0, 0, 0, 0.06);">
                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                        <i class="bi bi-calendar3"></i>
                        {{ $submission->created_at->format('M j, Y') }}
                    </div>
                    <span class="modern-badge modern-badge-{{ $submission->status === 'approved' ? 'success' : ($submission->status === 'rejected' ? 'danger' : 'warning') }}" style="font-size: 0.75rem;">
                        {{ ucfirst($submission->status) }}
                    </span>
                </div>
                
                <!-- Actions -->
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('counselor.student-submissions.show', $submission) }}" 
                       class="modern-btn modern-btn-primary" 
                       style="flex: 1; justify-content: center; padding: 0.625rem; font-size: 0.85rem;">
                        <i class="bi bi-eye"></i>
                        <span>Review</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($submissions->hasPages())
        <div class="d-flex justify-content-center">
            {{ $submissions->appends(request()->query())->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="modern-card" style="padding: 3rem; text-align: center;">
        <i class="bi bi-inbox" style="font-size: 3.5rem; color: var(--text-muted); opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 0.75rem;">
            @if(request()->hasAny(['search', 'type', 'status']))
                No Submissions Found
            @else
                No Submissions Yet
            @endif
        </h3>
        <p style="font-size: 0.95rem; color: var(--text-muted); margin-bottom: 2rem;">
            @if(request()->hasAny(['search', 'type', 'status']))
                No submissions match your filters. Try adjusting your search criteria.
            @else
                Student creative submissions will appear here once they submit their work.
            @endif
        </p>
        @if(request()->hasAny(['search', 'type', 'status']))
            <a href="{{ route('counselor.student-submissions.index') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-x-circle"></i>
                <span>Clear Filters</span>
            </a>
        @endif
    </div>
@endif

<style>
@media (max-width: 768px) {
    .modern-page-header-compact {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
}
</style>
@endsection
