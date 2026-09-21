@extends('layouts.dashboard')

@section('title', 'Student Submissions Review')

@section('content')
@include('student.partials.modern-styles')

<style>
.submission-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    padding: 1.25rem;
    transition: all 0.2s ease;
    position: relative;
}

.submission-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: var(--green);
}

.submission-type-badge {
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.submission-type-poetry { background: rgba(139, 92, 246, 0.1); color: #6d28d9; }
.submission-type-artwork { background: rgba(16, 185, 129, 0.1); color: #047857; }
.submission-type-photography { background: rgba(59, 130, 246, 0.1); color: #1e40af; }

.featured-star {
    position: absolute;
    top: 1rem;
    right: 1rem;
    color: #f59e0b;
    font-size: 1.25rem;
}

.submission-preview {
    background: #f8fafc;
    border-radius: 8px;
    padding: 1rem;
    margin: 1rem 0;
    border-left: 4px solid var(--green);
    font-style: italic;
    color: var(--navy);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    text-align: center;
}

@media (max-width: 768px) {
    .submissions-grid { grid-template-columns: 1fr !important; }
    .submission-filters { flex-direction: column !important; gap: 1rem !important; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<!-- Page Header -->
<div class="modern-page-header mb-4" style="padding: 1.5rem;">
    <div class="modern-page-header-compact">
        <div class="modern-page-icon" style="width: 48px; height: 48px; font-size: 1.25rem; background: linear-gradient(135deg, rgba(30, 122, 74, 0.12), rgba(20, 94, 56, 0.12)); color: var(--green);">
            <i class="bi bi-palette-fill"></i>
        </div>
        <div style="flex: 1;">
            <h1 class="modern-page-title" style="font-size: 1.5rem;">Student Creative Submissions</h1>
            <p class="modern-page-subtitle">Review and manage student poetry, artwork, and photography</p>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div style="font-size: 2rem; font-weight: 800; color: #f59e0b; margin-bottom: 0.5rem;">{{ $submissions->where('status', 'pending')->count() }}</div>
        <div style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">PENDING REVIEW</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 2rem; font-weight: 800; color: #10b981; margin-bottom: 0.5rem;">{{ $submissions->where('status', 'approved')->count() }}</div>
        <div style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">APPROVED</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 2rem; font-weight: 800; color: #8b5cf6; margin-bottom: 0.5rem;">{{ $submissions->where('is_featured', true)->count() }}</div>
        <div style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">FEATURED</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 2rem; font-weight: 800; color: var(--navy); margin-bottom: 0.5rem;">{{ $submissions->count() }}</div>
        <div style="font-size: 0.875rem; font-weight: 600; color: var(--text-muted);">TOTAL SUBMISSIONS</div>
    </div>
</div>

<!-- Filters -->
<div class="modern-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('counselor.student-submissions.index') }}" class="submission-filters" style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Search Submissions</label>
            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by title, description, or student name..." style="border-radius: 10px;">
        </div>
        
        <div style="min-width: 150px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Type</label>
            <select class="form-control" name="type" style="border-radius: 10px;">
                <option value="">All Types</option>
                <option value="poetry" {{ request('type') === 'poetry' ? 'selected' : '' }}>Poetry & Stories</option>
                <option value="artwork" {{ request('type') === 'artwork' ? 'selected' : '' }}>Artwork</option>
                <option value="photography" {{ request('type') === 'photography' ? 'selected' : '' }}>Photography</option>
            </select>
        </div>
        
        <div style="min-width: 120px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Status</label>
            <select class="form-control" name="status" style="border-radius: 10px;">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        
        <div style="min-width: 120px;">
            <label class="form-label fw-semibold" style="color: var(--navy); margin-bottom: 0.5rem;">Featured</label>
            <select class="form-control" name="featured" style="border-radius: 10px;">
                <option value="">All</option>
                <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured Only</option>
            </select>
        </div>
        
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="modern-btn modern-btn-primary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-search"></i> Filter
            </button>
            <a href="{{ route('counselor.student-submissions.index') }}" class="modern-btn modern-btn-secondary" style="padding: 0.625rem 1.25rem; font-size: 0.875rem;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>
</div>

@if($submissions->count() > 0)
    <!-- Submissions Grid -->
    <div class="submissions-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        @foreach($submissions as $submission)
            <div class="submission-card">
                @if($submission->is_featured)
                    <div class="featured-star" title="Featured Submission">
                        <i class="bi bi-star-fill"></i>
                    </div>
                @endif
                
                <div style="display: flex; align-items: start; justify-content: between; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1; min-width: 0;">
                        <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--navy); margin-bottom: 0.5rem; line-height: 1.3;">
                            {{ $submission->title }}
                        </h3>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <span class="submission-type-badge submission-type-{{ $submission->type }}">
                                {{ $submission->type_label }}
                            </span>
                            <span class="modern-badge {{ $submission->status_badge_class }}">
                                {{ ucfirst($submission->status) }}
                            </span>
                        </div>
                        <div style="font-size: 0.875rem; color: var(--text-muted);">
                            <i class="bi bi-person-fill me-1"></i>
                            {{ $submission->student->name }}
                        </div>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" style="border: none; color: var(--text-muted); padding: 0.25rem;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                            <li><a class="dropdown-item" href="{{ route('counselor.student-submissions.show', $submission) }}"><i class="bi bi-eye me-2"></i>View Details</a></li>
                            @if($submission->hasFile())
                                <li><a class="dropdown-item" href="{{ route('counselor.student-submissions.download', $submission) }}"><i class="bi bi-download me-2"></i>Download File</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button class="dropdown-item toggle-featured" 
                                        data-id="{{ $submission->id }}"
                                        data-featured="{{ $submission->is_featured ? 'unfeature' : 'feature' }}">
                                    <i class="bi bi-{{ $submission->is_featured ? 'star' : 'star-fill' }} me-2"></i>
                                    {{ $submission->is_featured ? 'Unfeature' : 'Feature' }}
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('counselor.student-submissions.destroy', $submission) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash me-2"></i>Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                
                @if($submission->description)
                    <p style="color: var(--text-muted); font-size: 0.875rem; line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($submission->description, 100) }}
                    </p>
                @endif
                
                @if($submission->type === 'poetry' && $submission->content)
                    <div class="submission-preview">
                        {{ Str::limit($submission->content, 150) }}
                    </div>
                @elseif($submission->hasFile())
                    <div style="background: #f8fafc; border-radius: 8px; padding: 1rem; margin: 1rem 0; text-align: center;">
                        @php
                            $fileIcon = match(strtolower($submission->file_type)) {
                                'jpg', 'jpeg', 'png' => 'bi-file-earmark-image-fill text-success',
                                'pdf' => 'bi-file-earmark-pdf-fill text-danger',
                                default => 'bi-file-earmark text-muted'
                            };
                        @endphp
                        <i class="bi {{ $fileIcon }}" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                        <div style="font-size: 0.875rem; color: var(--text-muted);">
                            {{ $submission->file_name }} ({{ $submission->formatted_file_size }})
                        </div>
                    </div>
                @endif
                
                <div style="display: flex; align-items: center; justify-content: between; padding-top: 1rem; border-top: 1px solid #f3f4f6; font-size: 0.75rem; color: var(--text-muted);">
                    <div>
                        <div style="font-weight: 600;">Submitted</div>
                        <div>{{ $submission->created_at->format('M j, Y') }}</div>
                    </div>
                    @if($submission->reviewed_at)
                        <div style="text-align: right;">
                            <div style="font-weight: 600;">Reviewed</div>
                            <div>{{ $submission->reviewed_at->format('M j, Y') }}</div>
                        </div>
                    @else
                        <div style="text-align: right;">
                            <span class="modern-badge modern-badge-warning" style="font-size: 0.7rem;">Needs Review</span>
                        </div>
                    @endif
                </div>
                
                @if($submission->status === 'pending')
                    <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                        <button type="button" class="modern-btn modern-btn-success quick-review" 
                                data-id="{{ $submission->id }}" 
                                data-action="approve"
                                style="flex: 1; padding: 0.5rem; font-size: 0.875rem;">
                            <i class="bi bi-check-circle"></i> Approve
                        </button>
                        <button type="button" class="modern-btn modern-btn-outline quick-review" 
                                data-id="{{ $submission->id }}" 
                                data-action="reject"
                                style="flex: 1; padding: 0.5rem; font-size: 0.875rem; color: #dc2626; border-color: #dc2626;">
                            <i class="bi bi-x-circle"></i> Reject
                        </button>
                    </div>
                @endif
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
    <div class="modern-card text-center" style="padding: 3rem;">
        <div class="modern-page-icon" style="width: 80px; height: 80px; font-size: 2rem; background: rgba(107, 114, 128, 0.1); color: var(--text-muted); margin: 0 auto 1.5rem;">
            <i class="bi bi-palette"></i>
        </div>
        <h3 style="color: var(--navy); font-weight: 700; margin-bottom: 0.5rem;">No Submissions Found</h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">
            @if(request()->hasAny(['search', 'type', 'status', 'featured']))
                Try adjusting your filters or <a href="{{ route('counselor.student-submissions.index') }}" class="text-decoration-none" style="color: var(--green);">clear all filters</a>.
            @else
                Student creative submissions will appear here for your review.
            @endif
        </p>
    </div>
@endif

<!-- Quick Review Modal -->
<div class="modal fade" id="quickReviewModal" tabindex="-1" aria-labelledby="quickReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header" style="border-bottom: 1px solid #e5e7eb; padding: 1.5rem;">
                <h5 class="modal-title" id="quickReviewModalLabel" style="font-weight: 700; color: var(--navy);">
                    Quick Review
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quickReviewForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding: 1.5rem;">
                    <input type="hidden" name="status" id="reviewStatus">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color: var(--navy);">
                            Notes (Optional)
                        </label>
                        <textarea class="form-control" name="counselor_notes" rows="3" 
                                  placeholder="Add any feedback or notes about this submission..."
                                  style="border-radius: 10px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e5e7eb; padding: 1.5rem;">
                    <button type="button" class="modern-btn modern-btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary" id="reviewSubmitBtn">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickReviewModal = new bootstrap.Modal(document.getElementById('quickReviewModal'));
    const quickReviewForm = document.getElementById('quickReviewForm');
    const reviewStatus = document.getElementById('reviewStatus');
    const reviewSubmitBtn = document.getElementById('reviewSubmitBtn');
    
    // Quick review handlers
    document.querySelectorAll('.quick-review').forEach(button => {
        button.addEventListener('click', function() {
            const submissionId = this.dataset.id;
            const action = this.dataset.action;
            
            reviewStatus.value = action === 'approve' ? 'approved' : 'rejected';
            quickReviewForm.action = `/counselor/student-submissions/${submissionId}/review`;
            
            reviewSubmitBtn.innerHTML = action === 'approve' 
                ? '<i class="bi bi-check-circle"></i> Approve Submission'
                : '<i class="bi bi-x-circle"></i> Reject Submission';
            
            reviewSubmitBtn.className = action === 'approve' 
                ? 'modern-btn modern-btn-success'
                : 'modern-btn modern-btn-danger';
                
            quickReviewModal.show();
        });
    });
    
    // Toggle featured status
    document.querySelectorAll('.toggle-featured').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const submissionId = this.dataset.id;
            const action = this.dataset.featured;
            
            if (confirm(`Are you sure you want to ${action} this submission?`)) {
                fetch(`/counselor/student-submissions/${submissionId}/toggle-featured`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update featured status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update featured status');
                });
            }
        });
    });
    
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this submission? This action cannot be undone.')) {
                this.submit();
            }
        });
    });
});
</script>
@endpush