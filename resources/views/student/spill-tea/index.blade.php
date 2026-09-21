@extends('layouts.dashboard')

@section('title', 'My Tea - All Concerns')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center"
             style="width:48px;height:48px;background:rgba(236,72,153,0.12);">
            <i class="bi bi-chat-heart-fill fs-4" style="color:#ec4899;"></i>
        </div>
        <div>
            <h4 class="fw-bold mb-0">My Tea ☕</h4>
            <p class="text-muted small mb-0">All the concerns you've shared with us</p>
        </div>
    </div>
    <a href="{{ route('student.spill-tea') }}" class="btn fw-semibold text-white"
       style="background:#ec4899;border-radius:50px;">
        <i class="bi bi-plus-circle me-2"></i>Share New Concern
    </a>
</div>

<!-- Filters -->
<div class="card border-0 shadow-sm mb-4" style="border-radius:16px;">
    <div class="card-body p-4">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted fw-semibold">Search</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by title or description..." 
                       value="{{ request('search') }}"
                       style="border-radius:12px;">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-semibold">Status</label>
                <select name="status" class="form-select" style="border-radius:12px;">
                    <option value="">All Statuses</option>
                    <option value="submitted" {{ request('status')=='submitted' ? 'selected' : '' }}>Pending</option>
                    <option value="under_review" {{ request('status')=='under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="scheduled" {{ request('status')=='scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="resolved" {{ request('status')=='resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted fw-semibold">Category</label>
                <select name="category" class="form-select" style="border-radius:12px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn w-100 fw-semibold" 
                        style="background:#ec4899;color:white;border-radius:12px;">
                    <i class="bi bi-search me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Concerns List -->
@if($concerns->count() > 0)
    <div class="row g-3">
        @foreach($concerns as $concern)
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width:48px;height:48px;background:rgba(236,72,153,0.12);">
                                            <i class="bi bi-chat-left-dots-fill" style="color:#ec4899;"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-2">{{ $concern->title }}</h6>
                                        <p class="text-muted small mb-2">{{ Str::limit($concern->description, 120) }}</p>
                                        <div class="d-flex flex-wrap gap-2 align-items-center">
                                            <span class="badge" style="background:rgba(59,130,246,0.12);color:#3b82f6;">
                                                {{ $concern->category->name }}
                                            </span>
                                            @if($concern->is_anonymous)
                                                <span class="badge" style="background:rgba(100,116,139,0.12);color:#64748b;">
                                                    <i class="bi bi-incognito me-1"></i>Anonymous
                                                </span>
                                            @endif
                                            @if($concern->attachment_path)
                                                <span class="badge" style="background:rgba(168,85,247,0.12);color:#a855f7;">
                                                    <i class="bi bi-paperclip me-1"></i>Attachment
                                                </span>
                                            @endif
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>{{ $concern->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="mb-3">
                                    @if($concern->status == 'resolved')
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-circle me-1"></i>Resolved
                                        </span>
                                    @elseif($concern->status == 'scheduled')
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="bi bi-calendar-check me-1"></i>Scheduled
                                        </span>
                                    @elseif($concern->status == 'under_review')
                                        <span class="badge bg-primary px-3 py-2">
                                            <i class="bi bi-eye me-1"></i>Under Review
                                        </span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('student.spill-tea.show', $concern->id) }}" 
                                   class="btn btn-outline-secondary fw-semibold" style="border-radius:50px;">
                                    <i class="bi bi-eye me-2"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($concerns->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $concerns->links() }}
        </div>
    @endif
@else
    <!-- Empty State -->
    <div class="card border-0 shadow-sm" style="border-radius:16px;">
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="bi bi-inbox fs-1" style="color:#ec4899;opacity:0.3;"></i>
            </div>
            <h5 class="fw-bold mb-2">No concerns yet</h5>
            <p class="text-muted mb-4">
                You haven't shared anything with us yet. Whenever you're ready, we're here to listen.
            </p>
            <a href="{{ route('student.spill-tea') }}" 
               class="btn btn-lg fw-semibold text-white"
               style="background:#ec4899;border-radius:50px;padding:.8rem 2.5rem;">
                <i class="bi bi-chat-heart me-2"></i>Share Your First Concern
            </a>
        </div>
    </div>
@endif
@endsection
