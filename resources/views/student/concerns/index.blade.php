@extends('layouts.dashboard')

@section('title', 'My Concerns')

@section('content')
@include('student.partials.modern-styles')

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-chat-dots-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">My Concerns</h1>
            <p class="modern-page-subtitle">Track and manage your submitted concerns</p>
        </div>
        <a href="{{ route('student.spill-tea') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
            <i class="bi bi-plus-circle"></i>
            <span>New Concern</span>
        </a>
    </div>
</div>

<!-- Filters Card -->
<div class="modern-card modern-card-compact mb-4" style="padding: 1.5rem;">
    <form method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 140px; gap: 1rem; align-items: end;">
        <div>
            <input type="text" name="search" class="form-control modern-form-control" 
                   placeholder="Search concerns..." value="{{ request('search') }}">
        </div>
        <div>
            <select name="status" class="form-select modern-form-control">
                <option value="">All Statuses</option>
                <option value="submitted" {{ request('status')=='submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="under_review" {{ request('status')=='under_review' ? 'selected' : '' }}>Under Review</option>
                <option value="scheduled" {{ request('status')=='scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="resolved" {{ request('status')=='resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <div>
            <select name="category" class="form-select modern-form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="modern-btn modern-btn-primary" style="width: 100%; padding: 0.75rem 1rem; font-size: 0.95rem;">
                <i class="bi bi-funnel-fill"></i>
                <span>Filter</span>
            </button>
        </div>
    </form>
</div>

<!-- Concerns List -->
<div class="modern-card" style="padding: 1.5rem;">
    @if($concerns->count() > 0)
        <div class="modern-list">
            @foreach($concerns as $concern)
                <div class="modern-list-item" style="padding: 1rem 0;">
                    <div class="modern-list-item-main">
                        <div class="modern-list-item-title" style="font-size: 1rem;">
                            {{ $concern->title }}
                            @if($concern->is_anonymous)
                                <span class="modern-badge modern-badge-info" style="margin-left: 0.5rem; font-size: 0.75rem;">
                                    <i class="bi bi-incognito"></i>
                                    Anonymous
                                </span>
                            @endif
                        </div>
                        <div class="modern-list-item-meta" style="font-size: 0.85rem; margin-top: 0.5rem;">
                            <span class="modern-badge" style="background: rgba(30, 122, 74, 0.12); color: var(--green); font-size: 0.8rem;">
                                <i class="bi bi-tag-fill"></i>
                                {{ $concern->category->name }}
                            </span>
                            <span style="color: var(--text-muted);">
                                <i class="bi bi-clock"></i>
                                {{ $concern->created_at->diffForHumans() }}
                            </span>
                            <span style="color: var(--text-muted);">
                                <i class="bi bi-calendar3"></i>
                                {{ $concern->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        @if($concern->description)
                            <p style="margin-top: 0.5rem; margin-bottom: 0; color: var(--text-muted); font-size: 0.9rem;">
                                {{ Str::limit($concern->description, 120) }}
                            </p>
                        @endif
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($concern->status == 'resolved')
                            <span class="modern-badge modern-badge-success" style="font-size: 0.8rem;">
                                <i class="bi bi-check-circle-fill"></i>
                                Resolved
                            </span>
                        @elseif($concern->status == 'scheduled')
                            <span class="modern-badge modern-badge-info" style="font-size: 0.8rem;">
                                <i class="bi bi-calendar-check"></i>
                                Scheduled
                            </span>
                        @elseif($concern->status == 'under_review')
                            <span class="modern-badge modern-badge-purple" style="font-size: 0.8rem;">
                                <i class="bi bi-eye-fill"></i>
                                Under Review
                            </span>
                        @else
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.8rem;">
                                <i class="bi bi-hourglass-split"></i>
                                Pending
                            </span>
                        @endif
                        
                        <a href="{{ route('student.concerns.show', $concern->id) }}" 
                           class="modern-btn modern-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                            <i class="bi bi-eye"></i>
                            <span>View</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($concerns->hasPages())
            <div class="mt-4">
                {{ $concerns->links() }}
            </div>
        @endif
    @else
        <div class="modern-empty-state" style="padding: 3rem 2rem;">
            <div class="modern-empty-icon" style="width: 80px; height: 80px; font-size: 2.5rem;">
                <i class="bi bi-chat-heart"></i>
            </div>
            <h3 class="modern-empty-title" style="font-size: 1.15rem;">No Concerns Found</h3>
            <p class="modern-empty-text" style="font-size: 0.95rem;">
                @if(request()->has('search') || request()->has('status') || request()->has('category'))
                    No concerns match your filters. Try adjusting your search criteria.
                @else
                    You haven't submitted any concerns yet. When you're ready to talk, we're here to listen.
                @endif
            </p>
            <a href="{{ route('student.spill-tea') }}" class="modern-btn modern-btn-primary" style="padding: 0.75rem 1.5rem; font-size: 0.95rem;">
                <i class="bi bi-plus-circle"></i>
                <span>Submit Your First Concern</span>
            </a>
        </div>
    @endif
</div>

<style>
/* Filter form responsive */
.modern-card-compact form {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 140px;
    gap: 1rem;
    align-items: end;
}

/* Page header responsive adjustments */
@media (max-width: 768px) {
    .modern-page-header-compact {
        flex-wrap: wrap;
    }
    
    .modern-page-header-compact > a {
        width: 100%;
        margin-top: 1rem;
    }
    
    /* Filters grid - single column on mobile */
    .modern-card-compact form {
        grid-template-columns: 1fr !important;
    }
    
    .modern-card-compact form button {
        width: 100% !important;
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
    }
    
    .modern-list-item > div:last-child .modern-btn {
        width: 100%;
    }
}

@media (max-width: 1200px) and (min-width: 769px) {
    /* Tablet: 2 columns then button on second row */
    .modern-card-compact form {
        grid-template-columns: 1fr 1fr;
    }
    
    .modern-card-compact form > div:first-child {
        grid-column: span 2;
    }
    
    .modern-card-compact form > div:last-child {
        grid-column: span 2;
    }
}
</style>
@endsection
